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
        Schema::create('periodes', function (Blueprint $table) {
            $table->id();
            $table->string('nama_periode'); // cth: Ganjil 2026/2027
            $table->string('tahun_ajaran'); // cth: 2026/2027
            $table->boolean('status_aktif')->default(false); // Hanya 1 yang boleh true nanti
            $table->timestamps();
            $table->softDeletes(); // Fitur soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodes');
    }
};
