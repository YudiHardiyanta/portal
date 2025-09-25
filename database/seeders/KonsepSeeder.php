<?php

namespace Database\Seeders;

use App\Models\Konsep;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KonsepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = csv_to_array('database/csv/konsep_seed.csv');

        foreach ($data as $item) {
            Konsep::updateOrCreate(
                [
                    'kode_konsep' => $item['kode_konsep'],
                ],
                [
                    'konsep' => $item['konsep'],
                    'definisi' => $item['definisi'],
                ]
            );
        }
    }
}
