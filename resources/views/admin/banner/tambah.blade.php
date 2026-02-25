{{-- Perhatikan ID: modalTambahBanner (harus sama dengan yang dipanggil di index) --}}
<div id="modalTambahBanner"
    class="fixed inset-0 hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4 z-40">

    {{-- Perhatikan ID: modalContentTambahBanner (disesuaikan dengan fungsi getModalContentId di index) --}}
    <div id="modalContentTambahBanner"
        class="bg-white rounded-[15px] shadow-2xl w-full max-w-[800px] transform transition-all scale-95 opacity-0 duration-300 max-h-[90vh] overflow-y-auto">

        {{-- Judul Modal --}}
        <div class="py-6 border-b border-gray-100 text-center sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">Tambah Banner</h3>
            {{-- Sesuaikan fungsi closeModal --}}
            <button type="button" onclick="closeModal('modalTambahBanner', 'formTambahBanner')"
                class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        {{-- Form Body --}}
        <form id="formTambahBanner" action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data"
            class="p-8">
            @csrf

            <div class="flex flex-col md:flex-row gap-8">
                {{-- Sisi Kiri: Input Data --}}
                <div class="flex-1 space-y-6">
                    {{-- Input Judul --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Judul Banner</label>
                        <input type="text" name="judul" placeholder="Masukkan Judul Banner" required
                            class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400">
                    </div>

                    {{-- Input Kategori (Radio) --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-3">Kategori</label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="kategori" value="utama" class="w-4 h-4 accent-birue"
                                    required
                                    {{ request('kategori') == 'utama' || !request('kategori') ? 'checked' : '' }}>
                                <span class="text-xs text-gray-700">Utama</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="kategori" value="tentang kami" class="w-4 h-4 accent-birue"
                                    required {{ request('kategori') == 'tentang kami' ? 'checked' : '' }}>
                                <span class="text-xs text-gray-700">Tentang Kami</span>
                            </label>
                        </div>
                    </div>

                    {{-- Input Status --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-3">Status</label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="aktif" class="w-4 h-4 accent-birue"
                                    checked>
                                <span class="text-xs text-gray-700">Aktif</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="tidak aktif" class="w-4 h-4 accent-birue">
                                <span class="text-xs text-gray-700">Tidak Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Sisi Kanan: Upload Gambar --}}
                <div class="flex-1">
                    <label class="block text-xs font-bold text-gray-700 mb-2">Unggah Foto</label>
                    <div class="relative group">
                        <label for="inputGambarTambah" class="cursor-pointer">
                            <div id="previewContainerTambah"
                                class="w-full h-52 border-2 border-dashed border-gray-400/70 rounded-xl p-6 flex items-center justify-center overflow-hidden bg-gray-50 hover:bg-gray-100 transition relative">
                                <div id="placeholderTambah" class="flex flex-col items-center">
                                    <div id="placeholderUpload" class="text-center">
                                        <div class="bg-white p-3 rounded-full shadow-sm inline-block mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-birua"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-[11px] font-medium text-gray-600">Klik untuk Unggah Gambar</p>
                                        <p class="text-[9px] text-gray-400 mt-1">Format: JPG, PNG, JPEG (Maks. 4MB)</p>
                                    </div>
                                </div>
                                <img id="previewImageTambah" src="#" alt="Preview"
                                    class="hidden max-w-[90%] max-h-[90%] object-contain transition-transform">
                            </div>
                        </label>
                        <input type="file" id="inputGambarTambah" name="gambar" accept="image/*" class="hidden"
                            required onchange="previewFile('Tambah')">
                    </div>
                    <button type="button" onclick="document.getElementById('inputGambarTambah').click()"
                        class="w-full mt-4 py-3 bg-birue text-white text-xs font-bold rounded-[13px] hover:opacity-90 transition">
                        Unggah Gambar
                    </button>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-between items-center pt-10">
                {{-- Tombol Batal di Kiri --}}
                <button type="button" onclick="closeModal('modalTambahBanner', 'formTambahBanner')"
                    class="px-10 py-3 border border-birua text-birua rounded-xl text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>

                {{-- Tombol Simpan di Kanan --}}
                <button type="submit"
                    class="px-10 py-3 bg-birua text-white rounded-xl text-xs font-bold hover:bg-biruc transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
