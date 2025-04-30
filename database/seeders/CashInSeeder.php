<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CashIn;

class CashInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada 2 data untuk hari ini
        for ($j = 0; $j < 2; $j++) {
            CashIn::create([
                'user_id' => 1,
                'jenis_in_id' => rand(1, 2),
                'title' => 'Cash In Hari Ini ' . ($j + 1),
                'jumlah' => rand(10, 50) * 10000, // Menghasilkan jumlah antara 100000 - 500000
                'tanggal' => now()->format('Y-m-d H:i:s'), // Menggunakan tanggal hari ini
                'jam' => now()->addHours(rand(8, 21))->format('H:i:s'),
                'media' => json_encode(['image.jpg']),
                'description' => 'Deskripsi untuk Cash In Hari Ini ' . ($j + 1),
            ]);
        }

        for ($i = 1; $i <= 9; $i++) {
            CashIn::create([
                'user_id' => 1,
                'jenis_in_id' => rand(1, 2),
                'title' => 'Cash In ' . $i,
                'jumlah' => rand(10, 50) * 10000, // Menghasilkan jumlah antara 100000 - 500000
                'tanggal' => now()->addDays(rand(-3, 3))->format('Y-m-d H:i:s'),
                'jam' => now()->addHours(rand(8, 21))->format('H:i:s'),
                'media' => json_encode(['image.jpg']),
                'description' => 'Description ' . $i,
            ]);
        }
    }
}
