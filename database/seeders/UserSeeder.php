<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'admin_pus',
            'email' => 'admin2@ptbus.com', // EMAIL INI DIGUNAKAN UNTUK LOGIN
            'password' => Hash::make('admin123'), // SANDI AKAN DI-HASH
            'role' => 'admin', // ROLE ADMIN UNTUK AKSES PENUH
            'status_pengguna' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan data editor dummy lainnya
        DB::table('users')->insert([
            'username' => 'editor_ub1',
            'email' => 'editor@ptbus.com',
            'password' => Hash::make('editor123'),
            'role' => 'editor ub',
            'status_pengguna' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
