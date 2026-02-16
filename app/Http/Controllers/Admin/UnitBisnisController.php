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
            'layanan' => 'required|nullable|array', // Validasi array layanan
        ]);

        try {
            $data = $request->except('layanan');
            $data['id_pengguna'] = Auth::id();

            if ($request->file('logo_ub')) {
                $data['logo_ub'] = $request->file('logo_ub')->store('assets/foto/UB/Logo', 'public');
            }

            if ($request->file('gambar_ub')) {
                $data['gambar_ub'] = $request->file('gambar_ub')->store('assets/foto/UB/fotoub', 'public');
            }

            $ub = UnitBisnis::create($data);

            if ($request->has('layanan') && is_array($request->layanan)) {
                foreach ($request->layanan as $item) {
                    if (!empty($item)) {
                        Layanan::create([
                            'id_ub' => $ub->id_ub,
                            'nama_layanan' => $item
                        ]);
                    }
                }
            }

            return redirect()->route('ub.index')->with('success_type', 'buat');
        } catch (\Exception $e) {
            // Jika gagal, hapus foto yang sudah terlanjur terupload (Opsional tapi disarankan)
            if (isset($data['logo_ub'])) Storage::disk('public')->delete($data['logo_ub']);
            if (isset($data['gambar_ub'])) Storage::disk('public')->delete($data['gambar_ub']);

            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }



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
            'status' => 'required|in:aktif,tidak aktif',
            'layanan' => 'required|nullable|array',
        ]);

        try {
            $data = $request->except('layanan');
            $data['id_pengguna'] = Auth::id();

            // Logo
            if ($request->hasFile('logo_ub')) {
                if ($ub->logo_ub) Storage::disk('public')->delete($ub->logo_ub);
                $data['logo_ub'] = $request->file('logo_ub')->store('assets/foto/UB/Logo', 'public');
            }

            // Gambar Utama
            if ($request->hasFile('gambar_ub')) {
                if ($ub->gambar_ub) Storage::disk('public')->delete($ub->gambar_ub);
                $data['gambar_ub'] = $request->file('gambar_ub')->store('assets/foto/UB/fotoub', 'public');
            }

            $ub->update($data);

            if ($request->has('layanan')) {
                $ub->layanan()->delete();

                foreach ($request->layanan as $item) {
                    if (!empty($item)) {
                        $ub->layanan()->create([
                            'nama_layanan' => $item
                        ]);
                    }
                }
            }

            return redirect()->route('ub.index')->with('success_type', 'simpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }

    /**
     * Hapus UB dan file terkait
     */
    public function destroy($id)
    {
        try {
            $ub = UnitBisnis::findOrFail($id);

            if ($ub->logo_ub) Storage::disk('public')->delete($ub->logo_ub);
            if ($ub->gambar_ub) Storage::disk('public')->delete($ub->gambar_ub);

            $ub->delete();

            return redirect()->route('ub.index')->with('success_type', 'hapus');
        } catch (\Exception $e) {
            return redirect()->route('ub.index')->with('error_type', 'hapus');
        }
    }
}