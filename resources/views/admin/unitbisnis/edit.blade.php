{{-- ========================================== --}}
{{-- MODAL EDIT UNIT BISNIS (POP-UP) --}}
{{-- ========================================== --}}
<div id="modalEditUB_{{ $ub->id_ub }}"
    class="fixed inset-0 hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4 z-50">

    <div id="modalContentEditUB_{{ $ub->id_ub }}"
        class="bg-white rounded-[20px] shadow-2xl w-full max-w-[850px] transform transition-all scale-95 opacity-0 duration-300 max-h-[95vh] overflow-y-auto scrollbar-hide text-left">

        {{-- Judul Modal --}}
        <div class="py-6 border-b border-gray-100 text-center sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">Edit Unit Bisnis: {{ $ub->nama_ub }}</h3>
            <button type="button"
                onclick="closeModal('modalEditUB_{{ $ub->id_ub }}', 'formEditUB_{{ $ub->id_ub }}')"
                class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        {{-- Form Body --}}
        <form id="formEditUB_{{ $ub->id_ub }}" action="{{ route('ub.update', $ub->id_ub) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6 p-8">

                {{-- Sisi Kiri: Nama & Deskripsi --}}
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Nama Unit Bisnis</label>
                        <input type="text" name="nama_ub" value="{{ old('nama_ub', $ub->nama_ub) }}" required
                            class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi_ub" rows="6" required
                            class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition resize-none">{{ old('deskripsi_ub', $ub->deskripsi_ub) }}</textarea>
                    </div>
                </div>

                {{-- Sisi Kanan: Upload Logo --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Logo Unit Bisnis</label>
                    <div class="relative group">
                        <label for="inputLogoEdit_{{ $ub->id_ub }}" class="cursor-pointer">
                            <div id="previewContainerLogo_{{ $ub->id_ub }}"
                                class="w-full h-[180px] border-2 border-dashed border-gray-400/70 rounded-xl flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden">

                                <img id="previewLogo_{{ $ub->id_ub }}" src="{{ asset('storage/' . $ub->logo_ub) }}"
                                    class="max-w-[90%] max-h-[90%] object-contain">
                            </div>
                        </label>
                        <input type="file" id="inputLogoEdit_{{ $ub->id_ub }}" name="logo_ub" accept="image/*"
                            class="hidden" onchange="previewFileEditUB('Logo', '{{ $ub->id_ub }}')">
                    </div>
                    <button type="button"
                        onclick="document.getElementById('inputLogoEdit_{{ $ub->id_ub }}').click()"
                        class="w-full mt-4 py-3 bg-[#2D3E50] text-white text-xs font-bold rounded-lg hover:opacity-90 transition">
                        Ganti Foto/Logo
                    </button>
                </div>

                {{-- Baris Tengah: Foto Utama --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-2">Foto Unit Bisnis</label>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div id="previewContainerFoto_{{ $ub->id_ub }}"
                            class="flex-1 h-40 border-2 border-dashed border-gray-400/70 rounded-xl flex items-center justify-center bg-gray-50 overflow-hidden">

                            <img id="previewFoto_{{ $ub->id_ub }}" src="{{ asset('storage/' . $ub->gambar_ub) }}"
                                class="max-w-[95%] max-h-[95%] object-contain">
                        </div>
                        <label for="inputFotoEdit_{{ $ub->id_ub }}" class="cursor-pointer">
                            <div
                                class="w-full md:w-48 h-40 bg-[#2D3E50] rounded-xl flex flex-col items-center justify-center text-white gap-3 hover:opacity-90 transition">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl"></i>
                                <span class="text-xs font-bold">Ganti Foto</span>
                            </div>
                        </label>
                        <input type="file" id="inputFotoEdit_{{ $ub->id_ub }}" name="gambar_ub" accept="image/*"
                            class="hidden" onchange="previewFileEditUB('Foto', '{{ $ub->id_ub }}')">
                    </div>
                </div>

                {{-- Link Website & Medsos --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Link Website</label>
                    <input type="url" name="link_web_ub" value="{{ old('link_web_ub', $ub->link_web_ub) }}"
                        required
                        class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Link Media Sosial</label>
                    <input type="url" name="link_ig_ub" value="{{ old('link_ig_ub', $ub->link_ig_ub) }}" required
                        class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition">
                </div>

                {{-- Bagian Layanan --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-2">Layanan</label>
                    <div id="layananContainerEdit_{{ $ub->id_ub }}" class="space-y-3">
                        @forelse ($ub->layanan as $item)
                            <div class="flex items-center gap-2">
                                <input type="text" name="layanan[]" value="{{ $item->nama_layanan }}" required
                                    class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition">
                                <button type="button" onclick="this.parentElement.remove()"
                                    class="bg-red-500 text-white w-9 h-9 rounded-lg flex items-center justify-center hover:bg-red-600 transition flex-shrink-0">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        @empty
                            <div class="flex items-center gap-2">
                                <input type="text" name="layanan[]" placeholder="Masukkan nama layanan" required
                                    class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition">
                            </div>
                        @endforelse
                    </div>
                    <button type="button" onclick="addLayananFieldEdit('{{ $ub->id_ub }}')"
                        class="mt-3 flex items-center gap-2 text-xs font-bold text-birua hover:text-biruc transition">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Layanan Baru
                    </button>
                </div>

                {{-- Status --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-3">Status</label>
                    <div class="flex items-center gap-8">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="status" value="aktif"
                                class="w-5 h-5 accent-birua cursor-pointer"
                                {{ $ub->status == 'aktif' ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-gray-700">Aktif</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="status" value="tidak aktif"
                                class="w-5 h-5 accent-birua cursor-pointer"
                                {{ $ub->status == 'tidak aktif' ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-gray-700">Tidak Aktif</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-between items-center p-8 border-t border-gray-50 bg-gray-50/50">
                <button type="button"
                    onclick="openDiscardConfirmation('Unit Bisnis', 'modalEditUB_{{ $ub->id_ub }}', 'formEditUB_{{ $ub->id_ub }}')"
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
