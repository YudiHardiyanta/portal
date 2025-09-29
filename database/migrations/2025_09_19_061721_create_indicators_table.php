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
        Schema::create('indicators', function (Blueprint $table) {
            $table->unsignedBigInteger('var_id')->primary();
            $table->unsignedBigInteger('id_dashboard')->nullable();
            $table->unsignedBigInteger('id_standar')->nullable();
            $table->unsignedBigInteger('id_kegiatan')->nullable();
            $table->unsignedBigInteger('id_indikator')->nullable();
            $table->string('slug')->unique();
            $table->string('title');
            $table->unsignedBigInteger('sub_id');
            $table->unsignedBigInteger('subcsa_id');
            $table->text('def')->nullable();
            $table->text('notes')->nullable();
            $table->string('unit')->nullable();
            $table->unsignedBigInteger('total_views')->default(0);
            $table->timestamps();

            $table->foreign('id_standar')
                ->references('id_standar')->on('standar_data')
                ->onDelete('cascade');
            $table->foreign('id_indikator')
                ->references('id_indikator')->on('metadata_indikator')
                ->onDelete('cascade');
            $table->foreign('id_kegiatan')
                ->references('id_kegiatan')->on('metadata_kegiatan')
                ->onDelete('cascade');
            $table->foreign('sub_id')
                ->references('id')->on('kategori')
                ->onDelete('cascade');

            $table->foreign('subcsa_id')
                ->references('id')->on('subkategori')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};