<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisIn;
class JenisInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisIn::create([
            'user_id' => 1,
            'icon' => 'fa-solid fa-money-bill',
            'color' => '#0000ff',
            'title' => 'Gaji',
            'description' => 'Gaji dari pekerjaan',
        ]);

        JenisIn::create([
            'user_id' => 1,
            'icon' => 'fa-solid fa-money-bill',
            'color' => '#0000ff',
            'title' => 'Bonus',
            'description' => 'Bonus dari pekerjaan',
        ]);
    }
}
