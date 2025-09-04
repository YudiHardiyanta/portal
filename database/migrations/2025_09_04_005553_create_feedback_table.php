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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('satisfaction'); // 1-5 (emoji)
            $table->string('job')->nullable(); // pekerjaan terakhir
            $table->json('improvements')->nullable(); // multi-select improvement
            $table->text('message')->nullable(); // saran tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
