<?php

namespace Database\Seeders;

use App\Models\Tingkat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TingkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tingkat::create([
            'user_id' => 1,
            'title' => 'Priority',
            'icon' => 'fa-solid fa-exclamation-circle',
            'color' => 'primary',
            'description' => 'Prioritas Utama',
        ]);

        Tingkat::create([
            'user_id' => 1,
            'title' => 'High',
            'icon' => 'fa-solid fa-arrow-up',
            'color' => 'primary',
            'description' => 'Prioritas Tinggi',
        ]);

        Tingkat::create([
            'user_id' => 1,
            'title' => 'Medium',
            'icon' => 'fa-solid fa-minus',
            'color' => 'primary',
            'description' => 'Prioritas Sedang',
        ]);

        Tingkat::create([
            'user_id' => 1,
            'title' => 'Low',
            'icon' => 'fa-solid fa-arrow-down',
            'color' => 'primary',
            'description' => 'Prioritas Rendah',
        ]);
    }
}
