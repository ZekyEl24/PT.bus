<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HubungiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hubungi')->insert([
            'judul' => 'Tertarik dengan salah satu Unit Bisnis kami?',
            'deskripsi' => 'Kunjungi unit bisnis kami dan temukan keunggulan yang kami tawarkan. Anda juga dapat menghubungi kami untuk informasi lebih lanjut.',
            'foto' => null, // Biarkan null atau isi path jika sudah ada foto default
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}