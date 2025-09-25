<?php

namespace Database\Seeders;

use App\Models\Indicator;
use Illuminate\Database\Seeder;

class IndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = csv_to_array('database/csv/indikator_seed.csv');
        foreach ($data as $task) {
            Indicator::updateOrCreate(
                [
                    'var_id' => $task['var_id'],
                ],
                [
                    'id_dashboard' => $task['id_dashboard'] !== '' ? $task['id_dashboard'] : null,
                    'title' => $task['title'] ?? null,
                    'id_standar' => $task['id_standar'] ?? null,
                    'id_indikator' => $task['id_indikator'] ?? null,
                    'sub_id' => $task['sub_id'] ?? null,
                    'subcsa_id' => $task['subcsa_id'] ?? null,
                    'def' => $task['def'] ?? null,
                    'notes' => $task['notes'] ?? null,
                    'unit' => $task['unit'] ?? null,
                ]
            );
        }
    }
}
