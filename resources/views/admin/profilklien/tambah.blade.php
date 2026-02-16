{{-- ========================================== --}}
{{-- MODAL TAMBAH DATA KLIEN (POP-UP) --}}
{{-- ========================================== --}}
<div id="modalTambah" class="fixed inset-0 hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4 z-40">
    <div id="modalContentTambah"
        class="bg-white rounded-[15px] shadow-2xl w-full max-w-[600px] transform transition-all scale-95 opacity-0 duration-300 max-h-full overflow-y-auto">

        {{-- Judul Modal --}}
        <div class="py-6 border-b border-gray-200 text-center">
            <h3 class="text-lg font-bold text-gray-800">Tambah Data Klien</h3>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('profilklien.store') }}" method="POST" enctype="multipart/form-data" id="formTambahKlien" class="p-8 space-y-6">
            @csrf

            {{-- Input Nama Klien --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">
                    Nama Klien
                </label>
                <input type="text" name="nama_klien" placeholder="Masukkan Nama Klien" required
                    value="{{ old('nama_klien') }}"
                    class="w-full px-4 py-3 text-xs border border-gray-400 border-dashed rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400">
                @error('nama_klien')
                    <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Logo Klien (Upload Area) --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Logo Klien</label>
                <div class="flex items-center gap-4">
                    {{-- Preview Area --}}
                    <div class="relative w-2/3 h-32 border border-gray-400 border-dashed rounded-lg flex items-center justify-center overflow-hidden bg-gray-50">
                        <img id="previewLogo" src="#" alt="Preview" class="hidden max-w-full max-h-full object-contain p-2">
                        <div id="placeholderLogo" class="text-gray-400 flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[10px]">Preview Logo</span>
                        </div>
                    </div>

                    {{-- Upload Button --}}
                    <label class="w-1/3 h-32 bg-birue transition-colors rounded-lg flex flex-col items-center justify-center cursor-pointer text-white px-4 text-center shadow-md">
                        <i class="fa-solid fa-cloud-arrow-up text-2xl mb-2"></i>
                        <span class="text-[10px] font-bold leading-tight">Unggah Logo</span>
                        <input type="file" name="logo_klien" id="inputLogo" class="hidden" accept="image/*" onchange="previewLogoImage(this)">
                    </label>
                </div>
                @error('logo_klien')
                    <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Status (Radio Custom) --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-3">Status</label>
                <div class="flex items-center gap-8">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="status" value="aktif" class="w-5 h-5 accent-birue" required
                            {{ old('status', 'aktif') == 'aktif' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-700">Aktif</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="status" value="tidak aktif" class="w-5 h-5 accent-birue"
                            {{ old('status') == 'tidak aktif' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-700">Tidak Aktif</span>
                    </label>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-between items-center pt-10 mt-4">
                <button type="button" onclick="closeModal('modalTambah', 'formTambahKlien')"
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
    function previewLogoImage(input) {
        const preview = document.getElementById('previewLogo');
        const placeholder = document.getElementById('placeholderLogo');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Pastikan fungsi closeModal juga mereset preview image
    function closeModal(modalId, formId) {
        const modal = document.getElementById(modalId);
        const form = document.getElementById(formId);
        const preview = document.getElementById('previewLogo');
        const placeholder = document.getElementById('placeholderLogo');

        toggleModal(modalId); // Memanggil fungsi toggle yang sudah ada

        setTimeout(() => {
            if(form) form.reset();
            if(preview) preview.classList.add('hidden');
            if(placeholder) placeholder.classList.remove('hidden');
        }, 300);
    }
</script>
