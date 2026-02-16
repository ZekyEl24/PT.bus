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
        Schema::create('informasi', function (Blueprint $table) {
            $table->id();
            // foreignId harus sesuai dengan tabel users (id_pengguna)
            $table->foreignId('id_pengguna')->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->string('gambar');
            $table->text('isi');
            $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif');
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi');
    }
};
