<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Terkini</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

@extends('layout.admin')

@section('content')
    <div class="h-full font-habanera">
        {{-- CSS Tambahan untuk menyembunyikan scrollbar --}}
        <style>
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }

            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .sticky {
                z-index: 10;
            }
        </style>

        <div
            class="bg-gradient-to-t from-kuning via-kuningterang to-white p-6 rounded-[10px] shadow-lg min-h-[85vh] relative flex flex-col">

            {{-- Header & Filter --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 px-2">
                <h2 class="text-base font-bold text-black">Data Informasi Terkini</h2>

                <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                    {{-- Filter Status & Search --}}
                    <form method="GET" action="{{ route('informasiterkini.index') }}" id="filterForm"
                        class="flex flex-wrap items-center gap-3 w-full md:w-auto">

                        {{-- Filter Status Dropdown --}}
                        <div class="relative">
                            <input type="hidden" name="status" id="statusInput" value="{{ request('status', 'semua') }}">

                            <button type="button" id="filterBtn"
                                class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-[10px] text-gray-600 bg-white hover:bg-gray-50 h-[34px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.5" d="M4.5 7h15M7 12h10m-7 5h4" />
                                </svg>
                                <span id="filterText" class="capitalize">
                                    {{ request('status') == 'nonaktif' ? 'Tidak Aktif' : request('status', 'Semua') }}
                                </span>
                                <i class="fa-solid fa-chevron-down text-[10px] ml-2"></i>
                            </button>

                            <div id="filterDropdown"
                                class="hidden absolute right-0 mt-2 w-36 bg-white border border-gray-200 rounded-lg shadow-lg z-20">
                                <button type="button" onclick="updateStatus('semua')"
                                    class="w-full text-left px-4 py-2 text-[10px] hover:bg-gray-100">Semua</button>
                                <button type="button" onclick="updateStatus('aktif')"
                                    class="w-full text-left px-4 py-2 text-[10px] hover:bg-gray-100">Aktif</button>
                                <button type="button" onclick="updateStatus('nonaktif')"
                                    class="w-full text-left px-4 py-2 text-[10px] hover:bg-gray-100">Tidak Aktif</button>
                            </div>
                        </div>

                        {{-- Input Search --}}
                        <div class="relative w-full md:w-[280px]">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fa-solid fa-magnifying-glass text-[12px]"></i>
                            </span>
                            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                placeholder="Cari Berdasarkan Judul" oninput="autoSearch()"
                                class="bg-white w-full h-[34px] pl-10 pr-4 text-[10px] border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-kuning">
                        </div>
                    </form>

                    <button onclick="toggleModal('modalTambahInformasi')"
                        class="bg-birua hover:bg-biruc text-white px-6 py-2 rounded-[10px] text-xs font-bold flex items-center gap-2 transition shadow-md h-[34px]">
                        Tambah <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>

            {{-- Table Container --}}
            <div class="bg-white rounded-[10px] shadow-sm flex-1 flex flex-col overflow-hidden">
                <div class="overflow-x-auto scrollbar-hide">
                    <table class="w-full border-separate border-spacing-0 min-w-[1400px]">
                        <thead>
                            <tr class="bg-kuning text-black text-[11px] font-bold text-center tracking-wider">
                                <th class="py-4 px-8 border-b border-gray-200">Gambar</th>
                                <th class="py-4 px-8 border-b border-gray-200">Judul Informasi Terkini</th>
                                <th class="py-4 px-12 border-b border-gray-200">Deskripsi</th>
                                <th class="py-4 px-8 border-b border-gray-200">Tanggal Pembuatan</th>
                                <th class="py-4 px-8 border-b border-gray-200">Status</th>
                                <th class="py-4 px-8 border-b border-gray-200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            @forelse ($informasi as $info)
                                <tr class="hover:bg-gray-50 transition text-center group">
                                    {{-- Gambar --}}
                                    <td class="py-4 px-6 border-b border-gray-100">
                                        <img src="{{ asset('storage/' . $info->gambar) }}"
                                            class="w-24 h-16 object-cover rounded-md mx-auto shadow-sm border border-gray-100 bg-gray-200">
                                    </td>

                                    {{-- Judul --}}
                                    <td class="py-3 px-6 border-b border-gray-100 font-bold text-gray-700">
                                        <p class="w-48 mx-auto line-clamp-2">{{ $info->judul }}</p>
                                    </td>

                                    {{-- Deskripsi --}}
                                    <td
                                        class="py-3 px-6 border-b border-gray-100 text-[10px] text-gray-500 max-w-[300px] text-left">
                                        <p class="line-clamp-3 leading-relaxed break-words whitespace-normal">
                                            {{ $info->isi }}
                                        </p>
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="py-3 px-6 border-b border-gray-100 text-gray-600 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($info->created_at)->translatedFormat('d F Y') }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="py-5 px-6 border-b border-gray-100">
                                        <div
                                            class="inline-flex items-center gap-2 border border-gray-300 rounded-full px-5 py-1.5 bg-white min-w-[120px] justify-center">
                                            <div
                                                class="w-2.5 h-2.5 rounded-full {{ $info->status == 'aktif' ? 'bg-aktif' : 'bg-nonaktif' }}">
                                            </div>
                                            <span class="font-bold capitalize whitespace-nowrap">
                                                {{ $info->status }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="py-3 px-6 border-b border-gray-100">
                                        <div class="flex justify-center gap-2">
                                            {{-- Edit --}}
                                            <button onclick="toggleModal('modalEditInformasi_{{ $info->id }}')"
                                                class="w-8 h-8 rounded-full bg-kuning text-black flex items-center justify-center hover:bg-yellow-500 transition shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="m7 17.013l4.413-.015l9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583zM18.045 4.458l1.589 1.583l-1.597 1.582l-1.586-1.585zM9 13.417l6.03-5.973l1.586 1.586l-6.029 5.971L9 15.006z" />
                                                    <path fill="currentColor"
                                                        d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01c-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2" />
                                                </svg>
                                            </button>
                                            {{-- Delete --}}
                                            <button type="button"
                                                onclick="showDeleteConfirmation('{{ route('informasiterkini.destroy', $info->id) }}')"
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
                                {{-- Modal Edit per Baris --}}
                                @include('admin.informasiterkini.edit')
                            @empty
                                <tr>
                                    <td colspan="5" class="py-18 bg-white p-0"> {{-- p-0 ditambahkan agar container bisa full lebar --}}
                                        {{-- Gunakan sticky dan left-0 agar dia selalu menempel di area yang terlihat --}}
                                        <div class="sticky left-0 w-full flex flex-col items-center py-10">
                                            <div class="mb-4 text-gray-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-gray-700 font-bold text-base">Hasil Tidak Ditemukan</h3>
                                            <p class="text-gray-500 text-xs max-w-xs mx-auto mt-1 text-center">
                                                Maaf, kami tidak menemukan data informasi yang sesuai.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-auto py-6 flex justify-center items-center gap-2">
                    @if ($informasi->onFirstPage())
                        <span class="p-2 text-gray-300 cursor-not-allowed"><i
                                class="fa-solid fa-chevron-left text-[10px]"></i></span>
                    @else
                        <a href="{{ $informasi->previousPageUrl() }}"
                            class="p-2 text-gray-500 hover:text-black transition"><i
                                class="fa-solid fa-chevron-left text-[10px]"></i></a>
                    @endif

                    @foreach ($informasi->getUrlRange(1, $informasi->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                            class="w-7 h-7 flex items-center justify-center rounded text-xs font-bold transition {{ $page == $informasi->currentPage() ? 'bg-kuning text-black shadow-sm' : 'text-gray-500 hover:bg-gray-100' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if ($informasi->hasMorePages())
                        <a href="{{ $informasi->nextPageUrl() }}"
                            class="p-2 text-gray-500 hover:text-black transition"><i
                                class="fa-solid fa-chevron-right text-[10px]"></i></a>
                    @else
                        <span class="p-2 text-gray-300 cursor-not-allowed"><i
                                class="fa-solid fa-chevron-right text-[10px]"></i></span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Includes Modals --}}
    @include('layout.partials.delete_confirmation_modal')
    @include('layout.partials.success_notification')
    @include('layout.partials.edit_confirmation')
    @include('admin.informasiterkini.tambah')

    <script>
        // Fungsi untuk memperbarui filter status dan submit form
        function updateStatus(status) {
            document.getElementById('statusInput').value = status;
            document.getElementById('filterForm').submit();
        }

        // Fungsi untuk pencarian otomatis dengan delay (debounce) agar tidak memberatkan server
        let searchTimer;

        function autoSearch() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 800); // Submit otomatis setelah 0.8 detik berhenti mengetik
        }

        // Toggle Dropdown Filter Status
        const filterBtn = document.getElementById('filterBtn');
        const filterDropdown = document.getElementById('filterDropdown');

        if (filterBtn) {
            filterBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                filterDropdown.classList.toggle('hidden');
            });
        }

        // Tutup dropdown jika klik di luar area
        window.addEventListener('click', function(e) {
            if (!filterBtn.contains(e.target) && !filterDropdown.contains(e.target)) {
                filterDropdown.classList.add('hidden');
            }
        });

        // --- MODAL CORE FUNCTIONS ---

        function getModalContentId(modalId) {
            if (modalId === 'deleteConfirmationModal') return 'deleteConfirmationModalContent';
            if (modalId === 'modalTambahInformasi') return 'modalContentTambahInformasi';
            if (modalId === 'deleteConfirmationModal') return 'deleteConfirmationModalContent';
            if (modalId === 'editConfirmation') return 'editConfirmationContent';
            if (modalId.startsWith('modalEditInformasi_')) return 'modalContentEditInformasi_' + modalId.split('_')[1];
            return 'modalContent' + modalId.replace('modal', '');
        }

        function toggleModal(id) {
            const modal = document.getElementById(id);
            const contentId = getModalContentId(id);
            const content = document.getElementById(contentId);

            if (modal && content) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 10);
            }
        }

        function closeModal(modalId, formId = null) {
            const modal = document.getElementById(modalId);
            const contentId = getModalContentId(modalId);
            const content = document.getElementById(contentId);

            if (modal && content) {
                content.classList.replace('scale-100', 'scale-95');
                content.classList.replace('opacity-100', 'opacity-0');

                setTimeout(() => {
                    modal.classList.replace('flex', 'hidden');
                    if (formId) {
                        const form = document.getElementById(formId);
                        if (form) form.reset();
                    }
                }, 300);
            }
        }

        function showDeleteConfirmation(deleteUrl) {
            const modal = document.getElementById('deleteConfirmationModal');
            const content = document.getElementById('deleteConfirmationModalContent');
            const deleteForm = document.getElementById('deleteForm');
            const confirmButton = document.getElementById('confirmDeleteButton');

            if (modal && content) {
                modal.classList.replace('hidden', 'flex');
                setTimeout(() => {
                    content.classList.replace('scale-95', 'scale-100');
                    content.classList.replace('opacity-0', 'opacity-100');
                }, 10);
            }
            deleteForm.setAttribute('action', deleteUrl);

            const newConfirmButton = confirmButton.cloneNode(true);
            confirmButton.replaceWith(newConfirmButton);

            newConfirmButton.onclick = function() {
                closeModal('deleteConfirmationModal');

                newConfirmButton.disabled = true;
                deleteForm.submit();
            };
        }

        // Variable global untuk menyimpan state modal yang sedang diedit
        let lastActiveModalId = null;
        let formToResetId = null;

        function openDiscardConfirmation(contextText, modalToCloseId, formId) {
            const discardModalId = 'editConfirmation'; // Menggunakan ID yang Anda tentukan
            const confirmButtonId = 'confirmEditButton'; // ID tombol "Ya" dari modal yang Anda berikan

            const contextSpan = document.getElementById('discardContextText'); // Asumsi ada elemen ini di partial view
            const confirmButton = document.getElementById(confirmButtonId);

            // 1. Menyimpan state modal dan form yang sedang aktif
            lastActiveModalId = modalToCloseId;
            formToResetId = formId;

            // 2. Mengatur teks dinamis pada modal konfirmasi
            if (contextSpan) {
                contextSpan.textContent = contextText;
            }

            // 3. Menampilkan modal konfirmasi pembatalan
            const discardContentId = getModalContentId(discardModalId);
            const modal = document.getElementById(discardModalId);
            const content = document.getElementById(discardContentId);

            if (modal && content) {
                modal.classList.replace('hidden', 'flex');
                setTimeout(() => {
                    content.classList.replace('scale-95', 'scale-100');
                    content.classList.replace('opacity-0', 'opacity-100');
                }, 10);
            }

            // 4. MENGHAPUS & Mengatur ulang fungsi tombol 'Ya' (confirmEditButton)
            const newConfirmButton = confirmButton.cloneNode(true);
            confirmButton.replaceWith(newConfirmButton);

            newConfirmButton.onclick = function() {
                // A. Menutup modal konfirmasi pembatalan
                closeModal(discardModalId);

                if (lastActiveModalId && formToResetId) {
                    // B. Menutup modal edit dan mereset form yang ditargetkan
                    closeModal(lastActiveModalId, formToResetId, true);
                }

                // C. Membersihkan state
                lastActiveModalId = null;
                formToResetId = null;
            };

            const noButton = document.querySelector(`#${discardModalId} button.bg-red-600`);
            if (noButton) {
                // Clone dan replace untuk menghindari event listener duplikat
                const newNoButton = noButton.cloneNode(true);
                noButton.replaceWith(newNoButton);

                newNoButton.onclick = function() {
                    closeModal(discardModalId);
                    if (lastActiveModalId) {
                        // Membuka kembali modal edit yang sedang aktif
                        toggleModal(lastActiveModalId);
                    }
                };
            }
        }


        // Fungsi untuk memeriksa perubahan pada form edit dan mengaktifkan tombol Simpan
        // Objek global untuk menyimpan data awal modal
        let initialFormDataMap = {};

        // Override fungsi toggleModal untuk menangkap data awal saat modal Edit dibuka
        const originalToggleModal = toggleModal;
        toggleModal = function(id) {
            originalToggleModal(id);

            // Jika yang dibuka adalah modal edit, rekam data awalnya
            if (id.startsWith('modalEditInformasi_')) {
                const infoId = id.split('_')[1];
                setTimeout(() => {
                    trackInitialData(infoId);
                }, 100); // Beri jeda sedikit agar DOM siap
            }
        };

        // Fungsi untuk merekam data asli dari form
        function trackInitialData(id) {
            const form = document.getElementById('formEditInformasi_' + id);
            if (!form) return;

            const formData = new FormData(form);
            initialFormDataMap[id] = {};

            formData.forEach((value, key) => {
                if (!(value instanceof File)) {
                    initialFormDataMap[id][key] = value;
                }
            });
        }

        // Fungsi untuk mengecek apakah ada perubahan
        function checkChanges(id) {
            const form = document.getElementById('formEditInformasi_' + id);
            const btnSimpan = document.getElementById('btnSimpan_' + id);
            const currentData = new FormData(form);
            let hasChanged = false;

            currentData.forEach((value, key) => {
                if (!(value instanceof File)) {
                    // Cek perubahan teks/radio
                    if (value !== initialFormDataMap[id][key]) {
                        hasChanged = true;
                    }
                } else {
                    // Cek jika ada file baru yang dipilih
                    if (value.size > 0) {
                        hasChanged = true;
                    }
                }
            });

            // Update UI Tombol Simpan
            if (hasChanged) {
                btnSimpan.disabled = false;
                btnSimpan.className =
                    "px-12 py-3 bg-birua text-white rounded-xl text-xs font-bold hover:opacity-90 transition shadow-lg shadow-birua/20 cursor-pointer";
            } else {
                btnSimpan.disabled = true;
                btnSimpan.className =
                    "px-12 py-3 bg-gray-400 text-white rounded-xl text-xs font-bold transition cursor-not-allowed";
            }

            return hasChanged;
        }

        // Fungsi untuk menangani tombol Batal
        function handleCancelEdit(id) {
            const modalId = 'modalEditInformasi_' + id;
            const formId = 'formEditInformasi_' + id;

            if (checkChanges(id)) {
                // Jika ada perubahan, tampilkan modal konfirmasi buang perubahan
                openDiscardConfirmation('Informasi Terkini', modalId, formId);
            } else {
                // Jika tidak ada perubahan, langsung tutup modal tanpa konfirmasi
                closeModal(modalId, formId);
            }
        }

        // Update fungsi previewFileEdit agar memanggil checkChanges
        function previewFileEdit(id) {
            const preview = document.getElementById('previewImage_' + id);
            const file = document.getElementById('inputFoto_' + id).files[0];
            const placeholder = document.getElementById('placeholderUpload_' + id);
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                // PENTING: Jalankan pengecekan setelah gambar berubah
                checkChanges(id);
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection

</html>
