<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreBookingRequest;
use App\Models\Service;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\AppointmentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Показ первого шага бронирования - выбор услуги
     */
    public function index(Request $request)
    {
        // Получаем все услуги, отсортированные по порядку
        $services = Service::orderBy('sort_order')->get();
        $selectedService = null;
        $availableDates = [];
        
        // Если выбрана услуга, загружаем доступные даты
        if ($request->has('service_id')) {
            $selectedService = Service::find($request->service_id);
            
            if ($selectedService) {
                $availableDates = Schedule::where(function($q) use ($selectedService) {
                        $q->where('service_id', $selectedService->id)
                          ->orWhereNull('service_id');
                    })
                    ->where('date', '>=', Carbon::today())
                    ->where('is_available', true)
                    ->whereColumn('current_bookings', '<', 'max_bookings')
                    ->orderBy('date')
                    ->orderBy('start_time')
                    ->get()
                    ->groupBy('date');
            }
        }
        
        return view('client.booking.index', compact('services', 'selectedService', 'availableDates'));
    }
    
    /**
     * Показ второго шага бронирования - форма данных клиента
     */
    public function create(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        $service = Service::findOrFail($request->service_id);
        $schedule = Schedule::findOrFail($request->schedule_id);
        
        // Проверка доступности места
        if (!$schedule->hasAvailableSeats()) {
            return redirect()->route('booking.index')
                ->with('error', 'Это время уже недоступно для бронирования.');
        }
        
        return view('client.booking.create', compact('service', 'schedule'));
    }
    
    /**
     * Сохранение новой записи на услугу
     */
    public function store(StoreBookingRequest $request)
    {
        return DB::transaction(function () use ($request) {
            // Блокируем запись для избежания двойного бронирования
            $schedule = Schedule::lockForUpdate()->find($request->schedule_id);
            
            if (!$schedule->hasAvailableSeats()) {
                return back()->with('error', 'Это время уже занято. Пожалуйста, выберите другое время.')
                    ->withInput();
            }
            
            // Получаем статус "ожидание"
            $status = AppointmentStatus::where('name', 'ожидание')->first();
            
            if (!$status) {
                throw new \Exception('Статус "ожидание" не найден');
            }
            
            // Создаем запись
            $appointment = Appointment::create([
                'user_id' => auth()->id(),
                'service_id' => $request->service_id,
                'schedule_id' => $schedule->id,
                'status_id' => $status->id,
                'client_name' => $request->client_name,
                'client_phone' => $request->client_phone,
                'client_email' => $request->client_email,
                'comment' => $request->comment,
            ]);
            
            // Увеличиваем счетчик записей
            $schedule->increment('current_bookings');
            
            // Сохраняем выбранную дату в сессию для подсветки в календаре
            session(['selected_date' => $schedule->date->format('Y-m-d')]);
            
            return redirect()->route('booking.success', $appointment)
                ->with('success', 'Вы успешно записаны на услугу!');
        });
    }
    
    /**
     * Показ страницы успешного бронирования
     */
    public function success(Appointment $appointment)
    {
        // Проверяем, что пользователь имеет доступ к этой записи
        if ($appointment->user_id !== auth()->id() && 
            $appointment->client_email !== auth()->user()?->email) {
            abort(403);
        }
        
        return view('client.booking.success', compact('appointment'));
    }
    
    /**
     * Отмена записи по коду бронирования
     */
    public function cancel($booking_code)
    {
        $appointment = Appointment::where('booking_code', $booking_code)->firstOrFail();
        
        if ($appointment->status->name === 'отменено') {
            return redirect()->route('home')
                ->with('info', 'Эта запись уже была отменена ранее.');
        }
        
        // Нельзя отменить прошедшую запись
        if ($appointment->schedule->date < Carbon::today()) {
            return redirect()->route('home')
                ->with('error', 'Нельзя отменить прошедшую запись.');
        }
        
        return DB::transaction(function () use ($appointment) {
            $canceledStatus = AppointmentStatus::where('name', 'отменено')->first();
            $appointment->update(['status_id' => $canceledStatus->id]);
            
            $schedule = $appointment->schedule;
            $schedule->decrement('current_bookings');
            
            return redirect()->route('home')
                ->with('success', 'Запись успешно отменена.');
        });
    }

    /**
     * Получение доступных слотов времени для конкретной даты (AJAX)
     */
    public function getSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'service_id' => 'nullable|exists:services,id',
        ]);

        $slots = Schedule::whereDate('date', $request->date)
            ->where('is_available', true)
            ->whereColumn('current_bookings', '<', 'max_bookings')
            ->when($request->service_id, function ($query) use ($request) {
                return $query->where(function($q) use ($request) {
                    $q->where('service_id', $request->service_id)
                      ->orWhereNull('service_id');
                });
            })
            ->orderBy('start_time')
            ->get(['id', 'start_time', 'end_time']);

        return response()->json($slots);
    }
}