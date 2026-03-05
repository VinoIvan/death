<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppointmentStatus;

class AppointmentStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['ожидание', 'принято', 'в обработке', 'отменено', 'завершено'];
        
        foreach ($statuses as $status) {
            AppointmentStatus::firstOrCreate(['name' => $status]);
        }
    }
}