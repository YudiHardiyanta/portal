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
        Schema::create('metadata_indikator_variabel', function (Blueprint $table) {
            $table->unsignedBigInteger('id_indikator');
            $table->unsignedBigInteger('id_variabel');

            $table->primary(['id_indikator', 'id_variabel']);

            $table->foreign('id_indikator')->references('id_indikator')->on('metadata_indikator')->onDelete('cascade');
            $table->foreign('id_variabel')->references('id_variabel')->on('metadata_variabel')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metadata_indikator_variabel');
    }
};
