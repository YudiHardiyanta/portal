<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = csv_to_array('database/csv/kategori_seed.csv');

        foreach ($data as $task) {
            Kategori::updateOrCreate(
                [
                    'id' => $task['id'],
                ],
                [
                    'name'              => $task['name'],
                ]
            );
        }
    }
}
