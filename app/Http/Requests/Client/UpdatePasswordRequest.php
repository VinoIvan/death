<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Проверка прав пользователя на выполнение запроса
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Правила валидации для запроса
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', 'min:8'],
        ];
    }

    /**
     * Сообщения об ошибках валидации
     */
    public function messages(): array
    {
        return [
            'current_password.required' => 'Введите текущий пароль',
            'current_password.current_password' => 'Неверный текущий пароль',
            'new_password.required' => 'Введите новый пароль',
            'new_password.confirmed' => 'Пароли не совпадают',
            'new_password.min' => 'Пароль должен содержать минимум 8 символов',
        ];
    }
}