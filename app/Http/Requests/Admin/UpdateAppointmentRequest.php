<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
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
            'status_id' => 'required|exists:appointment_statuses,id',
            'service_id' => 'required|exists:services,id',
            'client_name' => 'required|string|max:100',
            'client_phone' => 'required|string|max:20',
            'client_email' => 'nullable|email|max:100',
            'comment' => 'nullable|string|max:500',
        ];
    }

    /**
     * Сообщения об ошибках валидации
     */
    public function messages(): array
    {
        return [
            'status_id.required' => 'Выберите статус',
            'service_id.required' => 'Выберите услугу',
            'client_name.required' => 'Имя клиента обязательно',
            'client_phone.required' => 'Телефон клиента обязателен',
        ];
    }
}