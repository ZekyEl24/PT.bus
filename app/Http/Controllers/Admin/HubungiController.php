<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hubungi;
use App\Models\ActivityLog; // Tambahkan ActivityLog
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg', // Batasan MB dihapus
        ]);

        try {
            // 1. Tampung data baru untuk pengecekan perubahan
            $hubungi->fill($request->except('foto'));

            // 2. Cek perubahan kolom teks
            $changes = [];
            foreach ($hubungi->getDirty() as $column => $newValue) {
                if ($column == 'updated_at') continue;

                $oldValue = $hubungi->getOriginal($column);

                if ($column == 'judul') {
                    $changes[] = "Judul \"$oldValue\" -> \"$newValue\"";
                } elseif ($column == 'deskripsi') {
                    $changes[] = "Deskripsi konten";
                }
            }

            // 3. Logika Upload Foto
            if ($request->hasFile('foto')) {
                if ($hubungi->foto) {
                    Storage::disk('public')->delete($hubungi->foto);
                }

                $path = $request->file('foto')->store('uploads/hubungi', 'public');
                $hubungi->foto = $path;
                $changes[] = "Foto/Gambar";
            }

            // 4. Simpan jika ada perubahan
            if (!empty($changes)) {
                $hubungi->save();

                // Format Log: "Mengubah Deskripsi konten, Foto/Gambar di Halaman Hubungi"
                $deskripsiDetail = "Mengubah " . implode(', ', $changes);
                ActivityLog::simpanLog('Edit', 'Hubungi', $deskripsiDetail);
            }

            return redirect()->route('hubungi.index')->with('success_type', 'simpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }
}
