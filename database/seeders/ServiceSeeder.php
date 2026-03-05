<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Лазерная эпиляция верхней губы',
                'description' => 'Безболезненное удаление волос на верхней губе. Процедура занимает всего 15 минут.',
                'price' => 1500,
                'duration' => 15,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Лазерная эпиляция подмышек',
                'description' => 'Полное удаление волос в подмышечных впадинах. Результат после первой процедуры.',
                'price' => 2500,
                'duration' => 20,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Лазерная эпиляция бикини',
                'description' => 'Классическое бикини. Деликатная зона требует особого внимания.',
                'price' => 3500,
                'duration' => 30,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Лазерная эпиляция голеней',
                'description' => 'Полное удаление волос на голенях. Гладкая кожа без раздражения.',
                'price' => 4500,
                'duration' => 40,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Лазерная эпиляция бедер',
                'description' => 'Обработка бедер полностью. Идеально для подготовки к летнему сезону.',
                'price' => 5500,
                'duration' => 50,
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['name' => $service['name']], $service);
        }
    }
}