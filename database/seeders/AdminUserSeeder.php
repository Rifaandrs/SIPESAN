<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('SIPESAN_ADMIN_PASSWORD');

        if (app()->environment('production') && blank($password)) {
            throw new RuntimeException('Set SIPESAN_ADMIN_PASSWORD before creating the initial admin account in production.');
        }

        // Akun Utama Wakasek Humas
        User::updateOrCreate(
            ['name' => 'Wakasek Humas SMPN 2 Purwakarta'],
            [
                'password' => Hash::make($password ?: 'SipesanAdmin!2026'),
                'role' => 'admin',
            ]
        );

        // 1. Akun Admin: Humas Spenda
        User::updateOrCreate(
            ['name' => 'Humas Spenda'],
            [
                'password' => Hash::make('Smpn2Pwk2026'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Admin: Admin
        User::updateOrCreate(
            ['name' => 'Admin'],
            [
                'password' => Hash::make('Admin123'),
                'role' => 'admin',
            ]
        );

        // 3. Akun Admin: Admin 2
        User::updateOrCreate(
            ['name' => 'Admin 2'],
            [
                'password' => Hash::make('admin321'),
                'role' => 'admin',
            ]
        );
    }
}
