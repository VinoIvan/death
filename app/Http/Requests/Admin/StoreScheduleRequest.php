<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
{
    /**
     * Проверка прав пользователя на выполнение запроса
     */
    public function authorize(): bool
    {
        return auth()->user() && auth()->user()->isAdmin();
    }

    /**
     * Правила валидации для запроса
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'service_id' => 'nullable|exists:services,id',
            'max_bookings' => 'required|integer|min:1|max:10',
        ];
    }

    /**
     * Сообщения об ошибках валидации
     */
    public function messages(): array
    {
        return [
            'date.required' => 'Дата обязательна',
            'date.after_or_equal' => 'Дата не может быть в прошлом',
            'start_time.required' => 'Время начала обязательно',
            'end_time.required' => 'Время окончания обязательно',
            'end_time.after' => 'Время окончания должно быть позже времени начала',
            'service_id.exists' => 'Выбранная услуга не существует',
            'max_bookings.required' => 'Максимальное количество записей обязательно',
            'max_bookings.min' => 'Минимум 1 запись',
            'max_bookings.max' => 'Максимум 10 записей',
        ];
    }
}