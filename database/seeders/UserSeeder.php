<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin Utama
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@coffeecafe.com',
            'password' => Hash::make('password'), // Ganti 'password' dengan password yang kuat
            'role' => 'admin', // Role: Admin
        ]);

        // 2. Akun Kasir Contoh
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@coffeecafe.com',
            'password' => Hash::make('password'),
            'role' => 'kasir', // Role: Kasir
        ]);
    }
}
