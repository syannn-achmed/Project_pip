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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel users untuk akun orang tua
            $table->foreignId('user_id_ortu')->nullable()->constrained('users')->nullOnDelete();

            $table->string('nis')->unique();
            $table->string('nama');
            $table->string('kelas');
            $table->enum('jk', ['L', 'P']);
            $table->string('nama_ortu');
            $table->string('pekerjaan_ortu')->nullable();
            $table->string('no_telp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable(); // Simpan path foto
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
