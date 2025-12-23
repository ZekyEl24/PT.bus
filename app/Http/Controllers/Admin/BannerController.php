<?php

namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Banner;
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

            // 2. LOGIKAH BARU: Filter Status
            // Jika status ada di request dan nilainya bukan 'semua'
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
                // appends query string agar saat pindah halaman (page 2, dst) filter tetap aktif
                'banners' => $query->latest()->paginate(6),
                'current_kategori' => $kategori
            ]);
        }

        public function store(Request $request)
        {
            $request->validate([
                'judul' => 'required|max:255',
                'kategori' => ['required', Rule::in(['utama', 'tentang kami'])],
                'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'status' => ['required', Rule::in(['aktif', 'tidak aktif'])]
            ]);

            $data = $request->all();

            if ($request->hasFile('gambar')) {
                // Path: public/storage/assets/foto/banner
                $data['gambar'] = $request->file('gambar')->store('assets/foto/banner', 'public');
            }

            Banner::create($data);

            return redirect()->route('banner.index', ['kategori' => $request->kategori])->with('success_type', 'buat');
        }

        public function update(Request $request, Banner $banner)
        {
            $request->validate([
                'judul' => 'required|max:255',
                'kategori' => ['required', Rule::in(['utama', 'tentang kami'])],
                'status' => ['required', Rule::in(['aktif', 'tidak aktif'])],
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $data = $request->all();

            if ($request->hasFile('gambar')) {
                if ($banner->gambar) {
                    Storage::disk('public')->delete($banner->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('assets/foto/banner', 'public');
            }

            $banner->update($data);

            return redirect()->route('banner.index', ['kategori' => $banner->kategori])->with('success_type', 'simpan');
        }

        public function destroy(Banner $banner)
        {
            if ($banner->gambar) {
                Storage::disk('public')->delete($banner->gambar);
            }

            $banner->delete();

            return redirect()->back()->with('success_type', 'hapus');
        }
    }