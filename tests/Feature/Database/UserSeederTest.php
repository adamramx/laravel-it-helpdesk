<?php

use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;

test('user seeder can run more than once', function () {
    $this->seed(UserSeeder::class);
    $this->seed(UserSeeder::class);

    expect(DB::table('users')->count())->toBe(3)
        ->and(DB::table('users')->where('email', 'teknisi@helpdesk.test')->value('role'))
        ->toBe('it_support');
});
