<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HistoryTarget;

class HistoryTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HistoryTarget::create([
            'target_id' => 1,
            'jumlah_tercapai' => 100000,
            'tanggal_tercapai' => '2025-01-01',
            'description' => 'Description 1',
            'media' => json_encode(['image.jpg']),
        ]);
    }
}
