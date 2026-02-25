<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilKlien;
use App\Models\ActivityLog; // Pastikan ini diimport
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfilKlienController extends Controller
{
    public function index(Request $request)
    {
        $query = ProfilKlien::with(['user']);

        if ($request->filled('search')) {
            $query->where('nama_klien', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $klien = $query->latest()->paginate(6);

        return view('admin.profilklien.index', [
            'title' => 'Profil Klien',
            'active' => 'profilklien',
            'klien' => $klien
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_klien' => 'required|string|max:255',
            'logo_klien' => 'required|image|mimes:jpeg,png,jpg|max:4096', // Batasan MB dilepas
            'status' => ['required', Rule::in(['aktif', 'tidak aktif'])]
        ]);

        try {
            $data = $validated;
            $data['id_pengguna'] = Auth::id();

            if ($request->hasFile('logo_klien')) {
                $data['logo_klien'] = $request->file('logo_klien')->store('assets/foto/klien', 'public');
            }

            ProfilKlien::create($data);

            // Log Tambah
            ActivityLog::simpanLog('Tambah', 'Profil Klien', 'Menambahkan klien baru: ' . $request->nama_klien);

            return redirect()->back()->with('success_type', 'buat');
        } catch (\Exception $e) {
            if (isset($data['logo_klien'])) Storage::disk('public')->delete($data['logo_klien']);
            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $klien = ProfilKlien::findOrFail($id);
        $namaAsli = $klien->nama_klien;

        $validated = $request->validate([
            'nama_klien' => 'required|string|max:255',
            'logo_klien' => 'nullable|image|mimes:jpeg,png,jpg|max:4096', // Batasan MB dilepas
            'status' => ['required', Rule::in(['aktif', 'tidak aktif'])]
        ]);

        try {
            $klien->fill($validated);
            $klien->id_pengguna = Auth::id();

            // Deteksi perubahan
            $changes = [];
            foreach ($klien->getDirty() as $column => $newValue) {
                if ($column == 'id_pengguna' || $column == 'updated_at') continue;
                $oldValue = $klien->getOriginal($column);

                if ($column == 'status') {
                    $changes[] = "Status $oldValue -> $newValue";
                } elseif ($column == 'nama_klien') {
                    $changes[] = "Nama $oldValue -> $newValue";
                }
            }

            // Tangani Logo
            if ($request->hasFile('logo_klien')) {
                if ($klien->logo_klien) {
                    Storage::disk('public')->delete($klien->logo_klien);
                }
                $klien->logo_klien = $request->file('logo_klien')->store('assets/foto/klien', 'public');
                $changes[] = "Logo Klien";
            }

            if (!empty($changes)) {
                $klien->save();

                $deskripsiDetail = "Mengubah " . implode(', ', $changes) . " di '$namaAsli'";
                ActivityLog::simpanLog('Edit', 'Profil Klien', $deskripsiDetail);
            }

            return redirect()->back()->with('success_type', 'simpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $klien = ProfilKlien::findOrFail($id);
            $namaKlien = $klien->nama_klien;

            if ($klien->logo_klien) {
                Storage::disk('public')->delete($klien->logo_klien);
            }

            $klien->delete();

            // Log Hapus
            ActivityLog::simpanLog('Hapus', 'Profil Klien', 'Menghapus klien: ' . $namaKlien);

            return redirect()->back()->with('success_type', 'hapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'hapus');
        }
    }
}
