<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Misi extends Model
{
    use HasFactory;

    protected $fillable = [
        'profil_id',
        'misi',
    ];

    /**
     * Relasi Inverse One-to-Many ke Profil.
     */
    public function profil()
    {
        return $this->belongsTo(Profil::class);
    }
}
