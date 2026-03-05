<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SlotController;


// Публичное API для получения слотов времени
Route::get('/slots', [SlotController::class, 'index'])->name('api.slots');

// Защищенное API (если понадобится в будущем)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});