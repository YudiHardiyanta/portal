<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MetadataVariabel;

class MetadataVariabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = csv_to_array(database_path('csv/metadata_variabel_seed.csv'));

        foreach ($data as $item) {
            MetadataVariabel::updateOrCreate(
                [
                    // pakai id_variabel dari csv kalau ada
                    'id_variabel' => $item['id_variabel'] ?? null,
                ],
                [
                    'nama_variabel'       => $this->cleanText($item['nama_variabel'] ?? null),
                    'alias'               => !empty($item['alias'])
                        ? explode(';', $item['alias'])
                        : null,
                    'konsep'              => $this->cleanText($item['konsep'] ?? null),
                    'definisi'            => $this->cleanText($item['definisi'] ?? null),
                    'referensi_pemilihan' => $this->cleanText($item['referensi_pemilihan'] ?? null),
                    'referensi_waktu'     => $this->cleanText($item['referensi_waktu'] ?? null),
                    'ukuran'              => $this->cleanText($item['ukuran'] ?? null),
                    'satuan'              => $this->cleanText($item['satuan'] ?? null),
                    'tipe_data'           => $this->cleanText($item['tipe_data'] ?? null),
                    'klasifikasi_isian'   => !empty($item['klasifikasi_isian'])
                        ? explode(';', $item['klasifikasi_isian'])
                        : null,
                    'aturan_validasi'     => $this->cleanText($item['aturan_validasi'] ?? null),
                    'kalimat_pertanyaan'  => $this->cleanText($item['kalimat_pertanyaan'] ?? null),
                    'is_publik'           => isset($item['is_publik'])
                        ? filter_var($item['is_publik'], FILTER_VALIDATE_BOOLEAN)
                        : null,
                ]
            );
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
