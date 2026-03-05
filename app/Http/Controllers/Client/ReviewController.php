<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Appointment;
use App\Http\Requests\Client\StoreReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Отображение списка отзывов
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'appointment.service']);
        
        // Фильтр по рейтингу
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        // Сортировка по дате (сначала новые)
        $reviews = $query->latest()->paginate(9);
        
        return view('client.reviews.index', compact('reviews'));
    }

    /**
     * Показ формы выбора записи для отзыва
     */
    public function selectAppointment()
    {
        $appointments = Appointment::where('user_id', auth()->id())
            ->whereHas('status', function($q) {
                $q->where('name', 'завершено');
            })
            ->whereDoesntHave('review')
            ->with('service')
            ->latest()
            ->get();
            
        return view('client.reviews.select-appointment', compact('appointments'));
    }

    /**
     * Показ формы создания нового отзыва
     */
    public function create(Request $request)
    {
        // Если передан ID записи, проверяем что она принадлежит пользователю
        if ($request->has('appointment_id')) {
            $appointment = Appointment::where('id', $request->appointment_id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
                
            if ($appointment->review) {
                return redirect()->route('profile.history')
                    ->with('error', 'Вы уже оставили отзыв на эту запись.');
            }
            
            return view('client.reviews.create', compact('appointment'));
        }
        
        // Если не передан ID записи, перенаправляем на выбор записи
        return redirect()->route('reviews.select-appointment');
    }

    /**
     * Сохранение нового отзыва
     */
    public function store(StoreReviewRequest $request)
    {
        $review = Review::create([
            'user_id' => auth()->id(),
            'appointment_id' => $request->appointment_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true,
        ]);

        return redirect()->route('reviews.index')
            ->with('success', 'Спасибо за ваш отзыв!');
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

    /**
     * Удаление отзыва
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();

        return redirect()->route('profile.reviews')
            ->with('success', 'Отзыв успешно удален.');
    }
}