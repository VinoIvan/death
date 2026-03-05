<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key_name' => 'site_name',
                'value' => 'VCM Laser',
                'type' => 'text'
            ],
            [
                'key_name' => 'site_description',
                'value' => 'Салон лазерной эпиляции в Москве',
                'type' => 'text'
            ],
            [
                'key_name' => 'booking_interval',
                'value' => '30',
                'type' => 'number'
            ],
            [
                'key_name' => 'advance_booking_days',
                'value' => '14',
                'type' => 'number'
            ],
            [
                'key_name' => 'working_days',
                'value' => '1,2,3,4,5,6',
                'type' => 'text'
            ],
            [
                'key_name' => 'working_hours_start',
                'value' => '10:00',
                'type' => 'text'
            ],
            [
                'key_name' => 'working_hours_end',
                'value' => '21:00',
                'type' => 'text'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key_name' => $setting['key_name']], $setting);
        }
    }
}