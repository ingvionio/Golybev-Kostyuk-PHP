<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Администратор',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => Role::ADMIN,
        ]);

        User::factory()->create([
            'name' => 'Обычный Пользователь',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => Role::USER,
        ]);
    }
}