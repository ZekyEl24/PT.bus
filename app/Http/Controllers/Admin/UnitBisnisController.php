<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UnitBisnis;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UnitBisnisController extends Controller
{
    /**
     * Tampilkan daftar UB dengan pencarian dan pagination
     */
    public function index(Request $request)
    {
        $query = UnitBisnis::with(['user', 'layanan']);

        // Filter pencarian berdasarkan nama
        if ($request->filled('search')) {
            $query->where('nama_ub', 'like', '%' . $request->search . '%');
        }

        // 2. LOGIKAH BARU: Filter Status
        // Jika status ada di request dan nilainya bukan 'semua'
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $unitBisnis = $query->latest()->paginate(6);

        return view('admin.unitbisnis.index', [
            'title' => 'Unit Bisnis',
            'active' => 'ub',
            'unitBisnis' => $unitBisnis
        ]);
    }

    /**
     * Simpan data UB baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_ub' => 'required|max:255',
            'deskripsi_ub' => 'required',
            'logo_ub' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
            'gambar_ub' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'link_web_ub' => 'required|url',
            'link_ig_ub' => 'required|url',
            'status' => 'required|in:aktif,tidak aktif',
            'layanan' => 'nullable|array', // Validasi array layanan
        ]);

        $data = $request->except('layanan'); // Ambil semua kecuali input layanan

        // Catat siapa yang membuat
        $data['id_pengguna'] = Auth::id();

        // Upload Logo
        if ($request->file('logo_ub')) {
            $data['logo_ub'] = $request->file('logo_ub')->store('assets/foto/UB/Logo', 'public');
        }

        // Upload Gambar Utama
        if ($request->file('gambar_ub')) {
            $data['gambar_ub'] = $request->file('gambar_ub')->store('assets/foto/UB/fotoub', 'public');
        }

        // 1. Simpan Unit Bisnis ke DB
        $ub = UnitBisnis::create($data);

        // 2. Simpan Layanan ke DB (Jika ada layanan yang ditambahkan)
        if ($request->has('layanan') && is_array($request->layanan)) {
            foreach ($request->layanan as $item) {
                if (!empty($item)) {
                    Layanan::create([
                        'id_ub' => $ub->id_ub, // Ambil ID dari UB yang baru saja dibuat
                        'nama_layanan' => $item
                    ]);
                }
            }
        }

        return redirect()->route('ub.index')->with('success', 'Unit Bisnis dan Layanan berhasil ditambahkan!');
    }
    /**
     * Update data UB
     */
    public function update(Request $request, $id)
    {
        $ub = UnitBisnis::findOrFail($id);

        $request->validate([
            'nama_ub' => 'required|max:255',
            'deskripsi_ub' => 'required',
            'logo_ub' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'gambar_ub' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'link_web_ub' => 'required|url',
            'link_ig_ub' => 'required|url',
            'status' => 'required|in:aktif,tidak aktif', // Sesuaikan dengan value radio button di HTML
            'nama_layanan' => 'nullable|array',
        ]);

        $data = $request->except('nama_layanan'); // Ambil semua data kecuali array layanan

        // Update pencatat: siapa yang terakhir mengubah data
        $data['id_pengguna'] = Auth::id();

        // Handle ganti Logo
        if ($request->hasFile('logo_ub')) {
            if ($ub->logo_ub) Storage::disk('public')->delete($ub->logo_ub);
            $data['logo_ub'] = $request->file('logo_ub')->store('assets/foto/UB/Logo', 'public');
        }

        // Handle ganti Gambar Utama
        if ($request->hasFile('gambar_ub')) {
            if ($ub->gambar_ub) Storage::disk('public')->delete($ub->gambar_ub);
            $data['gambar_ub'] = $request->file('gambar_ub')->store('assets/foto/UB/fotoub', 'public');
        }

        // 1. Update data Unit Bisnis
        $ub->update($data);

        // 2. Update data Layanan (Hapus yang lama, simpan yang baru)
        // Ini cara paling efisien untuk sinkronisasi input dinamis
        $ub->layanan()->delete();

        if ($request->has('nama_layanan') && is_array($request->nama_layanan)) {
            foreach ($request->nama_layanan as $item) {
                if (!empty($item)) {
                    Layanan::create([
                        'id_ub' => $ub->id_ub,
                        'nama_layanan' => $item
                    ]);
                }
            }
        }

        return redirect()->route('ub.index')->with('success', 'Data Unit Bisnis dan Layanan berhasil diperbarui.');
    }

    /**
     * Hapus UB dan file terkait
     */
    public function destroy($id)
    {
        $ub = UnitBisnis::findOrFail($id);

        // Hapus file fisik agar storage tidak penuh
        if ($ub->logo_ub) Storage::disk('public')->delete($ub->logo_ub);
        if ($ub->gambar_ub) Storage::disk('public')->delete($ub->gambar_ub);

        $ub->delete();

        return redirect()->route('ub.index')->with('success', 'Unit Bisnis berhasil dihapus.');
    }
}