<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MetadataVariabel;
use App\Models\MetadataIndikator;

class MetadataIndikatorSeeder extends Seeder
{
    public function run(): void
    {
        $data = csv_to_array(database_path('csv/metadata_indikator_seed.csv'));

        foreach ($data as $item) {
            $indikator = MetadataIndikator::updateOrCreate(
                ['nama_indikator' => $this->cleanText($item['nama_indikator'])],
                [
                    'nama_indikator' => $this->cleanText($item['nama_indikator']),
                    'konsep' => $this->cleanText($item['konsep']),
                    'definisi' => $this->cleanText($item['definisi']),
                    'interpretasi' => $this->cleanText($item['interpretasi']),
                    'metode_perhitungan' => $this->cleanText($item['metode_perhitungan']),
                    'rumus' => $this->cleanText($item['rumus']),
                    'ukuran' => $item['ukuran'] ?? null,
                    'satuan' => $item['satuan'] ?? null,

                    'variabel_disagregasi' => !empty($item['variabel_disagregasi'])
                        ? array_map('trim', explode(';', $item['variabel_disagregasi']))
                        : null,
                    'indikator_pembangunan' => !empty($item['indikator_pembangunan'])
                        ? array_map('trim', explode(';', $item['indikator_pembangunan']))
                        : null,
                    'id_variabel_pembangun' => !empty($item['id_variabel_pembangun'])
                        ? array_map('trim', explode(';', $item['id_variabel_pembangun']))
                        : null,
                    'indikator_komposit' => filter_var($item['indikator_komposit'], FILTER_VALIDATE_BOOLEAN),
                    'level_estimasi' => !empty($item['level_estimasi'])
                        ? array_map('trim', explode(';', $item['level_estimasi']))
                        : null,
                    'publik' => filter_var($item['publik'], FILTER_VALIDATE_BOOLEAN),
                ]
            );

            // isi tabel pivot indikator <-> variabel dari id langsung
            if (!empty($item['id_variabel_pembangun'])) {
                $variabelIds = array_map('trim', explode(';', $item['id_variabel_pembangun']));

                // validasi id variabel yang ada
                $validIds = MetadataVariabel::whereIn('id_variabel', $variabelIds)->pluck('id_variabel')->toArray();

                if (!empty($validIds)) {
                    $indikator->variabel()->syncWithoutDetaching($validIds);
                }
            }
        }
    }

    private function cleanText($text)
    {
        if (!$text) return null;

        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        $text = preg_replace('/[^\PC\s]/u', '', $text);
        $text = str_replace(["\u{A0}", "�"], ' ', $text);

        return trim($text);
    }
}
