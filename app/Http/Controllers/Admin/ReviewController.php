<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
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
        $reviews = $query->latest()->paginate(15);
        
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Удаление отзыва
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Отзыв успешно удален!');
    }
}