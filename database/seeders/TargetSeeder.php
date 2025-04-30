<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Target;

class TargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jumlahTargetRange = range(100000, 500000, 10000);
        $descriptions = [
            'Description A',
            'Description B',
            'Description C',
            'Description D',
            'Description E',
            'Description F',
            'Description G',
            'Description H',
            'Description I',
            'Description J',
        ];

        foreach ($jumlahTargetRange as $index => $jumlah_target) {
            Target::create([
                'user_id' => 1,
                'tingkat_id' => ($index % 3) + 1, // Assuming tingkat_id is 1, 2, 3 in a loop
                'title' => 'Target ' . ($index + 1),
                'jumlah_target' => $jumlah_target,
                'jumlah_tercapai' => 0,
                'sisa_target' => $jumlah_target,
                'tanggal_target' => '2025-' . str_pad(($index % 12) + 1, 2, '0', STR_PAD_LEFT) . '-01',
                'description' => $descriptions[$index % count($descriptions)],
                'media' => json_encode(['image' . ($index + 1) . '.jpg']),
            ]);
        }
    }
}
