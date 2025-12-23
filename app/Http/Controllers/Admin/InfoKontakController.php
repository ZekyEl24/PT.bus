<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoKontak; // Import Model
use Illuminate\Http\Request;

class InfoKontakController extends Controller
{
    public function index()
    {
        // Mengambil satu data pertama dari tabel info_kontak
        $kontak = InfoKontak::first();

        return view('admin.infokontak.index', [
            'title' => 'Info Kontak',
            'active' => 'infokontak',
            'kontak' => $kontak, // Kirim variabel $kontak ke View
        ]);
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi input
        $request->validate([
            'nomer_telepon' => 'required|string|max:20',
            'email'         => 'required|email|max:255',
            'alamat'        => 'required|string',
        ], [
            // Custom pesan error (opsional)
            'nomer_telepon.required' => 'Nomor WhatsApp harus diisi.',
            'email.required' => 'Email harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
        ]);

        try {
            // 2. Cari data berdasarkan ID atau ambil baris pertama
            $kontak = InfoKontak::findOrFail($id);

            // 3. Update data ke database
            $kontak->update([
                'nomer_telepon' => $request->nomer_telepon,
                'email'         => $request->email,
                'alamat'        => $request->alamat,
            ]);

            // 4. Redirect dengan notifikasi sukses
            return redirect()->route('infokontak.index')
                ->with('success_type', 'simpan');
                
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
