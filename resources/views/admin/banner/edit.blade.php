<div id="modalEditBanner_{{ $banner->id }}"
    class="fixed inset-0 hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4 z-40">

    <div id="modalContentEditBanner_{{ $banner->id }}"
        class="bg-white rounded-[15px] shadow-2xl w-full max-w-[800px] transform transition-all scale-95 opacity-0 duration-300 max-h-[90vh] overflow-y-auto text-left">

        {{-- Judul Modal --}}
        <div class="py-6 border-b border-gray-100 text-center sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">Edit Banner: {{ $banner->judul }}</h3>
            {{-- Ubah onclick menggunakan handleCancelEditBanner --}}
            <button type="button" onclick="handleCancelEditBanner('{{ $banner->id }}')"
                class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        {{-- Form Body --}}
        <form id="formEditBanner_{{ $banner->id }}" action="{{ route('banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="p-8">
                <input type="hidden" name="banner_id_for_edit" value="{{ $banner->id }}">

                <div class="flex flex-col md:flex-row gap-8">
                    {{-- Sisi Kiri: Input Data --}}
                    <div class="flex-1 space-y-6">

                        {{-- Input Judul: Tambah oninput --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Judul Banner</label>
                            <input type="text" name="judul" placeholder="Masukkan Judul Banner" required
                                value="{{ old('judul', $banner->judul) }}"
                                oninput="checkChangesBanner('{{ $banner->id }}')"
                                class="w-full px-4 py-3 text-xs border border-dashed rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400
                                @error('judul', 'edit') border-red-500 @else border-gray-400 @enderror">
                        </div>

                        {{-- Input Kategori: Tambah onchange --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-3">Kategori</label>
                            <div class="flex items-center gap-6">
                                @php $currentKat = old('kategori', $banner->kategori); @endphp
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="kategori" value="utama" class="w-4 h-4 accent-birue"
                                        onchange="checkChangesBanner('{{ $banner->id }}')"
                                        required {{ $currentKat == 'utama' ? 'checked' : '' }}>
                                    <span class="text-xs font-bold text-gray-700">Utama</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="kategori" value="tentang kami" class="w-4 h-4 accent-birue"
                                        onchange="checkChangesBanner('{{ $banner->id }}')"
                                        required {{ $currentKat == 'tentang kami' ? 'checked' : '' }}>
                                    <span class="text-xs font-bold text-gray-700">Tentang Kami</span>
                                </label>
                            </div>
                        </div>

                        {{-- Input Status: Tambah onchange --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-3">Status</label>
                            <div class="flex items-center gap-6">
                                @php $currentStatus = old('status', $banner->status); @endphp
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="status" value="aktif" class="w-4 h-4 accent-birue"
                                        onchange="checkChangesBanner('{{ $banner->id }}')"
                                        {{ $currentStatus == 'aktif' ? 'checked' : '' }}>
                                    <span class="text-xs font-bold text-gray-700">Aktif</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="status" value="tidak aktif" class="w-4 h-4 accent-birue"
                                        onchange="checkChangesBanner('{{ $banner->id }}')"
                                        {{ $currentStatus == 'tidak aktif' ? 'checked' : '' }}>
                                    <span class="text-xs font-bold text-gray-700">Tidak Aktif</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Sisi Kanan: Upload Gambar --}}
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 mb-2">Unggah Foto</label>
                        <div class="relative group">
                            <label for="inputGambarEdit_{{ $banner->id }}" class="cursor-pointer">
                                <div id="previewContainerEdit_{{ $banner->id }}"
                                    class="w-full h-52 border-2 border-dashed rounded-xl p-6 flex items-center justify-center overflow-hidden bg-gray-50 hover:bg-gray-100 transition relative
                                    @error('gambar', 'edit') border-red-500 @else border-gray-400/70 @enderror">

                                    <img id="previewImageEdit_{{ $banner->id }}"
                                         src="{{ asset('storage/' . $banner->gambar) }}"
                                         alt="Preview"
                                         class="max-w-[90%] max-h-[90%] object-contain transition-transform">
                                </div>
                            </label>
                            {{-- PENTING: previewFileBanner sekarang menerima ID --}}
                            <input type="file" id="inputGambarEdit_{{ $banner->id }}" name="gambar" accept="image/*" class="hidden"
                                onchange="previewFileBanner('{{ $banner->id }}')">
                        </div>
                        <button type="button" onclick="document.getElementById('inputGambarEdit_{{ $banner->id }}').click()"
                            class="w-full mt-4 py-3 bg-birue text-white text-xs font-bold rounded-[13px] hover:opacity-90 transition shadow-sm">
                            Ganti Gambar
                        </button>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-between gap-4 pt-10">
                    <button type="button"
                        onclick="handleCancelEditBanner('{{ $banner->id }}')"
                        class="px-10 py-3 border border-gray-300 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-50 transition">
                        Batal
                    </button>

                    <button type="submit" id="btnSimpanBanner_{{ $banner->id }}" disabled
                        class="px-10 py-3 bg-gray-400 text-white rounded-xl text-xs font-bold transition cursor-not-allowed">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
