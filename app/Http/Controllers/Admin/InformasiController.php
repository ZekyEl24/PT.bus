<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Models\ActivityLog;
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
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:6096',
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

            // CATAT LOG: TAMBAH
            ActivityLog::simpanLog('Tambah', 'Informasi Terkini', 'Menambahkan informasi baru: ' . $request->judul);

            return redirect()->back()->with('success_type', 'buat');
        } catch (\Exception $e) {
            if (isset($data['gambar'])) Storage::disk('public')->delete($data['gambar']);
            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);

        // Simpan judul asli sebagai referensi lokasi perubahan
        $judulAsli = $informasi->judul;

        $validated = $request->validate([
            'judul'  => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:6096',
            'isi'    => 'required|string',
            'status' => 'required|in:aktif,tidak aktif'
        ]);

        try {
            $data = $validated;
            $data['id_pengguna'] = Auth::id();

            // 1. Isi data baru
            $informasi->fill($data);

            // 2. Deteksi perubahan kolom teks
            $changes = [];
            foreach ($informasi->getDirty() as $column => $newValue) {
                if ($column == 'id_pengguna' || $column == 'updated_at') continue;

                $oldValue = $informasi->getOriginal($column);

                if ($column == 'isi') {
                    $changes[] = "Isi berita";
                } elseif ($column == 'status') {
                    $changes[] = "Status $oldValue -> $newValue";
                } elseif ($column == 'judul') {
                    $changes[] = "Judul $oldValue -> $newValue";
                }
            }

            // 3. Deteksi perubahan gambar
            if ($request->hasFile('gambar')) {
                if ($informasi->getOriginal('gambar')) {
                    Storage::disk('public')->delete($informasi->getOriginal('gambar'));
                }
                $path = $request->file('gambar')->store('assets/foto/informasi', 'public');
                $informasi->gambar = $path;
                $changes[] = "Gambar";
            }

            // 4. Simpan dan catat log jika ada yang berubah
            if (!empty($changes)) {
                $informasi->save();

                $deskripsiDetail = "Mengubah " . implode(', ', $changes) . " di '$judulAsli'";
                ActivityLog::simpanLog('Edit', 'Informasi Terkini', $deskripsiDetail);
            }

            return redirect()->back()->with('success_type', 'simpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $informasi = Informasi::findOrFail($id);
            $judulLama = $informasi->judul;

            // Hapus file gambar dari storage sebelum hapus data
            if ($informasi->gambar) {
                Storage::disk('public')->delete($informasi->gambar);
            }

            $informasi->delete();
            ActivityLog::simpanLog('Hapus', 'Informasi Terkini', 'Menghapus informasi: ' . $judulLama);

            return redirect()->back()->with('success_type', 'hapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'hapus');
        }
    }
}
