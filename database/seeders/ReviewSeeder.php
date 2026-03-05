<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Appointment;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role_id', 2)->get(); 
        
        if ($users->isEmpty()) {
            $this->command->error('Нет пользователей для создания отзывов!');
            return;
        }

        $appointments = Appointment::whereHas('status', function($q) {
            $q->where('name', 'завершено');
        })->get();

        $reviews = [
            [
                'rating' => 5,
                'comment' => 'Отличный салон! Делала лазерную эпиляцию в первый раз, очень понравилось. Внимательный персонал, современное оборудование. Результат превзошел ожидания!',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'rating' => 5,
                'comment' => 'Хожу сюда уже полгода, очень довольна результатом. Кожа гладкая, никаких проблем. Рекомендую всем подругам!',
                'created_at' => Carbon::now()->subDays(12),
            ],
            [
                'rating' => 4,
                'comment' => 'Хороший салон, чисто, уютно. Мастер профессионал, все объяснила, рассказала. Немного дороговато, но качество того стоит.',
                'created_at' => Carbon::now()->subDays(18),
            ],
            [
                'rating' => 5,
                'comment' => 'Прекрасное место! Очень приятная атмосфера, девушки на ресепшене приветливые. Процедура прошла комфортно, результат виден сразу. Обязательно приду еще!',
                'created_at' => Carbon::now()->subDays(25),
            ],
            [
                'rating' => 5,
                'comment' => 'Лучший салон в городе! Делаю лазерную эпиляцию уже 3 года, результат отличный. Персонал всегда вежливый, цены адекватные. Спасибо!',
                'created_at' => Carbon::now()->subDays(32),
            ],
        ];

        foreach ($reviews as $reviewData) {
            $user = $users->random();
            $appointment = $appointments->where('user_id', $user->id)->first();
            
            Review::create([
                'user_id' => $user->id,
                'appointment_id' => $appointment ? $appointment->id : null,
                'rating' => $reviewData['rating'],
                'comment' => $reviewData['comment'],
                'is_approved' => true,
                'created_at' => $reviewData['created_at'],
                'updated_at' => $reviewData['created_at'],
            ]);
        }

        $this->command->info('Создано 5 тестовых отзывов!');
    }
}