<?php

namespace Database\Seeders;

use App\Models\Improvement;
use Illuminate\Database\Seeder;

class ImprovementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layanan = [
            ['id' => 1, 'name' => 'Tampilan'],
            ['id' => 2, 'name' => 'Pencarian Data'],
            ['id' => 3, 'name' => 'Kelengkapan Data'],
            ['id' => 4, 'name' => 'Metadata'],
            ['id' => 5, 'name' => 'Fitur'],
            ['id' => 6, 'name' => 'Performa Akses'],
        ];

        foreach ($layanan as $l) {
            Improvement::updateOrCreate(
                ['id' => $l['id']],
                ['name' => $l['name']]
            );
        }
    }
}
