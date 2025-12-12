<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@isfinance.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Borrower User
        \App\Models\User::create([
            'name' => 'Borrower User',
            'email' => 'borrower@isfinance.com',
            'password' => bcrypt('password'),
            'role' => 'borrower',
            'email_verified_at' => now(),
        ]);

        // Create additional test borrowers
        \App\Models\User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => 'borrower',
            'email_verified_at' => now(),
        ]);

        \App\Models\User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
            'role' => 'borrower',
            'email_verified_at' => now(),
        ]);
    }
}
