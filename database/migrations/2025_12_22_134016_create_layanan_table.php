<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id('id_layanan'); // Mengikuti gaya penamaan Anda

            // Relasi ke unit_bisnis menggunakan id_ub
            $table->unsignedBigInteger('id_ub');
            $table->foreign('id_ub')->references('id_ub')->on('unit_bisnis')->onDelete('cascade');

            $table->string('nama_layanan', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
