<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['id_pengguna', 'aksi', 'model', 'deskripsi'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    // Fungsi statis agar mudah dipanggil di Controller manapun
    public static function simpanLog($aksi, $model, $deskripsi)
    {
        self::create([
            'id_pengguna' => auth()->id(),
            'aksi' => $aksi,
            'model' => $model,
            'deskripsi' => $deskripsi,
        ]);

        $latestIds = self::latest()->take(20)->pluck('id');

        self::whereNotIn('id', $latestIds)->delete();
    }
}
