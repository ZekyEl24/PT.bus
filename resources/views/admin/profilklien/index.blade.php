    @extends('layout.admin')

    @section('content')
        <div class="h-full">
            <div
                class="bg-gradient-to-t from-kuning via-kuningterang to-white p-6 rounded-[10px] shadow-lg min-h-[85vh] relative flex flex-col">

                {{-- HEADER & TOOLS --}}
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 px-2">
                    <h2 class="text-base font-bold text-black">Data Profil Klien</h2>

                    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                        <form method="GET" action="{{ route('profilklien.index') }}" id="filterForm"
                            class="flex flex-wrap items-center gap-3 w-full md:w-auto">

                            {{-- FILTER STATUS --}}
                            <div class="relative">
                                <input type="hidden" name="status" id="statusInput" value="{{ request('status', 'semua') }}">
                                <button type="button" id="filterBtn"
                                    class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-[10px] text-gray-600 bg-white hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5" d="M4.5 7h15M7 12h10m-7 5h4" />
                                    </svg>
                                    <span id="filterText">
                                        {{ request('status') === 'aktif' ? 'Aktif' : (request('status') === 'tidak aktif' ? 'Tidak Aktif' : 'Semua') }}
                                    </span>
                                    <i class="fa-solid fa-chevron-down text-[10px] ml-2"></i>
                                </button>

                                {{-- DROPDOWN --}}
                                <div id="filterDropdown"
                                    class="hidden absolute right-0 mt-2 w-36 bg-white border border-gray-200 rounded-lg shadow-lg z-20">
                                    <button type="button" data-status="semua"
                                        class="filter-item w-full text-left px-4 py-2 text-[10px] hover:bg-gray-100">Semua</button>
                                    <button type="button" data-status="aktif"
                                        class="filter-item w-full text-left px-4 py-2 text-[10px] hover:bg-gray-100">Aktif</button>
                                    <button type="button" data-status="tidak aktif"
                                        class="filter-item w-full text-left px-4 py-2 text-[10px] hover:bg-gray-100">Tidak
                                        Aktif</button>
                                </div>
                            </div>

                            {{-- SEARCH --}}
                            <div class="relative w-full md:w-[280px]">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fa-solid fa-magnifying-glass text-[12px]"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari Nama Klien..."
                                    class="bg-white w-full py-2 pl-10 pr-4 text-[10px] border border-gray-300 rounded-lg focus:ring-1 focus:ring-kuning outline-none"
                                    id="searchInput">
                            </div>
                        </form>

                        {{-- Tombol Tambah --}}
                        <button onclick="toggleModal('modalTambah')"
                            class="bg-birua hover:bg-biruc text-white font-habanera px-6 py-2 rounded-[10px] text-xs font-bold flex items-center gap-2 transition shadow-md">
                            Tambah <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

                {{-- TABEL DATA --}}
                <div id="klienTable" class="bg-white rounded-[10px] shadow-sm flex-1 flex flex-col overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border-separate border-spacing-0">
                            <thead>
                                <tr class="bg-kuning text-black text-xs font-semibold text-center">
                                    <th class="py-4 px-6 border-b border-gray-200">Logo</th>
                                    <th class="py-4 px-6 border-b border-gray-200">Nama Klien</th>
                                    <th class="py-4 px-6 border-b border-gray-200">Terakhir Diedit Oleh</th>
                                    <th class="py-4 px-6 border-b border-gray-200">Status</th>
                                    <th class="py-4 px-6 border-b border-gray-200">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs">
                                @forelse ($klien as $kliens)
                                    <tr class="hover:bg-gray-50 transition">
                                        {{-- Logo --}}
                                        <td class="py-4 px-6 text-center border-b border-gray-100">
                                            <div class="flex justify-center">
                                                <div class="w-12 h-12 flex items-center justify-center">
                                                    <img src="{{ asset('storage/' . $kliens->logo_klien) }}"
                                                        class="max-w-full max-h-full object-contain">
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Nama Klien --}}
                                        <td class="py-4 px-6 text-center border-b border-gray-100 font-medium text-gray-700">
                                            {{ $kliens->nama_klien }}
                                        </td>

                                        {{-- Terakhir Diedit Oleh --}}
                                        <td
                                            class="py-4 px-6 text-xs text-center border-b border-gray-100  font-light text-gray-700">
                                            {{ $kliens->user->username ?? '-' }}
                                        </td>

                                        {{-- Status --}}
                                        <td class="py-5 px-6 text-center border-b border-gray-100">
                                            <div
                                                class="inline-flex items-center gap-2 border border-gray-300 rounded-full px-5 py-1.5 bg-white min-w-[120px] justify-center">
                                                <div
                                                    class="w-2.5 h-2.5 rounded-full {{ $kliens->status == 'aktif' ? 'bg-aktif' : 'bg-nonaktif' }}">
                                                </div>
                                                <span
                                                    class="font-bold text-xs capitalize text-gray-700">{{ $kliens->status }}</span>
                                            </div>
                                        </td>
                                        <td class="py-5 px-6 text-center border-b border-gray-100">
                                            <div class="flex justify-center gap-2">
                                                {{-- Edit --}}
                                                <button type="button" onclick="toggleModal('modalEdit_{{ $kliens->id }}')"
                                                    class="w-[30px] h-[30px] rounded-full bg-kuning text-black flex items-center justify-center hover:bg-yellow-500 transition shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="m7 17.013l4.413-.015l9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583zM18.045 4.458l1.589 1.583l-1.597 1.582l-1.586-1.585zM9 13.417l6.03-5.973l1.586 1.586l-6.029 5.971L9 15.006z" />
                                                        <path fill="currentColor"
                                                            d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01c-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2" />
                                                    </svg>
                                                </button>
                                                {{-- Hapus --}}
                                                <button type="button"
                                                    onclick="showDeleteConfirmation('{{ route('profilklien.destroy', $kliens->id) }}')"
                                                    class="w-8 h-8 rounded-full bg-birud text-white flex items-center justify-center hover:bg-red-900 transition shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6zM8 9h8v10H8zm7.5-5l-1-1h-5l-1 1H5v2h14V4z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- MODAL EDIT INLINE --}}
                                    @include('admin.profilklien.edit')

                                @empty
                                    <tr>
                                        <td colspan="5" class="py-20 text-center bg-white">
                                            <div class="flex flex-col items-center text-gray-300">
                                                <i class="fa-solid fa-magnifying-glass text-5xl mb-4"></i>
                                                <h3 class="text-gray-700 font-bold text-base">Data Tidak Ditemukan</h3>
                                                <p class="text-gray-500 text-xs mt-1">Belum ada data klien yang terdaftar.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-auto py-8 flex justify-center items-center gap-2">
                        {{-- Tombol Previous --}}
                        @if ($klien->onFirstPage())
                            <span class="p-2 text-gray-300 cursor-not-allowed">
                                <i class="fa-solid fa-chevron-left text-[10px]"></i>
                            </span>
                        @else
                            <a href="{{ $klien->appends(request()->query())->previousPageUrl() }}"
                                class="p-2 text-gray-500 hover:text-black transition">
                                <i class="fa-solid fa-chevron-left text-[10px]"></i>
                            </a>
                        @endif

                        {{-- Angka Halaman --}}
                        @foreach ($klien->getUrlRange(1, $klien->lastPage()) as $page => $url)
                            @if ($page == $klien->currentPage())
                                <span
                                    class="w-7 h-7 flex items-center justify-center rounded bg-kuning text-black font-bold text-xs shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $klien->appends(request()->query())->url($page) }}"
                                    class="w-7 h-7 flex items-center justify-center rounded text-gray-500 hover:bg-gray-100 text-xs font-bold transition">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Tombol Next --}}
                        @if ($klien->hasMorePages())
                            <a href="{{ $klien->appends(request()->query())->nextPageUrl() }}"
                                class="p-2 text-gray-500 hover:text-black transition">
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </a>
                        @else
                            <span class="p-2 text-gray-300 cursor-not-allowed">
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </span>
                        @endif
                    </div>


                </div>
            </div>

            {{-- INCLUDE MODAL TAMBAH & PARTIALS --}}
            @include('admin.profilklien.tambah')
            @include('layout.partials.delete_confirmation_modal')
            @include('layout.partials.edit_confirmation')
            @include('layout.partials.success_notification')
        </div>

        {{-- SCRIPT (Gunakan script yang sama dengan User Management) --}}
        <script>
            // 1. Global state untuk menyimpan data asli Profil Klien
            let initialKlienData = {};
            let lastActiveModalId = null;
            let formToResetId = null;

            // MODAL CORE FUNCTIONS
            function getModalContentId(modalId) {
                if (modalId.includes('modalEdit_')) return `modalContentEdit_${modalId.split('_')[1]}`;
                if (modalId === 'modalTambah') return 'modalContentTambah';
                if (modalId === 'deleteConfirmationModal') return 'deleteConfirmationModalContent';
                if (modalId === 'editConfirmation') return 'editConfirmationContent';
                return null;
            }

            // 2. Modifikasi Fungsi Toggle Modal untuk tracking data awal
            function toggleModal(modalId) {
                const modal = document.getElementById(modalId);
                const contentId = getModalContentId(modalId);
                const content = document.getElementById(contentId);

                if (!modal || !content) return;

                if (modal.classList.contains('hidden')) {
                    modal.classList.replace('hidden', 'flex');
                    setTimeout(() => {
                        content.classList.replace('scale-95', 'scale-100');
                        content.classList.replace('opacity-0', 'opacity-100');
                    }, 10);

                    // Jika modal edit dibuka, rekam data awalnya
                    if (modalId.startsWith('modalEdit_')) {
                        const klienId = modalId.split('_')[1];
                        setTimeout(() => trackInitialKlienData(klienId), 100);
                    }
                }
            }

            function closeModal(modalId, formId = null) {
                const modal = document.getElementById(modalId);
                const contentId = getModalContentId(modalId);
                const content = document.getElementById(contentId);
                if (!content) return;

                content.classList.replace('scale-100', 'scale-95');
                content.classList.replace('opacity-100', 'opacity-0');

                if (formId) document.getElementById(formId).reset();
                setTimeout(() => modal.classList.replace('flex', 'hidden'), 300);
            }

            // 3. Fungsi Merekam Data Asli (Logika Banner)
            function trackInitialKlienData(id) {
                const form = document.getElementById('formEditKlien_' + id);
                if (!form) return;

                const formData = new FormData(form);
                initialKlienData[id] = {};

                formData.forEach((value, key) => {
                    if (!(value instanceof File)) {
                        initialKlienData[id][key] = value;
                    }
                });
            }

            // 4. Fungsi Cek Perubahan (Logika Banner)
            function checkChangesKlien(id) {
                const form = document.getElementById('formEditKlien_' + id);
                const btnSimpan = document.getElementById('btnSimpanKlien_' + id);
                if (!form || !btnSimpan) return false;

                const currentData = new FormData(form);
                let hasChanged = false;

                currentData.forEach((value, key) => {
                    // Abaikan field internal laravel
                    if (key === '_token' || key === '_method') return;

                    if (!(value instanceof File)) {
                        if (value !== initialKlienData[id][key]) {
                            hasChanged = true;
                        }
                    } else {
                        // Cek jika ada file baru terpilih
                        if (value.size > 0) {
                            hasChanged = true;
                        }
                    }
                });

                // Update UI Tombol Simpan
                if (hasChanged) {
                    btnSimpan.disabled = false;
                    btnSimpan.className =
                        "bg-birua hover:opacity-90 text-white px-10 py-3 rounded-xl text-xs font-bold transition shadow-lg cursor-pointer";
                } else {
                    btnSimpan.disabled = true;
                    btnSimpan.className =
                        "bg-gray-400 text-white px-10 py-3 rounded-xl text-xs font-bold transition cursor-not-allowed";
                }

                return hasChanged;
            }

            // 5. Fungsi Batal Edit (Logika Banner)
            function handleCancelEditKlien(id) {
                const modalId = 'modalEdit_' + id;
                const formId = 'formEditKlien_' + id;

                if (checkChangesKlien(id)) {
                    openDiscardConfirmation('Klien', modalId, formId);
                } else {
                    closeModal(modalId, formId);
                }
            }

            // 6. Fungsi Preview File & Trigger Cek Perubahan
            function previewLogoImageEdit(input, id) {
                const preview = document.getElementById('previewLogoEdit_' + id);
                const placeholder = document.getElementById('placeholderLogoEdit_' + id);

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        if (placeholder) placeholder.classList.add('hidden');

                        // Panggil pengecekan setelah gambar dipilih
                        checkChangesKlien(id);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // 7. Modal Konfirmasi Pembatalan (Logika Banner)
            function openDiscardConfirmation(contextText, modalToCloseId, formId) {
                const discardModalId = 'editConfirmation';
                const modal = document.getElementById(discardModalId);
                const content = document.getElementById(getModalContentId(discardModalId));
                const confirmButton = document.getElementById('confirmEditButton');
                const contextSpan = document.getElementById('discardContextText');

                lastActiveModalId = modalToCloseId;
                formToResetId = formId;

                if (contextSpan) contextSpan.textContent = contextText;

                if (modal && content) {
                    modal.classList.replace('hidden', 'flex');
                    setTimeout(() => {
                        content.classList.replace('scale-95', 'scale-100');
                        content.classList.replace('opacity-0', 'opacity-100');
                    }, 10);
                }

                const newConfirmButton = confirmButton.cloneNode(true);
                confirmButton.replaceWith(newConfirmButton);

                newConfirmButton.onclick = function() {
                    closeModal(discardModalId);
                    if (lastActiveModalId && formToResetId) {
                        closeModal(lastActiveModalId, formToResetId);
                    }
                };
            }
        </script>
    @endsection
