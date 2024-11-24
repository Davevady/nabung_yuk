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
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);

        \App\Models\User::create([
            'name' => 'Staff', 
            'email' => 'staff@staff.com',
            'password' => bcrypt('password'),
            'role_id' => 2,
        ]);

        \App\Models\User::create([
            'name' => 'User',
            'email' => 'user@user.com', 
            'password' => bcrypt('password'),
            'role_id' => 3,
        ]);
    }
}
