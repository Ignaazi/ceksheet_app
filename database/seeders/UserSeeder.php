<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin (NIK: 24096065)
        User::create([
            'nik' => '24096065',
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        // 2. Akun Leader
        User::create([
            'nik' => '24096066',
            'name' => 'Leader Engineering',
            'email' => 'leader@example.com',
            'role' => 'leader',
            'password' => Hash::make('password123'),
        ]);

        // 3. Akun Staff
        User::create([
            'nik' => '24096067',
            'name' => 'Staff Engineering',
            'email' => 'staff@example.com',
            'role' => 'staff',
            'password' => Hash::make('password123'),
        ]);
    }
}