<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'appointment_id' => ['nullable', 'exists:appointments,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
        ];
    }

    /**
     * Сообщения об ошибках валидации
     */
    public function messages(): array
    {
        return [
            'rating.required' => 'Пожалуйста, поставьте оценку',
            'rating.min' => 'Оценка должна быть от 1 до 5',
            'rating.max' => 'Оценка должна быть от 1 до 5',
            'comment.required' => 'Напишите ваш отзыв',
            'comment.min' => 'Отзыв должен содержать минимум 10 символов',
            'comment.max' => 'Отзыв не должен превышать 1000 символов',
        ];
    }
}