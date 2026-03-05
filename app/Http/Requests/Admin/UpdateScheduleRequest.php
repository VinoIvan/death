<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
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
            'max_bookings' => 'required|integer|min:' . $this->schedule->current_bookings . '|max:10',
            'is_available' => 'boolean',
        ];
    }

    /**
     * Сообщения об ошибках валидации
     */
    public function messages(): array
    {
        return [
            'max_bookings.required' => 'Максимальное количество записей обязательно',
            'max_bookings.min' => 'Не может быть меньше текущего количества записей',
        ];
    }
}