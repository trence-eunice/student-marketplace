<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@studentmarketplace.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Trence Eunice',
            'email' => 'trence@studentmarketplace.com',
            'password' => Hash::make('password123'),
            'role' => 'seller',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Geeanne Gerona',
            'email' => 'geeanne@studentmarketplace.com',
            'password' => Hash::make('password123'),
            'role' => 'buyer',
            'is_active' => true,
        ]);
    }
}