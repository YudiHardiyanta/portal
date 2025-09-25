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
        Schema::create('standar_data_konsep', function (Blueprint $table) {
            $table->unsignedBigInteger('id_standar');
            $table->unsignedBigInteger('id_konsep');

            $table->primary(['id_standar', 'id_konsep']);

            $table->foreign('id_standar')->references('id_standar')->on('standar_data')->onDelete('cascade');
            $table->foreign('id_konsep')->references('id_konsep')->on('konsep')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standar_data_konsep');
    }
};
