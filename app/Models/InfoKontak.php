<?php

// app/Models/InfoKontak.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoKontak extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara manual karena bentuk jamaknya berbeda
    protected $table = 'info_kontak';

    protected $fillable = [
        'nomer_telepon',
        'email',
        'alamat',
    ];
}
