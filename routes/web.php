<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ServiceController;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Client\ReviewController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\ProfileController;

// Публичные маршруты
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
Route::post('/contacts', [ContactController::class, 'send'])->name('contacts.send');
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

// Бронирование
Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('index');
    Route::get('/create', [BookingController::class, 'create'])->name('create');
    Route::post('/', [BookingController::class, 'store'])->name('store');
    Route::get('/success/{appointment}', [BookingController::class, 'success'])->name('success');
    Route::get('/cancel/{booking_code}', [BookingController::class, 'cancel'])->name('cancel');
});

// Защищенные маршруты для авторизованных
Route::middleware(['auth'])->group(function () {
    // Профиль
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::put('/cancel-appointment/{id}', [ProfileController::class, 'cancelAppointment'])->name('cancel-appointment');
        Route::get('/reviews', [ProfileController::class, 'userReviews'])->name('reviews');
    });
    
    // Отзывы
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::get('/reviews/select-appointment', [ReviewController::class, 'selectAppointment'])->name('reviews.select-appointment');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__.'/auth.php';