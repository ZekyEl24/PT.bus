<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilKlien extends Model
{
    use HasFactory;
    protected $table = 'profil_kliens';
    protected $primaryKey = 'id';

    // 3. Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'nama_klien',
        'logo_klien',
        'status',
        'id_pengguna'
    ];

    /**
     * RELASI: Unit Bisnis dimiliki oleh satu User (Editor)
     */
    public function user()
    {
        // 'id_pengguna' adalah FK di tabel ini, 'id' adalah PK di tabel User
        return $this->belongsTo(User::class, 'id_pengguna', 'id');
    }

}
