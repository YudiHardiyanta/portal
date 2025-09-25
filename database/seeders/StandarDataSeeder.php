<?php

namespace Database\Seeders;

use App\Models\Konsep;
use App\Models\StandarData;
use Illuminate\Database\Seeder;

class StandarDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $data = csv_to_array(database_path('csv/standar_data_seed.csv'));

        foreach ($data as $item) {
            $konsepKode = $this->parseKonsepKode($item['konsep_kode']);

            $standar = StandarData::updateOrCreate(
                ['id_standar' => $item['id_standar']],
                [
                    'nama_data' => $this->cleanText($item['nama_data']),
                    'konsep_kode' => $konsepKode, 
                    'definisi' => $this->cleanText($item['definisi']),
                    'klasifikasi_penyajian' => $this->parseList($item['klasifikasi_penyajian']),
                    'klasifikasi_isian' => $this->parseTextList($item['klasifikasi_isian']),
                    'is_klasifikasi' => $item['is_klasifikasi'] == '1',
                    'ukuran' => $item['ukuran'] ?? null,
                    'satuan' => $item['satuan'] ?? null,
                ]
            );

            if (!empty($konsepKode)) {
                $konsepIds = Konsep::whereIn('kode_konsep', $konsepKode)->pluck('id_konsep')->toArray();
                $standar->konsep()->sync($konsepIds);
            }
        }
    }


    private function parseList($value)
    {
        if (empty($value)) {
            return [];
        }

        $clean = trim($value, "[]\"'");
        $parts = preg_split('/[,;\r\n]+/', $clean, -1, PREG_SPLIT_NO_EMPTY);

        return array_map(function ($item) {
            $item = trim($item);
            return preg_split('/\s+/', $item)[0];
        }, $parts);
    }

    private function parseTextList($value)
    {
        if (empty($value)) {
            return [];
        }

        $clean = trim($value, "[]\"'");
        $parts = preg_split('/[,;\r\n]+/', $clean, -1, PREG_SPLIT_NO_EMPTY);

        return array_map(function ($item) {
            $item = $this->cleanText($item);
            return rtrim($item, '|');
        }, $parts);
    }


    private function cleanText($text)
    {
        if (!$text)
            return null;

        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        $text = preg_replace('/[^\PC\s]/u', '', $text);
        $text = str_replace(["\u{A0}", "�"], ' ', $text);

        return trim($text);
    }

    private function parseKonsepKode($raw)
    {
        if (!$raw) {
            return [];
        }

        $lines = preg_split("/\r\n|\n|\r|,|;/", trim($raw));

        $result = [];
        foreach ($lines as $line) {
            $line = trim($line, " \t\n\r\0\x0B|;");

            if ($line === '')
                continue;

            if (preg_match('/^(K\d+)/', $line, $matches)) {
                $result[] = $matches[1];
            }
        }

        return $result;
    }
}
