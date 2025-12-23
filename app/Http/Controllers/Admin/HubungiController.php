<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hubungi; // Pastikan Anda sudah membuat Model Hubungi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HubungiController extends Controller
{
    public function index()
    {
        // Mengambil data pertama (id: 1)
        $hubungi = Hubungi::first() ?? new Hubungi();

        return view('admin.hubungi.index', [
            'title' => 'Hubungi',
            'active' => 'hubungi',
            'hubungi' => $hubungi
        ]);
    }

    public function update(Request $request, $id)
    {
        $hubungi = Hubungi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ];

        // Logika Upload Foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($hubungi->foto) {
                Storage::disk('public')->delete($hubungi->foto);
            }

            // Simpan foto baru ke folder 'uploads/hubungi'
            $path = $request->file('foto')->store('uploads/hubungi', 'public');
            $data['foto'] = $path;
        }

        $hubungi->update($data);

        return redirect()->route('hubungi.index')->with('success', 'Data Hubungi berhasil diperbarui!');
    }
}