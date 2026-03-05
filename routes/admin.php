<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\Auth\LoginController;


Route::prefix('ad')->name('admin.')->group(function () {
    
    // Маршруты для неавторизованных пользователей - перенаправление на обычную страницу входа
    Route::redirect('/login', '/login')->name('login');
    
    Route::middleware(['auth', 'admin'])->group(function () {
        
        // Перенаправление с главной страницы админки на список записей
        Route::redirect('/', '/ad/appointments')->name('dashboard');
        
        Route::prefix('api')->name('api.')->group(function () {
            // Получение доступных слотов времени для выбранной услуги
            Route::get('/slots', [AppointmentController::class, 'getSlots'])->name('slots');
        });
        
        Route::resource('appointments', AppointmentController::class);
        // Обновление статуса записи
        Route::put('appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])
            ->name('appointments.status');
        
        Route::resource('services', ServiceController::class);
        
        Route::resource('schedules', ScheduleController::class);
        
        Route::resource('users', UserController::class);
        
        Route::resource('reviews', ReviewController::class)->except(['create', 'store']);
        
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});