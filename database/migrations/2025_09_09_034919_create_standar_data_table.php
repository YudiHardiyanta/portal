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
        Schema::create('standar_data', function (Blueprint $table) {
            $table->id('id_standar');
            $table->string('nama_data');
            $table->json('konsep_kode')->nullable();
            $table->text('definisi')->nullable();
            $table->json('klasifikasi_penyajian')->nullable();
            $table->json('klasifikasi_isian')->nullable();
            $table->boolean('is_klasifikasi')->default(false);
            $table->string('ukuran')->nullable();
            $table->string('satuan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standar_data');
    }
};
