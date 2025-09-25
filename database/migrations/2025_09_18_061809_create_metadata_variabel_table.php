<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('metadata_variabel', function (Blueprint $table) {
            $table->id('id_variabel');
            $table->string('nama_variabel')->unique();
            $table->json('alias')->nullable();
            $table->string('konsep')->nullable();
            $table->text('definisi')->nullable();
            $table->string('referensi_pemilihan')->nullable();
            $table->string('referensi_waktu')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('satuan')->nullable();
            $table->string('tipe_data')->nullable();
            $table->json('klasifikasi_isian')->nullable();
            $table->text('aturan_validasi')->nullable();
            $table->text('kalimat_pertanyaan')->nullable();
            $table->boolean('is_publik')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metadata_variabel');
    }
};
