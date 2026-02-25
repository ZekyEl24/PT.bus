{{-- ========================================== --}}
{{-- MODAL TAMBAH INFORMASI TERKINI (POP-UP) --}}
{{-- ========================================== --}}
<div id="modalTambahInformasi" class="fixed inset-0 hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4 z-50">
    <div id="modalContentTambahInformasi"
        class="bg-white rounded-[20px] shadow-2xl w-full max-w-[700px] transform transition-all scale-95 opacity-0 duration-300 max-h-[90vh] overflow-y-auto scrollbar-hide">

        {{-- Judul Modal --}}
        <div class="py-6 border-b border-gray-100 text-center sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">Tambah Informasi Terkini</h3>
            <button type="button" onclick="closeModal('modalTambahInformasi', 'formTambahInformasi')"
                class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('informasiterkini.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf

            {{-- Unggah Foto --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-700">Foto Informasi</label>
                <div class="relative group">
                    <div id="imagePreviewContainer"
                        class="w-full h-48 border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition-all overflow-hidden">

                        <img id="previewImage" src="#" alt="Preview" class="hidden max-w-[90%] max-h-[90%] object-contain transition-transform">

                        <div id="placeholderUpload" class="text-center">
                            <div class="bg-white p-3 rounded-full shadow-sm inline-block mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-birua" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-[11px] font-medium text-gray-600">Klik untuk Unggah Foto</p>
                            <p class="text-[9px] text-gray-400 mt-1">Format: JPG, PNG, JPEG (Maks. 4MB)</p>
                        </div>
                    </div>
                    <input type="file" name="gambar" id="inputFoto" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" required onchange="previewFile()">
                </div>
                @error('gambar')
                    <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Judul --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Judul Informasi Terkini</label>
                <input type="text" name="judul" placeholder="Masukkan Judul Informasi" required
                    value="{{ old('judul') }}"
                    class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400">
                @error('judul')
                    <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Deskripsi --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Deskripsi / Isi Berita</label>
                <textarea name="isi" rows="6" placeholder="Tuliskan isi informasi di sini..." required
                    class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400 leading-relaxed">{{ old('deskripsi_inform') }}</textarea>
                <p class="text-[9px] text-gray-400 mt-1 italic">*Gunakan spasi dan baris baru untuk mengatur keterbacaan teks.</p>
                @error('isi')
                    <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Status --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-3">Status</label>
                <div class="flex items-center gap-10">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="status" value="aktif" class="w-5 h-5 accent-birue" required
                            {{ old('status', 'aktif') == 'aktif' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-600 transition">Aktif</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="status" value="tidak aktif" class="w-5 h-5 accent-birue"
                            {{ old('status') == 'tidak aktif' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-600 transition">Tidak Aktif</span>
                    </label>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-between items-center pt-10 mt-4">
                <button type="button" onclick="closeModal('modalTambahInformasi', 'formTambahInformasi')"
                    class="px-12 py-3 border border-birua text-birua rounded-xl text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-12 py-3 bg-birua text-white rounded-xl text-xs font-bold hover:opacity-90 transition shadow-lg shadow-birua/20">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi Preview Gambar
    function previewFile() {
        const preview = document.getElementById('previewImage');
        const file = document.getElementById('inputFoto').files[0];
        const placeholder = document.getElementById('placeholderUpload');
        const reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }
</script>
