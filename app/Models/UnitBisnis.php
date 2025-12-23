<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitBisnis extends Model
{
    use HasFactory;

    // 1. Tentukan nama tabel (karena bukan 'unit_bisnis_s')
    protected $table = 'unit_bisnis';

    // 2. Tentukan Primary Key (karena bukan 'id')
    protected $primaryKey = 'id_ub';

    // 3. Daftarkan kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'logo_ub',
        'nama_ub',
        'deskripsi_ub',
        'gambar_ub',
        'link_web_ub',
        'link_ig_ub',
        'id_pengguna',
        'status'
    ];

    /**
     * RELASI: Unit Bisnis dimiliki oleh satu User (Editor)
     */
    public function user()
    {
        // 'id_pengguna' adalah FK di tabel ini, 'id' adalah PK di tabel User
        return $this->belongsTo(User::class, 'id_pengguna', 'id');
    }

    /**
     * RELASI: Unit Bisnis memiliki banyak Layanan
     */
    public function layanan()
    {
        return $this->hasMany(Layanan::class, 'id_ub', 'id_ub');
    }
}
