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
        Schema::create('profil_kliens', function (Blueprint $table) {
            $table->id('id');
            $table->string('nama_klien');
            $table->string('logo_klien');

            // Relasi ke tabel users
            $table->unsignedBigInteger('id_pengguna');
            $table->foreign('id_pengguna')->references('id')->on('users')->onDelete('cascade');

            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_kliens');
    }
};