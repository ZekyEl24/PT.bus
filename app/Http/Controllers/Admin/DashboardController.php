<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilKlien; // Pastikan nama model sesuai
use App\Models\UnitBisnis;  // Diasumsikan sebagai 'Layanan'
use App\Models\User;        // Untuk statistik atau riwayat jika perlu
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        // 1. Mengambil jumlah Klien asli
        $totalKlien = \App\Models\ProfilKlien::count();
        // 2. Mengambil jumlah Layanan asli (Unit Bisnis)
        $totalLayanan = \App\Models\UnitBisnis::count();

        // 3. Simulasi Total Pengunjung (Bisa diambil dari tabel log atau jumlah User)
        // Jika Anda belum memiliki tabel statistik, kita gunakan jumlah User Aktif sebagai contoh
        $totalPengunjung = \App\Models\User::where('status_pengguna', 'aktif')->count();

        $logs = \App\Models\ActivityLog::with('user')->latest()->take(15)->get();

        return view('admin.dasbor.index', [
            'title'   => 'Dasbor',
            'active'  => 'dashboard',
            'stats'   => [
                'klien'      => $totalKlien,
                'layanan'    => $totalLayanan,
                'pengunjung' => $totalPengunjung
            ],
            'logs' => $logs
        ]);
    }
}
