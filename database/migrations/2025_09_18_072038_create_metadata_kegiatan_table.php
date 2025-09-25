<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('metadata_kegiatan', function (Blueprint $table) {
            $table->id();
            // foreign keys
            // $table->unsignedBigInteger('id_indikator');
            // $table->unsignedBigInteger('id_standar');

            $table->string('judul_kegiatan');
            $table->string('tahun')->nullable();
            $table->string('jenis_statistik')->nullable();
            $table->string('cara_pengumpulan_data')->nullable();
            $table->string('sektor_kegiatan')->nullable();

            $table->string('identitas_rekomendasi')->nullable();
            $table->string('instansi_penyelanggara')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('faksimile')->nullable();
            $table->string('unit_eselon1')->nullable();
            $table->string('unit_eselon2')->nullable();

            $table->string('pj_nama')->nullable();
            $table->string('pj_jabatan')->nullable();
            $table->string('pj_alamat')->nullable();
            $table->string('pj_telepon')->nullable();
            $table->string('pj_email')->nullable();
            $table->string('pj_faksimile')->nullable();

            $table->longText('latar_belakang_kegiatan')->nullable();
            $table->longText('tujuan_kegiatan')->nullable();

            // Jadwal
            $table->json('jadwal_perencanaan_kegiatan')->nullable();
            $table->json('jadwal_desain')->nullable();
            $table->json('jadwal_pengumpulan_data')->nullable();
            $table->json('jadwal_pengolahan_data')->nullable();
            $table->json('jadwal_analisis')->nullable();
            $table->json('jadwal_diseminasi_hasil')->nullable();
            $table->json('jadwal_evaluasi')->nullable();

            $table->json('variabel_yang_dikumpulkan')->nullable();
            $table->string('kegiatan_ini_dilakukan')->nullable();
            $table->string('frekuensi_penyelanggara')->nullable();
            $table->string('tipe_pengumpulan_data')->nullable();
            $table->string('cakupan_wilayah_pengumpulan_data')->nullable();
            $table->string('metode_pengumpulan_data')->nullable();
            $table->string('sarana_pengumpulan_data')->nullable();
            $table->string('unit_pengumpulan_data')->nullable();

            // Sampling
            $table->string('jenis_rancangan_sampel')->nullable();
            $table->string('metode_pemilihan_sampel_tahap_terakhir')->nullable();
            $table->string('metode_yang_digunakan')->nullable();
            $table->string('kerangka_sampel_tahap_terakhir')->nullable();
            $table->string('fraksi_sampel_keseluruhan')->nullable();
            $table->string('nilai_perkiraan_sampling_error_variabel_utama')->nullable();
            $table->string('unit_sampel')->nullable();
            $table->string('unit_observasi')->nullable();

            // Kualitas
            $table->string('apakah_melakukan_uji_coba')->nullable();
            $table->string('metode_pemeriksaan_kualitas_pengumpulan_data')->nullable();
            $table->string('apakah_melakukan_penyesuaian_nonrespon')->nullable();
            $table->string('petugas_pengumpulan_data')->nullable();
            $table->string('persyaratan_pendidikan_terendah_petugas_pengumpulan_data')->nullable();
            $table->integer('jumlah_petugas_supervisor')->nullable();
            $table->integer('jumlah_petugas_enumerator')->nullable();
            $table->string('apakah_melakukan_pelatihan_petugas')->nullable();

            $table->longText('tahapan_pengolahan_data')->nullable();
            $table->string('metode_analisis')->nullable();
            $table->string('unit_analisis')->nullable();
            $table->string('tingkat_penyajian_hasil_analisis')->nullable();

            // Produk
            $table->string('ketersediaan_produk_tercetak')->nullable();
            $table->string('ketersediaan_produk_digital')->nullable();
            $table->string('ketersediaan_produk_mikrodata')->nullable();
            $table->json('rencana_jadwal_rilis_produk_tercetak')->nullable();
            $table->json('rencana_jadwal_rilis_produk_digital')->nullable();
            $table->json('rencana_jadwal_rilis_produk_mikrodata')->nullable();

            $table->string('produsen_data_name')->nullable();
            $table->timestamps();

            // Foreign Keys
            // $table->foreign('id_indikator')
            //     ->references('var_id')
            //     ->on('indicators')
            //     ->onDelete('cascade');

            // $table->foreign('id_standar')
            //     ->references('id_standar')->on('standar_data')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metadata_kegiatan');
    }
};
