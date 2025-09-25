<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetadataKegiatan extends Model
{
    protected $table = 'metadata_kegiatan';

    protected $fillable = [
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
        'jadwal_perencanaan_kegiatan',
        'jadwal_desain',
        'jadwal_pengumpulan_data',
        'jadwal_pengolahan_data',
        'jadwal_analisis',
        'jadwal_diseminasi_hasil',
        'jadwal_evaluasi',
        'variabel_yang_dikumpulkan',
        'kegiatan_ini_dilakukan',
        'frekuensi_penyelanggara',
        'tipe_pengumpulan_data',
        'cakupan_wilayah_pengumpulan_data',
        'metode_pengumpulan_data',
        'sarana_pengumpulan_data',
        'unit_pengumpulan_data',
        'jenis_rancangan_sampel',
        'metode_pemilihan_sampel_tahap_terakhir',
        'metode_yang_digunakan',
        'kerangka_sampel_tahap_terakhir',
        'fraksi_sampel_keseluruhan',
        'nilai_perkiraan_sampling_error_variabel_utama',
        'unit_sampel',
        'unit_observasi',
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
        'ketersediaan_produk_tercetak',
        'ketersediaan_produk_digital',
        'ketersediaan_produk_mikrodata',
        'rencana_jadwal_rilis_produk_tercetak',
        'rencana_jadwal_rilis_produk_digital',
        'rencana_jadwal_rilis_produk_mikrodata',
        'produsen_data_name',
    ];

    protected $casts = [
        'jadwal_perencanaan_kegiatan' => 'array',
        'jadwal_desain' => 'array',
        'jadwal_pengumpulan_data' => 'array',
        'jadwal_pengolahan_data' => 'array',
        'jadwal_analisis' => 'array',
        'jadwal_diseminasi_hasil' => 'array',
        'jadwal_evaluasi' => 'array',
        'variabel_yang_dikumpulkan' => 'array',
        'rencana_jadwal_rilis_produk_tercetak' => 'array',
        'rencana_jadwal_rilis_produk_digital' => 'array',
        'rencana_jadwal_rilis_produk_mikrodata' => 'array',
    ];

    public function indikator()
    {
        return $this->belongsTo(Indicator::class, 'id_indikator', 'var_id');
    }


    public function standar()
    {
        return $this->belongsTo(StandarData::class, 'id_standar', 'id');
    }
}
