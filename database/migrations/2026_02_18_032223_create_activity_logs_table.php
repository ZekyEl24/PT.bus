<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->constrained('users')->onDelete('cascade');
            $table->string('aksi'); // Tambah, Edit, Hapus
            $table->string('model'); // Banner, Pengguna, Unit Bisnis, dll
            $table->string('deskripsi'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};