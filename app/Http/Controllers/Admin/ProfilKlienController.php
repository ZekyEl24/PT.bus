<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilKlien;
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
            'logo_klien' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status' => ['required', Rule::in(['aktif', 'tidak aktif'])]
        ]);

        try {
            $data = $validated;
            $data['id_pengguna'] = Auth::id();

            if ($request->hasFile('logo_klien')) {
                $data['logo_klien'] = $request->file('logo_klien')->store('assets/foto/klien', 'public');
            }

            ProfilKlien::create($data);

            return redirect()->back()->with('success_type', 'buat');
        } catch (\Exception $e) {
            if (isset($data['logo_klien'])) Storage::disk('public')->delete($data['logo_klien']);
            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $klien = ProfilKlien::findOrFail($id);

        $validated = $request->validate([
            'nama_klien' => 'required|string|max:255',
            'logo_klien' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => ['required', Rule::in(['aktif', 'tidak aktif'])]
        ]);

        try {
            $data = $validated;
            $data['id_pengguna'] = Auth::id(); // Mencatat siapa yang terakhir edit

            if ($request->hasFile('logo_klien')) {
                if ($klien->logo_klien) {
                    Storage::disk('public')->delete($klien->logo_klien);
                }
                $data['logo_klien'] = $request->file('logo_klien')->store('assets/foto/klien', 'public');
            }

            $klien->update($data); // Gunakan $data


            return redirect()->back()->with('success_type', 'simpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $klien = ProfilKlien::findOrFail($id);

            // Hapus logo dari storage
            if ($klien->logo_klien) {
                Storage::disk('public')->delete($klien->logo_klien);
            }

            $klien->delete();

            return redirect()->back()->with('success_type', 'hapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'hapus');
        }
    }
}
