<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Маршруты для неавторизованных пользователей (гости)
Route::middleware('guest')->group(function () {
    // Вход в систему
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Регистрация нового пользователя
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Восстановление пароля
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request'); // Форма запроса ссылки для сброса пароля
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email'); // Отправка ссылки для сброса пароля на email

    // Сброс пароля
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset'); // Форма установки нового пароля с токеном
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update'); // Обновление пароля в базе данных
});

// Маршруты для авторизованных пользователей
Route::middleware('auth')->group(function () {
    // Выход из системы
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});