<?php

namespace Database\Seeders;
use App\Models\Subkategori;
use Illuminate\Database\Seeder;
class SubkategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = csv_to_array('database/csv/subkategori_seed.csv');

        foreach ($data as $task) {
            Subkategori::updateOrCreate(
                [
                    'id' => $task['id'],
                ],
                [
                    'name' => $task['name'],
                ]
            );
        }
    }
}