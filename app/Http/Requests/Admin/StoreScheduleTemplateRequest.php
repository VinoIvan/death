<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleTemplateRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'day_of_week' => 'required|integer|between:1,7',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'service_id' => 'nullable|exists:services,id',
            'max_bookings' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Сообщения об ошибках валидации
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Название шаблона обязательно',
            'day_of_week.required' => 'Выберите день недели',
            'start_time.required' => 'Укажите время начала',
            'end_time.required' => 'Укажите время окончания',
            'end_time.after' => 'Время окончания должно быть позже времени начала',
            'max_bookings.required' => 'Укажите максимальное количество записей',
        ];
    }
}