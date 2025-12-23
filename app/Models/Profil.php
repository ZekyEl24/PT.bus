<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_profil',
        'deskripsi_profil',
        'visi',
        'logo',
    ];

    /**
     * Relasi One-to-Many ke Misi.
     */
    public function misi()
    {
        return $this->hasMany(Misi::class);
    }
}
