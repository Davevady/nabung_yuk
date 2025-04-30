<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisOut;

class JenisOutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisOut::create([
            'user_id' => 1,
            'icon' => 'fa-solid fa-money-bill',
            'color' => '#ff0000',
            'title' => 'Makan',
            'description' => 'Makanan sehari-hari',
        ]);

        JenisOut::create([
            'user_id' => 1,
            'icon' => 'fa-solid fa-money-bill',
            'color' => '#0000ff',
            'title' => 'Transportasi',
            'description' => 'Transportasi ke kantor',
        ]);
    }
}
