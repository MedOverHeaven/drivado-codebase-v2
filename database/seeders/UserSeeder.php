<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Drivado',
            'email' => 'admin@drivado.com',
            'password' => Hash::make('password'),
            'phone' => '0600000000',
            'role' => 'admin',
        ]);

        // Agencies
        User::create([
            'name' => 'Oujda Rent Agency',
            'email' => 'agency1@example.com',
            'password' => Hash::make('password'),
            'phone' => '0611111111',
            'role' => 'agency',
        ]);

        User::create([
            'name' => 'Berkane Auto',
            'email' => 'agency2@example.com',
            'password' => Hash::make('password'),
            'phone' => '0622222222',
            'role' => 'agency',
        ]);

        // Regular Users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'phone' => '0633333333',
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'phone' => '0644444444',
            'role' => 'user',
        ]);
    }
}
