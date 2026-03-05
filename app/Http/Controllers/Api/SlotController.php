<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    /**
     * Получение доступных слотов времени для конкретной даты
     */
    public function index(Request $request)
    {
        try {
            // Валидация входных данных
            $request->validate([
                'date' => 'required|date',
                'service_id' => 'nullable|integer|exists:services,id'
            ]);

            $date = $request->get('date');
            $serviceId = $request->get('service_id');
            
            // Очищаем дату от возможного времени
            $cleanDate = Carbon::parse($date)->format('Y-m-d');
            
            // Получаем доступные слоты
            $slots = Schedule::whereDate('date', $cleanDate)
                ->where('is_available', true)
                ->whereColumn('current_bookings', '<', 'max_bookings')
                ->when($serviceId, function ($query) use ($serviceId) {
                    return $query->where(function($q) use ($serviceId) {
                        $q->where('service_id', $serviceId)
                          ->orWhereNull('service_id');
                    });
                })
                ->orderBy('start_time')
                ->get(['id', 'start_time', 'end_time']);
            
            return response()->json($slots);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Ошибка валидации',
                'messages' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            \Log::error('Ошибка API слотов: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Ошибка сервера',
                'message' => 'Не удалось загрузить доступное время'
            ], 500);
        }
    }
}