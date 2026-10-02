<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@helpdesk.test',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'IT Support',
                'email' => 'teknisi@helpdesk.test',
                'password' => Hash::make('password'),
                'role' => 'it_support',
            ],
            [
                'name' => 'User Helpdesk',
                'email' => 'user@helpdesk.test',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'role' => $user['role'],
                ],
            );
        }
    }
}
