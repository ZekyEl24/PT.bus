<div id="modalEdit_{{ $kliens->id }}"
    class="fixed inset-0 hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4 z-40">
    <div id="modalContentEdit_{{ $kliens->id }}"
        class="bg-white rounded-[15px] shadow-2xl w-full max-w-[600px] transform transition-all scale-95 opacity-0 duration-300 max-h-full overflow-y-auto">

        <div class="py-6 border-b border-gray-200 text-center relative sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">Edit Data Klien</h3>
            <button type="button" onclick="handleCancelEditKlien('{{ $kliens->id }}')"
                class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="formEditKlien_{{ $kliens->id }}" action="{{ route('profilklien.update', $kliens->id) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="p-8 space-y-6">
                {{-- Input Nama Klien --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Nama Klien</label>
                    <input type="text" name="nama_klien" required
                        value="{{ old('nama_klien', $kliens->nama_klien) }}" data-initial="{{ $kliens->nama_klien }}"
                        oninput="checkChangesKlien('{{ $kliens->id }}')"
                        class="w-full px-4 py-3 text-xs border border-gray-400 border-dashed rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition
                        @error('nama_klien') border-red-500 @enderror">
                </div>

                {{-- Input Logo --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Logo Klien</label>
                    <div class="flex items-center gap-4">
                        <div
                            class="relative w-2/3 h-32 border border-gray-400 border-dashed rounded-lg flex items-center justify-center overflow-hidden bg-gray-50">
                            <img id="previewLogoEdit_{{ $kliens->id }}"
                                src="{{ asset('storage/' . $kliens->logo_klien) }}" alt="Preview"
                                class="max-w-full max-h-full object-contain p-2 {{ $kliens->logo_klien ? '' : 'hidden' }}">

                            <div id="placeholderLogoEdit_{{ $kliens->id }}"
                                class="text-gray-400 flex flex-col items-center {{ $kliens->logo_klien ? 'hidden' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mb-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[10px]">Belum ada logo</span>
                            </div>
                        </div>

                        <label
                            class="w-1/3 h-32 bg-birue transition-colors rounded-lg flex flex-col items-center justify-center cursor-pointer text-white px-4 text-center shadow-md">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl mb-2"></i>
                            <span class="text-[10px] font-bold leading-tight">Ubah Logo</span>
                            <input type="file" name="logo_klien" id="inputLogoEdit_{{ $kliens->id }}"
                                class="hidden" accept="image/*"
                                onchange="previewLogoImageEdit(this, '{{ $kliens->id }}'); checkChangesKlien('{{ $kliens->id }}')">
                        </label>
                    </div>
                </div>

                {{-- Input Status --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-3">Status</label>
                    <div class="flex items-center gap-8">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="status" value="aktif" class="w-5 h-5 accent-birue"
                                data-initial="{{ $kliens->status }}"
                                onchange="checkChangesKlien('{{ $kliens->id }}')"
                                {{ old('status', $kliens->status) == 'aktif' ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-gray-700">Aktif</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="status" value="tidak aktif" class="w-5 h-5 accent-birue"
                                onchange="checkChangesKlien('{{ $kliens->id }}')"
                                {{ old('status', $kliens->status) == 'tidak aktif' ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-gray-700">Tidak Aktif</span>
                        </label>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-between items-center pt-10 mt-4">
                    <button type="button" onclick="handleCancelEditKlien('{{ $kliens->id }}')"
                        class="px-12 py-3 border border-birua text-birua rounded-xl text-xs font-bold hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" id="btnSimpanKlien_{{ $kliens->id }}" disabled
                        class="px-12 py-3 bg-gray-400 text-white rounded-xl text-xs font-bold transition cursor-not-allowed">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
