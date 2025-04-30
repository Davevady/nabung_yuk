<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            JenisInSeeder::class,
            JenisOutSeeder::class,
            CashInSeeder::class,
            CashOutSeeder::class,
            TingkatSeeder::class,
            TargetSeeder::class,
            HistoryTargetSeeder::class,
        ]);
    }
}
