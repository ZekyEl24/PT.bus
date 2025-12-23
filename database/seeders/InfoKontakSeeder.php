<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class InfoKontakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('info_kontak')->insert([
            'nomer_telepon' => '081234567890',
            'email' => 'ptbus_admin@gmail.com',
            'alamat' => 'Jl. <<Alamat lengkap>>',
        ]);
    }
}