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
        \App\Models\User::create([
            'title' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);

        \App\Models\User::create([
            'title' => 'Staff', 
            'email' => 'staff@staff.com',
            'password' => bcrypt('password'),
            'role_id' => 2,
        ]);

        \App\Models\User::create([
            'title' => 'User',
            'email' => 'user@user.com', 
            'password' => bcrypt('password'),
            'role_id' => 3,
        ]);
    }
}
