<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        
        User::firstOrCreate(
            ['email' => 'admin@vcm-las.ru'],
            [
                'name' => 'Администратор',
                'phone' => '+7 (999) 111-11-11',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRole->id,
            ]
        );

        $userRole = Role::where('name', 'registered')->first();
        
        User::firstOrCreate(
            ['email' => 'ivan@example.com'],
            [
                'name' => 'Иван Петров',
                'phone' => '+7 (999) 222-33-44',
                'password' => Hash::make('user123'),
                'role_id' => $userRole->id,
            ]
        );
    }
}