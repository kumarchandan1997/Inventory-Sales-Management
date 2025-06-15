<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Sales Person',
            'email' => 'sales@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'salesperson',
        ]);
    }
}
