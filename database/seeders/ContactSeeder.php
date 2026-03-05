<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        // Очищаем таблицу
        Contact::truncate();

        $contacts = [
            [
                'type' => 'phone',
                'phone_1' => '+7 (999) 123-45-67',
                'phone_2' => '+7 (999) 765-43-21',
                'icon' => 'fas fa-phone',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'type' => 'work_time',
                'work_days_week' => 'Пн-Пт',
                'work_days_weekend' => 'Сб-Вс',
                'work_hours_week' => '10:00-21:00',
                'work_hours_weekend' => '11:00-19:00',
                'icon' => 'fas fa-clock',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'type' => 'email',
                'value' => 'info@vcm-laser.ru',
                'icon' => 'fas fa-envelope',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'type' => 'address',
                'value' => 'г. Москва, ул. Лазерная, д. 10',
                'icon' => 'fas fa-map-marker-alt',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}