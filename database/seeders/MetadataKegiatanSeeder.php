<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MetadataKegiatan;

class MetadataKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = csv_to_array(database_path('csv/metadata_kegiatan_seed.csv'));

        foreach ($data as $item) {
            $id = $item['id'] ?? null;
            MetadataKegiatan::updateOrCreate(
                [
                    'id_kegiatan' => $id,
                ],
                [
                    'tahun' => $item['tahun'] ?? null,
                    'judul_kegiatan' => $this->cleanText($item['judul_kegiatan'] ?? null),
                    'cara_pengumpulan_data' => $this->cleanText($item['cara_pengumpulan_data'] ?? null),
                    'sektor_kegiatan' => $this->cleanText($item['sektor_kegiatan'] ?? null),
                    'jenis_statistik' => $this->cleanText($item['jenis_kegiatan_statistik'] ?? null),
                    'identitas_rekomendasi' => $this->cleanText($item['identitas_rekomendasi'] ?? null),
                    'instansi_penyelanggara' => $this->cleanText($item['instansi_penyelenggara'] ?? null),
                    'alamat' => $this->cleanText($item['alamat'] ?? null),
                    'telepon' => $item['telepon'] ?? null,
                    'faksimile' => $item['faksimile'] ?? null,
                    'email' => $item['email'] ?? null,
                    'unit_eselon1' => $this->cleanText($item['unit_eselon1'] ?? null),
                    'unit_eselon2' => $this->cleanText($item['unit_eselon2'] ?? null),

                    'pj_nama' => $this->cleanText($item['pj_nama'] ?? null),
                    'pj_jabatan' => $this->cleanText($item['pj_jabatan'] ?? null),
                    'pj_alamat' => $this->cleanText($item['pj_alamat'] ?? null),
                    'pj_telepon' => $item['pj_telepon'] ?? null,
                    'pj_faksimile' => $item['pj_faksimile'] ?? null,
                    'pj_email' => $item['pj_email'] ?? null,

                    'latar_belakang_kegiatan' => $this->cleanText($item['latar_belakang_kegiatan'] ?? null),
                    'tujuan_kegiatan' => $this->cleanText($item['tujuan_kegiatan'] ?? null),

                    // jadwal (konversi ke format date)
                    'mulai_jadwal_perencanaan_kegiatan' => $item['mulai_jadwal_perencanaan_kegiatan'] ?? null,
                    'selesai_jadwal_perencanaan_kegiatan' => $item['selesai_jadwal_perencanaan_kegiatan'] ?? null,
                    'mulai_jadwal_desain' => $item['mulai_jadwal_desain'] ?? null,
                    'selesai_jadwal_desain' => $item['selesai_jadwal_desain'] ?? null,
                    'mulai_jadwal_pengumpulan_data' => $item['mulai_jadwal_pengumpulan_data'] ?? null,
                    'selesai_jadwal_pengumpulan_data' => $item['selesai_jadwal_pengumpulan_data'] ?? null,
                    'mulai_jadwal_pengolahan_data' => $item['mulai_jadwal_pengolahan_data'] ?? null,
                    'selesai_jadwal_pengolahan_data' => $item['selesai_jadwal_pengolahan_data'] ?? null,
                    'mulai_jadwal_analisis' => $item['mulai_jadwal_analisis'] ?? null,
                    'selesai_jadwal_analisis' => $item['selesai_jadwal_analisis'] ?? null,
                    'mulai_jadwal_diseminasi_hasil' => $item['mulai_jadwal_diseminasi_hasil'] ?? null,
                    'selesai_jadwal_diseminasi_hasil' => $item['selesai_jadwal_diseminasi_hasil'] ?? null,
                    'mulai_jadwal_evaluasi' => $item['mulai_jadwal_evaluasi'] ?? null,
                    'selesai_jadwal_evaluasi' => $item['selesai_jadwal_evaluasi'] ?? null,

                    'kegiatan_ini_dilakukan' => $item['kegiatan_ini_dilakukan'] ?? null,
                    'frekuensi_penyelanggara' => $item['frekuensi_penyelanggara'] ?? null,
                    'tipe_pengumpulan_data' => $item['tipe_pengumpulan_data'] ?? null,
                    'cakupan_wilayah_pengumpulan_data' => $item['cakupan_wilayah_pengumpulan_data'] ?? null,
                    'metode_pengumpulan_data' => $item['metode_pengumpulan_data'] ?? null,
                    'sarana_pengumpulan_data' => $item['sarana_pengumpulan_data'] ?? null,
                    'unit_pengumpulan_data' => $item['unit_pengumpulan_data'] ?? null,

                    'jenis_rancangan_sampel' => $item['jenis_rancangan_sampel'] ?? null,
                    'metode_pemilihan_sampel_tahap_terakhir' => $item['metode_pemilihan_sampel_tahap_terakhir'] ?? null,
                    'metode_yang_digunakan' => $item['metode_yang_digunakan'] ?? null,
                    'unit_sampel' => $item['unit_sampel'] ?? null,
                    'unit_observasi' => $item['unit_observasi'] ?? null,

                    'apakah_melakukan_uji_coba' => isset($item['apakah_melakukan_uji_coba'])
                        ? filter_var($item['apakah_melakukan_uji_coba'], FILTER_VALIDATE_BOOLEAN)
                        : null,
                    'metode_pemeriksaan_kualitas_pengumpulan_data' => $item['metode_pemeriksaan_kualitas_pengumpulan_data'] ?? null,
                    'apakah_melakukan_penyesuaian_nonrespon' => isset($item['apakah_melakukan_penyesuaian_nonrespon'])
                        ? filter_var($item['apakah_melakukan_penyesuaian_nonrespon'], FILTER_VALIDATE_BOOLEAN)
                        : null,
                    'petugas_pengumpulan_data' => $item['petugas_pengumpulan_data'] ?? null,
                    'persyaratan_pendidikan_terendah_petugas_pengumpulan_data' => $item['persyaratan_pendidikan_terendah_petugas_pengumpulan_data'] ?? null,
                    'jumlah_petugas_supervisor' => $item['jumlah_petugas_supervisor'] ?? null,
                    'jumlah_petugas_enumerator' => $item['jumlah_petugas_enumerator'] ?? null,
                    'apakah_melakukan_pelatihan_petugas' => isset($item['apakah_melakukan_pelatihan_petugas'])
                        ? filter_var($item['apakah_melakukan_pelatihan_petugas'], FILTER_VALIDATE_BOOLEAN)
                        : null,

                    'tahapan_pengolahan_data' => $item['tahapan_pengolahan_data'] ?? null,
                    'metode_analisis' => $item['metode_analisis'] ?? null,
                    'unit_analisis' => $item['unit_analisis'] ?? null,
                    'tingkat_penyajian_hasil_analisis' => $item['tingkat_penyajian_hasil_analisis'] ?? null,

                    'ketersediaan_produk_tercetak' => isset($item['ketersediaan_produk_tercetak'])
                        ? filter_var($item['ketersediaan_produk_tercetak'], FILTER_VALIDATE_BOOLEAN)
                        : null,
                    'ketersediaan_produk_digital' => isset($item['ketersediaan_produk_digital'])
                        ? filter_var($item['ketersediaan_produk_digital'], FILTER_VALIDATE_BOOLEAN)
                        : null,
                    'ketersediaan_produk_mikrodata' => isset($item['ketersediaan_produk_mikrodata'])
                        ? filter_var($item['ketersediaan_produk_mikrodata'], FILTER_VALIDATE_BOOLEAN)
                        : null,

                    // kalau berisi banyak tanggal dipisah ";"
                    'rencana_jadwal_rilis_produk_tercetak' => !empty($item['rencana_jadwal_rilis_produk_tercetak'])
                        ? explode(';', $item['rencana_jadwal_rilis_produk_tercetak'])
                        : null,
                    'rencana_jadwal_rilis_produk_digital' => !empty($item['rencana_jadwal_rilis_produk_digital'])
                        ? explode(';', $item['rencana_jadwal_rilis_produk_digital'])
                        : null,
                    'rencana_jadwal_rilis_produk_mikrodata' => !empty($item['rencana_jadwal_rilis_produk_mikrodata'])
                        ? explode(';', $item['rencana_jadwal_rilis_produk_mikrodata'])
                        : null,
                ]
            );
        }
    }

    private function cleanText($text)
    {
        if (!$text)
            return null;

        // convert encoding ke UTF-8
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');

        // hapus karakter non-printable & non-breaking space
        $text = preg_replace('/[^\PC\s]/u', '', $text);       
        $text = str_replace(["\xA0", "\u{A0}", "�"], ' ', $text); 
        $text = preg_replace('/[^\x{0000}-\x{FFFF}]/u', '', $text); 

        return trim($text);
    }

}

