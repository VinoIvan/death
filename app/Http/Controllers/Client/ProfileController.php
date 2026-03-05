<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Appointment;
use App\Models\Review;
use App\Models\AppointmentStatus;

class ProfileController extends Controller
{
    /**
     * Отображение личного кабинета пользователя
     */
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'total_visits' => Appointment::where('user_id', $user->id)->count(),
            'completed_visits' => Appointment::where('user_id', $user->id)
                ->whereHas('status', fn($q) => $q->where('name', 'завершено'))
                ->count(),
            'upcoming_visits' => Appointment::where('user_id', $user->id)
                ->whereHas('schedule', fn($q) => $q->where('date', '>=', now()))
                ->whereHas('status', fn($q) => $q->whereNotIn('name', ['отменено', 'завершено']))
                ->count(),
            'reviews_count' => Review::where('user_id', $user->id)->count(),
        ];
        
        $recentAppointments = Appointment::where('user_id', $user->id)
            ->with(['service', 'schedule', 'status'])
            ->latest()
            ->take(5)
            ->get();
        
        // Получаем завершенные посещения
        $completedAppointments = Appointment::where('user_id', $user->id)
            ->with(['service', 'schedule', 'status', 'review'])
            ->whereHas('status', function($q) {
                $q->where('name', 'завершено');
            })
            ->join('schedules', 'appointments.schedule_id', '=', 'schedules.id')
            ->orderBy('schedules.date', 'desc')
            ->select('appointments.*')
            ->take(5)
            ->get();
        
        return view('client.profile.index', compact('user', 'stats', 'recentAppointments', 'completedAppointments'));
    }

    /**
     * Показ формы редактирования профиля
     */
    public function edit()
    {
        $user = Auth::user();
        return view('client.profile.edit', compact('user'));
    }

    /**
     * Обновление данных профиля пользователя
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:20', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Профиль успешно обновлен!');
    }

    /**
     * Обновление пароля пользователя
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', 'min:8'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Пароль успешно изменен!');
    }

    /**
     * Отмена записи на услугу
     */
    public function cancelAppointment($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        if ($appointment->status->name === 'отменено') {
            return response()->json(['success' => false, 'message' => 'Запись уже отменена']);
        }
        
        if ($appointment->schedule->date < now()->format('Y-m-d')) {
            return response()->json(['success' => false, 'message' => 'Нельзя отменить прошедшую запись']);
        }
        
        $canceledStatus = AppointmentStatus::where('name', 'отменено')->first();
        $appointment->update(['status_id' => $canceledStatus->id]);
        
        $appointment->schedule->decrement('current_bookings');
        
        return response()->json(['success' => true, 'message' => 'Запись отменена']);
    }

    /**
     * Отображение отзывов пользователя
     */
    public function userReviews()
    {
        $reviews = Review::where('user_id', auth()->id())
            ->with('appointment.service')
            ->latest()
            ->paginate(10);
            
        return view('client.profile.reviews', compact('reviews'));
    }
}