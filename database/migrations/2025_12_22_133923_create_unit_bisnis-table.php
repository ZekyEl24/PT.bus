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
        Schema::create('unit_bisnis', function (Blueprint $table) {
            $table->id('id_ub'); // Primary key, auto increment
            $table->string('logo_ub', 255);
            $table->string('nama_ub', 255);
            $table->text('deskripsi_ub');
            $table->string('gambar_ub', 255);
            $table->string('link_web_ub', 255);
            $table->string('link_ig_ub', 255);

            // Relasi ke tabel users
            $table->unsignedBigInteger('id_pengguna');
            $table->foreign('id_pengguna')->references('id')->on('users')->onDelete('cascade');

            // Perubahan terbaru: Status ENUM
            $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif');

            $table->timestamps(); // Mencakup created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_bisnis');
    }
};