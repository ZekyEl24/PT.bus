<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profils')->insert([
            'logo' => 'admin_pus',
            'nama_profil' => 'admin2@ptbus.com', // EMAIL INI DIGUNAKAN UNTUK LOGIN
            'deskripsi_profil' => 'admin', // ROLE ADMIN UNTUK AKSES PENUH
            'visi' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}