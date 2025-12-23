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
        // Tabel Utama: profils
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable(); // Path/Nama file logo (boleh null)
            $table->string('nama_profil', 255);
            $table->text('deskripsi_profil');
            $table->text('visi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
