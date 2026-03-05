<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Проверка прав пользователя на выполнение запроса
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Правила валидации для запроса
     */
    public function rules(): array
    {
        return [
            'service_id' => ['required', 'exists:services,id'],
            'schedule_id' => ['required', 'exists:schedules,id'],
            'client_name' => ['required', 'string', 'max:100'],
            'client_phone' => ['required', 'string', 'max:20', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'client_email' => ['nullable', 'email', 'max:100'],
            'comment' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Сообщения об ошибках валидации
     */
    public function messages(): array
    {
        return [
            'client_name.required' => 'Укажите ваше имя',
            'client_phone.required' => 'Укажите номер телефона',
            'client_phone.regex' => 'Введите корректный номер телефона',
            'client_email.email' => 'Введите корректный email адрес',
            'service_id.required' => 'Выберите услугу',
            'service_id.exists' => 'Выбранная услуга не существует',
            'schedule_id.required' => 'Выберите время',
            'schedule_id.exists' => 'Выбранное время недоступно',
        ];
    }
}