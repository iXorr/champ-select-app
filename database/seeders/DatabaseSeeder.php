<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'full_name' => 'Администратор',
            'login' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'kofeman',
            'role' => 'admin',
        ]);

        
        User::create([
            'full_name' => 'Менеджер - 1',
            'login' => 'manager1',
            'email' => 'manager1@example.com',
            'password' => 'manager2026',
            'role' => 'manager',
        ]);
        
        User::create([
            'full_name' => 'Менеджер - 2',
            'login' => 'manager2',
            'email' => 'manager2@example.com',
            'password' => 'manager20262',
            'role' => 'manager',
        ]);
    }
}
