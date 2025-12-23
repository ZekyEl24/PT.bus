<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hubungi extends Model
{
    protected $table = 'hubungi';
    protected $fillable = ['judul', 'deskripsi', 'foto'];
}
