<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'informasi';

    protected $primaryKey = 'id';
    protected $fillable = [
        'id_pengguna',
        'judul',
        'gambar',
        'isi',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }
}
