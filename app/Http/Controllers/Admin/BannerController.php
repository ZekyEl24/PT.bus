<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $query = Banner::query();

        // 1. Filter Kategori (Default: utama)
        $kategori = $request->get('kategori', 'utama');
        if ($kategori !== 'semua') {
            $query->where('kategori', $kategori);
        }

        // 2. Filter Status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // 3. Filter Search
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        return view('admin.banner.index', [
            'title' => 'Banner',
            'active' => 'banner',
            'banners' => $query->latest()->paginate(6),
            'current_kategori' => $kategori
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'kategori' => ['required', Rule::in(['utama', 'tentang kami'])],
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:6100', // Batasan MB dilepas
            'status' => ['required', Rule::in(['aktif', 'tidak aktif'])]
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('assets/foto/banner', 'public');
        }

        Banner::create($data);
        ActivityLog::simpanLog('Tambah', 'Banner', 'Menambahkan banner baru: ' . $request->judul);

        return redirect()->route('banner.index', ['kategori' => $request->kategori])->with('success_type', 'buat');
    }

    public function update(Request $request, Banner $banner)
    {
        // Simpan judul asli untuk konteks log
        $judulAsli = $banner->judul;

        $request->validate([
            'judul' => 'required|max:255',
            'kategori' => ['required', Rule::in(['utama', 'tentang kami'])],
            'status' => ['required', Rule::in(['aktif', 'tidak aktif'])],
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:6100' // Batasan MB dilepas
        ]);

        try {
            // 1. Isi data baru ke instance (jangan update dulu)
            $banner->fill($request->except('gambar'));

            // 2. Deteksi perubahan kolom
            $changes = [];
            foreach ($banner->getDirty() as $column => $newValue) {
                if ($column == 'updated_at') continue;

                $oldValue = $banner->getOriginal($column);

                if ($column == 'status') {
                    $changes[] = "Status $oldValue -> $newValue";
                } elseif ($column == 'judul') {
                    $changes[] = "Judul $oldValue -> $newValue";
                } elseif ($column == 'kategori') {
                    $changes[] = "Kategori $oldValue -> $newValue";
                } else {
                    $changes[] = ucfirst($column);
                }
            }

            // 3. Tangani gambar
            if ($request->hasFile('gambar')) {
                if ($banner->gambar) {
                    Storage::disk('public')->delete($banner->gambar);
                }
                $banner->gambar = $request->file('gambar')->store('assets/foto/banner', 'public');
                $changes[] = "Gambar";
            }

            // 4. Simpan jika ada perubahan
            if (!empty($changes)) {
                $banner->save();

                // Format: Mengubah Status aktif -> tidak aktif, Gambar di 'Banner Promo'
                $deskripsiDetail = "Mengubah " . implode(', ', $changes) . " pada '$judulAsli'";
                ActivityLog::simpanLog('Edit', 'Banner', $deskripsiDetail);
            }

            return redirect()->route('banner.index', ['kategori' => $banner->kategori])->with('success_type', 'simpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }

    public function destroy(Banner $banner)
    {
        try {
            $judulLama = $banner->judul;

            if ($banner->gambar) {
                Storage::disk('public')->delete($banner->gambar);
            }

            $banner->delete();
            ActivityLog::simpanLog('Hapus', 'Banner', 'Menghapus banner: ' . $judulLama);

            return redirect()->back()->with('success_type', 'hapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'hapus');
        }
    }
}
