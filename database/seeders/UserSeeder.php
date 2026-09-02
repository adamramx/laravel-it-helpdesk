<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@helpdesk.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'IT Support',
            'email' => 'teknisi@helpdesk.test',
            'password' => Hash::make('password'),
            'role' => 'it_support',
        ]);

        User::create([
            'name' => 'User Helpdesk',
            'email' => 'user@helpdesk.test',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}