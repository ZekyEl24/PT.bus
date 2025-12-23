<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';
    protected $primaryKey = 'id_layanan';
    protected $fillable = ['id_ub', 'nama_layanan'];

    /**
     * RELASI: Layanan ini milik satu Unit Bisnis
     */
    public function unitBisnis()
    {
        return $this->belongsTo(UnitBisnis::class, 'id_ub', 'id_');
    }
}