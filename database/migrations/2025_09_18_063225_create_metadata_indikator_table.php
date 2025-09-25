<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metadata_indikator', function (Blueprint $table) {
            $table->id('id_indikator');
            $table->string('nama_indikator');
            $table->string('konsep')->nullable();
            $table->text('definisi')->nullable();
            $table->text('interpretasi')->nullable();
            $table->text('metode_perhitungan')->nullable();
            $table->text('rumus')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('satuan')->nullable();

            $table->json('variabel_disagregasi')->nullable();
            $table->boolean('indikator_komposit')->default(false);
            $table->json('indikator_pembangunan')->nullable();
            $table->json('id_variabel_pembangun')->nullable(); 
            $table->json('level_estimasi')->nullable();

            $table->boolean('publik')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metadata_indikator');
    }
};
