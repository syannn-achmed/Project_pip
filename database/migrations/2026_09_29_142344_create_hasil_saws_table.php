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
        Schema::create('hasil_saws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periodes')->restrictOnDelete();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->decimal('nilai_akhir', 8, 4); // Simpan hasil desimal (cth: 0.8750)
            $table->integer('peringkat')->nullable();
            $table->enum('status_penerimaan', ['Lolos', 'Tidak Lolos', 'Pending'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_saws');
    }
};
