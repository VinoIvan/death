<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\ScheduleTemplate;
use App\Models\ScheduleException;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Отображение списка слотов расписания
     */
    public function index(Request $request)
    {
        $date = $request->get('date') ? Carbon::parse($request->date) : Carbon::today();
        
        $schedules = Schedule::with('service')
            ->whereDate('date', $date)
            ->orderBy('start_time')
            ->paginate(20);
        
        $services = Service::orderBy('name')->get();
        
        return view('admin.schedules.index', compact('schedules', 'date', 'services'));
    }

    /**
     * Показ формы создания нового слота
     */
    public function create(Request $request)
    {
        $services = Service::orderBy('name')->get();
        $defaultDate = $request->get('date') ?? now()->format('Y-m-d');
        
        return view('admin.schedules.create', compact('services', 'defaultDate'));
    }

    /**
     * Сохранение нового слота в расписании
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'service_id' => 'nullable|exists:services,id',
        ]);

        // Проверка на пересечение
        $exists = Schedule::whereDate('date', $request->date)
            ->whereTime('start_time', '<', $request->end_time)
            ->whereTime('end_time', '>', $request->start_time)
            ->exists();
        
        if ($exists) {
            return back()->with('error', 'Это время пересекается с существующим слотом!')->withInput();
        }

        Schedule::create([
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'service_id' => $request->service_id,
            'max_bookings' => 1,
            'current_bookings' => 0,
            'is_available' => true,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.schedules.index', ['date' => $request->date])
            ->with('success', 'Слот времени успешно создан!');
    }

    /**
     * Показ формы редактирования слота
     */
    public function edit(Schedule $schedule)
    {
        $services = Service::orderBy('name')->get();
        return view('admin.schedules.edit', compact('schedule', 'services'));
    }

    /**
     * Обновление слота в расписании
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'service_id' => 'nullable|exists:services,id',
        ]);

        $schedule->update([
            'service_id' => $request->service_id,
        ]);

        return redirect()->route('admin.schedules.index', ['date' => $schedule->date])
            ->with('success', 'Слот времени успешно обновлен!');
    }

    /**
     * Удаление слота из расписания
     */
    public function destroy(Schedule $schedule)
    {
        if ($schedule->appointments()->whereHas('status', function($q) {
            $q->whereNotIn('name', ['отменено', 'завершено']);
        })->exists()) {
            return back()->with('error', 'Нельзя удалить слот с активными записями!');
        }

        $date = $schedule->date;
        $schedule->delete();

        return redirect()->route('admin.schedules.index', ['date' => $date])
            ->with('success', 'Слот времени успешно удален!');
    }
}