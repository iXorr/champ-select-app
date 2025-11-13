<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['login' => 'admin'],
            [
                'name' => 'Администратор',
                'full_name' => 'Администратор Системы',
                'email' => 'admin@flowers.local',
                'phone' => '+7(900)-000-00-00',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]
        );
    }
}
