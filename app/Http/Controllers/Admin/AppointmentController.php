<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\Service;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Отображение списка записей
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['user', 'service', 'status', 'schedule']);
        
        // Фильтр по дате
        if ($request->filled('date')) {
            $query->whereHas('schedule', function($q) use ($request) {
                $q->whereDate('date', Carbon::parse($request->date));
            });
        }
        
        // Фильтр по статусу
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }
        
        // Фильтр по услуге
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }
        
        // Поиск по имени/телефону
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('client_phone', 'like', "%{$search}%")
                  ->orWhere('client_email', 'like', "%{$search}%");
            });
        }
        
        $appointments = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $statuses = AppointmentStatus::all();
        $services = Service::orderBy('name')->get();
        
        return view('admin.appointments.index', compact('appointments', 'statuses', 'services'));
    }

    /**
     * Показ формы создания новой записи
     */
    public function create(Request $request)
    {
        $services = Service::orderBy('name')->get();
        $statuses = AppointmentStatus::all();
        
        return view('admin.appointments.create', compact('services', 'statuses'));
    }

    /**
     * Сохранение новой записи в базе данных
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'schedule_id' => 'required|exists:schedules,id',
            'client_name' => 'required|string|max:100',
            'client_phone' => 'required|string|max:20',
            'client_email' => 'nullable|email|max:100',
            'comment' => 'nullable|string|max:500',
            'status_id' => 'required|exists:appointment_statuses,id',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);
        
        if ($schedule->current_bookings >= $schedule->max_bookings) {
            return back()->with('error', 'Это время уже занято. Выберите другое время.')->withInput();
        }

        $appointment = Appointment::create([
            'user_id' => null,
            'service_id' => $request->service_id,
            'schedule_id' => $schedule->id,
            'status_id' => $request->status_id,
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'client_email' => $request->client_email,
            'comment' => $request->comment,
        ]);
        
        $schedule->increment('current_bookings');

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Запись успешно создана!');
    }

    /**
     * Отображение конкретной записи
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['user', 'service', 'status', 'schedule', 'review']);
        
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Показ формы редактирования записи
     */
    public function edit(Appointment $appointment)
    {
        $statuses = AppointmentStatus::all();
        $services = Service::orderBy('name')->get();
        
        return view('admin.appointments.edit', compact('appointment', 'statuses', 'services'));
    }

    /**
     * Обновление записи в базе данных
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status_id' => 'required|exists:appointment_statuses,id',
            'service_id' => 'required|exists:services,id',
            'client_name' => 'required|string|max:100',
            'client_phone' => 'required|string|max:20',
            'client_email' => 'nullable|email|max:100',
            'comment' => 'nullable|string|max:500',
        ]);

        $oldStatus = $appointment->status_id;
        $oldStatusName = $appointment->status->name;
        
        $appointment->update($request->only([
            'status_id', 'service_id', 'client_name', 
            'client_phone', 'client_email', 'comment'
        ]));

        // Если статус изменился
        if ($oldStatus != $request->status_id) {
            $newStatus = AppointmentStatus::find($request->status_id);
            
            // Если статус изменился на "отменено", уменьшаем счетчик
            if ($newStatus && $newStatus->name == 'отменено' && $oldStatusName != 'отменено') {
                if ($appointment->schedule->current_bookings > 0) {
                    $appointment->schedule->decrement('current_bookings');
                }
            }
            
            // Если статус меняется с "отменено" на другой, увеличиваем счетчик
            if ($oldStatusName == 'отменено' && $newStatus && $newStatus->name != 'отменено') {
                $appointment->schedule->increment('current_bookings');
            }
        }

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Запись успешно обновлена!');
    }

    /**
     * Обновление статуса записи (AJAX)
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status_id' => 'required|exists:appointment_statuses,id',
        ]);

        try {
            $oldStatus = $appointment->status_id;
            $oldStatusName = $appointment->status->name;
            $appointment->update(['status_id' => $request->status_id]);
            
            $newStatus = AppointmentStatus::find($request->status_id);

            // Если статус изменился
            if ($oldStatus != $request->status_id) {
                // Если статус изменился на "отменено" и раньше не был отменен
                if ($newStatus && $newStatus->name == 'отменено' && $oldStatusName != 'отменено') {
                    if ($appointment->schedule->current_bookings > 0) {
                        $appointment->schedule->decrement('current_bookings');
                    }
                }
                
                // Если статус меняется с "отменено" на другой, увеличиваем счетчик
                if ($oldStatusName == 'отменено' && $newStatus && $newStatus->name != 'отменено') {
                    $appointment->schedule->increment('current_bookings');
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error updating appointment status: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Удаление записи
     */
    public function destroy(Appointment $appointment)
    {
        // Уменьшаем счетчик только если статус не "отменено" и current_bookings > 0
        if ($appointment->status->name != 'отменено' && $appointment->schedule->current_bookings > 0) {
            $appointment->schedule->decrement('current_bookings');
        }
        
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Запись успешно удалена!');
    }

    /**
     * Получение доступных слотов для выбранной услуги (AJAX)
     */
    public function getSlots(Request $request)
    {
        $serviceId = $request->get('service_id');
        
        $slots = Schedule::where('date', '>=', Carbon::today())
            ->where('is_available', true)
            ->whereColumn('current_bookings', '<', 'max_bookings')
            ->when($serviceId, function ($query) use ($serviceId) {
                return $query->where(function($q) use ($serviceId) {
                    $q->where('service_id', $serviceId)
                      ->orWhereNull('service_id');
                });
            })
            ->orderBy('date')
            ->orderBy('start_time')
            ->get(['id', 'date', 'start_time', 'end_time', 'max_bookings', 'current_bookings']);
        
        // Добавляем информацию о доступности
        $slots = $slots->map(function($slot) {
            $slot->available = $slot->max_bookings - $slot->current_bookings;
            return $slot;
        });
        
        return response()->json($slots);
    }
}