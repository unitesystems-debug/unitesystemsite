<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@unitesystemsllc.com'],
            [
                'name' => 'Site Admin',
                'password' => 'Password123!',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
