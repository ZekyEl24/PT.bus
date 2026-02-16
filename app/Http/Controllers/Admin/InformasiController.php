<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InformasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Informasi::with(['user']);

        // Fitur Pencarian berdasarkan Judul
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Fitur Filter Status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $informasi = $query->latest()->paginate(6);

        return view('admin.informasiterkini.index', [
            'title'     => 'Informasi Terkini',
            'active'    => 'informasi',
            'informasi' => $informasi
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'  => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'isi'    => 'required|string',
            'status' => 'required|in:aktif,tidak aktif'
        ]);

        try {
            $data = $validated;
            $data['id_pengguna'] = Auth::id();

            if ($request->hasFile('gambar')) {
                // Path penyimpanan: public/assets/foto/informasi
                $data['gambar'] = $request->file('gambar')->store('assets/foto/informasi', 'public');
            }

            Informasi::create($data);

            return redirect()->back()->with('success_type', 'buat');
        } catch (\Exception $e) {
            if (isset($data['gambar'])) Storage::disk('public')->delete($data['gambar']);
            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);

        $validated = $request->validate([
            'judul'  => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'isi'    => 'required|string',
            'status' => 'required|in:aktif,tidak aktif'
        ]);

        try {
            $data = $validated;
            $data['id_pengguna'] = Auth::id();

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($informasi->gambar) {
                    Storage::disk('public')->delete($informasi->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('assets/foto/informasi', 'public');
            }

            $informasi->update($data);

            return redirect()->back()->with('success_type', 'simpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $informasi = Informasi::findOrFail($id);

            // Hapus file gambar dari storage sebelum hapus data
            if ($informasi->gambar) {
                Storage::disk('public')->delete($informasi->gambar);
            }

            $informasi->delete();

            return redirect()->back()->with('success_type', 'hapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'hapus');
        }
    }
}