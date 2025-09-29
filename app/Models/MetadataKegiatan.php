<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetadataKegiatan extends Model
{
    protected $table = 'metadata_kegiatan';
    protected $primaryKey = 'id_kegiatan';

    protected $fillable = [
        'id_kegiatan',
        'judul_kegiatan',
        'tahun',
        'jenis_statistik',
        'cara_pengumpulan_data',
        'sektor_kegiatan',
        'identitas_rekomendasi',
        'instansi_penyelanggara',
        'alamat',
        'telepon',
        'email',
        'faksimile',
        'unit_eselon1',
        'unit_eselon2',
        'pj_nama',
        'pj_jabatan',
        'pj_alamat',
        'pj_telepon',
        'pj_email',
        'pj_faksimile',
        'latar_belakang_kegiatan',
        'tujuan_kegiatan',

        // Jadwal
        'mulai_jadwal_perencanaan_kegiatan',
        'selesai_jadwal_perencanaan_kegiatan',
        'mulai_jadwal_desain',
        'selesai_jadwal_desain',
        'mulai_jadwal_pengumpulan_data',
        'selesai_jadwal_pengumpulan_data',
        'mulai_jadwal_pengolahan_data',
        'selesai_jadwal_pengolahan_data',
        'mulai_jadwal_analisis',
        'selesai_jadwal_analisis',
        'mulai_jadwal_diseminasi_hasil',
        'selesai_jadwal_diseminasi_hasil',
        'mulai_jadwal_evaluasi',
        'selesai_jadwal_evaluasi',

        'kegiatan_ini_dilakukan',
        'frekuensi_penyelanggara',
        'tipe_pengumpulan_data',
        'cakupan_wilayah_pengumpulan_data',
        'metode_pengumpulan_data',
        'sarana_pengumpulan_data',
        'unit_pengumpulan_data',

        // Sampling
        'jenis_rancangan_sampel',
        'metode_pemilihan_sampel_tahap_terakhir',
        'metode_yang_digunakan',
        'unit_sampel',
        'unit_observasi',

        // Kualitas
        'apakah_melakukan_uji_coba',
        'metode_pemeriksaan_kualitas_pengumpulan_data',
        'apakah_melakukan_penyesuaian_nonrespon',
        'petugas_pengumpulan_data',
        'persyaratan_pendidikan_terendah_petugas_pengumpulan_data',
        'jumlah_petugas_supervisor',
        'jumlah_petugas_enumerator',
        'apakah_melakukan_pelatihan_petugas',

        'tahapan_pengolahan_data',
        'metode_analisis',
        'unit_analisis',
        'tingkat_penyajian_hasil_analisis',

        // Produk
        'ketersediaan_produk_tercetak',
        'ketersediaan_produk_digital',
        'ketersediaan_produk_mikrodata',
        'rencana_jadwal_rilis_produk_tercetak',
        'rencana_jadwal_rilis_produk_digital',
        'rencana_jadwal_rilis_produk_mikrodata',
    ];

    protected $casts = [
        // field boolean
        'apakah_melakukan_uji_coba' => 'boolean',
        'apakah_melakukan_penyesuaian_nonrespon' => 'boolean',
        'apakah_melakukan_pelatihan_petugas' => 'boolean',
        'ketersediaan_produk_tercetak' => 'boolean',
        'ketersediaan_produk_digital' => 'boolean',
        'ketersediaan_produk_mikrodata' => 'boolean',

        // field json
        'rencana_jadwal_rilis_produk_tercetak' => 'array',
        'rencana_jadwal_rilis_produk_digital' => 'array',
        'rencana_jadwal_rilis_produk_mikrodata' => 'array',

        // field date
        'mulai_jadwal_perencanaan_kegiatan' => 'date',
        'selesai_jadwal_perencanaan_kegiatan' => 'date',
        'mulai_jadwal_desain' => 'date',
        'selesai_jadwal_desain' => 'date',
        'mulai_jadwal_pengumpulan_data' => 'date',
        'selesai_jadwal_pengumpulan_data' => 'date',
        'mulai_jadwal_pengolahan_data' => 'date',
        'selesai_jadwal_pengolahan_data' => 'date',
        'mulai_jadwal_analisis' => 'date',
        'selesai_jadwal_analisis' => 'date',
        'mulai_jadwal_diseminasi_hasil' => 'date',
        'selesai_jadwal_diseminasi_hasil' => 'date',
        'mulai_jadwal_evaluasi' => 'date',
        'selesai_jadwal_evaluasi' => 'date',
    ];

    // Relasi ke indikator
    public function indikator()
    {
        return $this->hasOne(
            Indicator::class,
            'id_kegiatan',
            'id_kegiatan'
        );
    }
}
