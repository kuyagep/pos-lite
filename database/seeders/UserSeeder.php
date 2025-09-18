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
        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@poslite.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_SUPER_ADMIN,
        ]);

        // Store Admin
        User::create([
            'name' => 'Store Admin',
            'email' => 'storeadmin@poslite.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_STORE_ADMIN,
        ]);

        // Staff
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@poslite.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_STAFF,
        ]);
    }
}
