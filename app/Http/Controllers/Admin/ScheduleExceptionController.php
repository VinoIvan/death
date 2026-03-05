<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScheduleException;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleExceptionController extends Controller
{
    /**
     * Отображение списка исключений
     */
    public function index()
    {
        $exceptions = ScheduleException::with('creator')
            ->orderBy('date', 'desc')
            ->paginate(15);
        
        return view('admin.schedule-exceptions.index', compact('exceptions'));
    }

    /**
     * Сохранение нового исключения
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|unique:schedule_exceptions,date',
            'is_working_day' => 'required|boolean',
            'comment' => 'nullable|string|max:255',
        ]);

        ScheduleException::create([
            'date' => $request->date,
            'is_working_day' => $request->is_working_day,
            'comment' => $request->comment,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.schedule-exceptions.index')
            ->with('success', 'Исключение успешно добавлено!');
    }

    /**
     * Удаление исключения
     */
    public function destroy(ScheduleException $scheduleException)
    {
        $scheduleException->delete();

        return redirect()->route('admin.schedule-exceptions.index')
            ->with('success', 'Исключение успешно удалено!');
    }
}