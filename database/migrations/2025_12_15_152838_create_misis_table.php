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
        // Tabel Relasi: misis
        Schema::create('misis', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel profils (pastikan profils sudah ada sebelum migrasi ini)
            $table->foreignId('profil_id')
                  ->constrained('profils')
                  ->onDelete('cascade'); // Jika profil dihapus, semua misi ikut terhapus

            $table->string('misi', 255); // Isi teks dari poin misi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('misis');
    }
};
