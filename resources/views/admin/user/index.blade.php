<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Managemen Pengguna</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-[#f8fafc] font-habanera">
    @extends('layout.admin')

    @section('content')
        <div class="h-full">
            <div
                class="bg-gradient-to-t from-kuning via-kuningterang to-white p-6 rounded-[10px] shadow-lg min-h-[85vh] relative flex flex-col">

                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 px-2">
                    <h2 class="text-base font-bold text-black">Data Pengguna</h2>

                    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                        <form method="GET" action="{{ route('user.index') }}" id="filterForm"
                            class="flex flex-wrap items-center gap-3 w-full md:w-auto">

                            {{-- FILTER STATUS --}}
                            <div class="relative">
                                <input type="hidden" name="status" id="statusInput"
                                    value="{{ request('status', 'semua') }}">

                                <button type="button" id="filterBtn"
                                    class="flex items-center gap-2 px-4 py-2 border border-gray-300
                   rounded-lg text-[10px] text-gray-600 bg-white hover:bg-gray-50">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24">
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
                                    class="hidden absolute right-0 mt-2 w-36 bg-white border
                   border-gray-200 rounded-lg shadow-lg z-20">

                                    <button type="button" data-status="semua"
                                        class="filter-item w-full text-left px-4 py-2 text-[10px] hover:bg-gray-100">
                                        Semua
                                    </button>

                                    <button type="button" data-status="aktif"
                                        class="filter-item w-full text-left px-4 py-2 text-[10px] hover:bg-gray-100">
                                        Aktif
                                    </button>

                                    <button type="button" data-status="tidak aktif"
                                        class="filter-item w-full text-left px-4 py-2 text-[10px] hover:bg-gray-100">
                                        Tidak Aktif
                                    </button>
                                </div>
                            </div>

                            {{-- SEARCH --}}
                            <div class="relative w-full md:w-[280px]">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fa-solid fa-magnifying-glass text-[12px]"></i>
                                </span>

                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari Berdasarkan Nama/Email"
                                    class="bg-white w-full py-2 pl-10 pr-4 text-[10px]
                   border border-gray-300 rounded-lg
                   focus:ring-1 focus:ring-kuning outline-none"
                                    id="searchInput">
                            </div>

                            {{-- Tombol Submit untuk Search (tersembunyi) --}}
                            <button type="submit" class="hidden" id="submitBtn"></button>
                        </form>

                        {{-- Tombol Panggil Modal Tambah --}}
                        <button onclick="toggleModal('modalTambah')"
                            class="bg-birua hover:bg-biruc text-white font-habanera px-6 py-2 rounded-[10px] text-xs font-bold flex items-center gap-2 transition shadow-md">
                            Tambah <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div id="userTable" class="bg-white rounded-[10px] shadow-sm flex-1 flex flex-col overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border-separate border-spacing-0">
                            <thead>
                                <tr class="bg-kuning text-black text-xs font-semibold text-center">
                                    <th class="py-4 px-6 border-b border-gray-200">Username</th>
                                    <th class="py-4 px-6 border-b border-gray-200">Email</th>
                                    <th class="py-4 px-6 border-b border-gray-200">Role</th>
                                    <th class="py-4 px-6 border-b border-gray-200">Status</th>
                                    <th class="py-4 px-6 border-b border-gray-200">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td
                                            class="py-5 px-6 text-center border-b border-gray-100 font-medium text-gray-700">
                                            {{ $user->username }}
                                        </td>
                                        <td class="py-5 px-6 text-center border-b border-gray-100 text-gray-600 font-light">
                                            {{ $user->email }}
                                        </td>
                                        <td
                                            class="py-5 px-6 text-center border-b border-gray-100 text-gray-600 font-bold capitalize">
                                            {{ $user->role }}
                                        </td>
                                        <td class="py-5 px-6 text-center border-b border-gray-100">
                                            <div
                                                class="inline-flex items-center gap-2 border border-gray-300 rounded-full px-5 py-1.5 bg-white min-w-[120px] justify-center">
                                                <div
                                                    class="w-2.5 h-2.5 rounded-full {{ $user->status_pengguna == 'aktif' ? 'bg-aktif' : 'bg-nonaktif' }}">
                                                </div>
                                                <span
                                                    class="font-bold text-xs capitalize">{{ $user->status_pengguna }}</span>
                                            </div>
                                        </td>
                                        <td class="py-5 px-6 text-center border-b border-gray-100">
                                            <div class="flex justify-center gap-2">

                                                {{-- Tombol Edit (Telah Diubah untuk Memanggil Modal Inline) --}}
                                                <button type="button"
                                                    onclick="toggleModal('modalEdit_{{ $user->id }}')"
                                                    class="w-[30px] h-[30px] rounded-full bg-kuning text-black flex items-center justify-center hover:bg-yellow-500 transition shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="m7 17.013l4.413-.015l9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583zM18.045 4.458l1.589 1.583l-1.597 1.582l-1.586-1.585zM9 13.417l6.03-5.973l1.586 1.586l-6.029 5.971L9 15.006z" />
                                                        <path fill="currentColor"
                                                            d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01c-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2" />
                                                    </svg>
                                                </button>

                                                {{-- Tombol Hapus (Menggunakan Form DELETE) --}}
                                                <button type="button"
                                                    onclick="showDeleteConfirmation('{{ route('user.destroy', $user->id) }}')"
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


                                    {{-- ========================================================== --}}
                                    {{-- MODAL EDIT PENGGUNA (DITANAMKAN DI DALAM LOOP) --}}
                                    {{-- ========================================================== --}}
                                    <div id="modalEdit_{{ $user->id }}"
                                        class="fixed inset-0 hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4 z-40">
                                        <div id="modalContentEdit_{{ $user->id }}"
                                            class="bg-white rounded-[15px] shadow-2xl w-full max-w-[600px] transform transition-all scale-95 opacity-0 duration-300 max-h-full overflow-y-auto">
                                            @include('admin.user.edit', ['user' => $user])
                                        </div>
                                    </div>
                                    {{-- ========================================================== --}}
                                @empty
                                    <tr>
                                        <td colspan="9" class="py-18 text-center bg-white">
                                            <div class="flex flex-col items-center">
                                                {{-- Ikon --}}
                                                <div class="mb-4 text-gray-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1"
                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                    </svg>
                                                </div>
                                                {{-- Teks --}}
                                                <h3 class="text-gray-700 font-habanera font-bold text-base">Hasil Tidak
                                                    Ditemukan</h3>
                                                <p class="text-gray-500 font-habanera text-xs max-w-xs mx-auto mt-1">
                                                    Maaf, kami tidak menemukan data yang sesuai dengan kriteria atau kata
                                                    kunci Anda.
                                                </p>
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
                        @if ($users->onFirstPage())
                            <span class="p-2 text-gray-300 cursor-not-allowed"><i
                                    class="fa-solid fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="p-2 text-gray-500 hover:text-black"><i
                                    class="fa-solid fa-chevron-left"></i></a>
                        @endif

                        {{-- Angka Halaman --}}
                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if ($page == $users->currentPage())
                                <span
                                    class="w-7 h-7 flex items-center justify-center rounded bg-kuning text-black font-bold text-xs shadow-sm">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="w-7 h-7 flex items-center justify-center rounded text-gray-500 hover:bg-gray-100 text-xs font-bold">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Tombol Next --}}
                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="p-2 text-gray-500 hover:text-black"><i
                                    class="fa-solid fa-chevron-right"></i></a>
                        @else
                            <span class="p-2 text-gray-300 cursor-not-allowed"><i
                                    class="fa-solid fa-chevron-right"></i></span>
                        @endif
                    </div>
                </div>
            </div>



            {{-- Tambah pengguna --}}
            @include('admin.user.tambah')

            {{-- modal hapus --}}
            @include('layout.partials.delete_confirmation_modal')

            {{-- modal edit --}}
            @include('layout.partials.edit_confirmation')

            @include('layout.partials.success_notification')





            {{-- SCRIPT MODAL & LOGIK BARU --}}
            <script>
                // =================================================================
                // VARIABEL GLOBAL UNTUK PENYIMPANAN STATE KONFIRMASI PEMBATALAN
                // =================================================================
                let lastActiveModalId = null;
                let formToResetId = null;

                // Fungsi untuk mendapatkan ID konten yang benar berdasarkan ID modal
                function getModalContentId(modalId) {
                    if (modalId.startsWith('modalEdit_')) {
                        return `modalContentEdit_${modalId.split('_')[1]}`;
                    }
                    if (modalId === 'modalTambah') {
                        return 'modalContentTambah';
                    }
                    if (modalId === 'deleteConfirmationModal') {
                        return 'deleteConfirmationModalContent';
                    }
                    // ID konten untuk modal konfirmasi pembatalan (editConfirmation)
                    if (modalId === 'editConfirmation') {
                        return 'editConfirmationContent'; // Mengasumsikan Anda menggunakan ID ini di partial view
                    }
                    return null;
                }

                // Fungsi umum untuk membuka modal
                function toggleModal(modalId) {
                    const modal = document.getElementById(modalId);
                    // Menggunakan fungsi bantu untuk mendapatkan content ID yang benar
                    const contentId = getModalContentId(modalId);
                    const content = contentId ? document.getElementById(contentId) : null;

                    if (modal && content) {
                        if (modal.classList.contains('hidden')) {
                            // BUKA MODAL
                            modal.classList.replace('hidden', 'flex');
                            setTimeout(() => {
                                content.classList.replace('scale-95', 'scale-100');
                                content.classList.replace('opacity-0', 'opacity-100');
                            }, 10);
                        } else {
                            if (modalId.startsWith('modalEdit_')) {
                                openDiscardConfirmation(
                                    'Pengguna',
                                    modalId,
                                    `formEditPengguna_${modalId.split('_')[1]}`
                                );
                            } else {
                                closeModal(modalId, 'formTambahPengguna');
                            }
                        }
                    }
                }

                // Fungsi umum untuk menutup modal (dengan reset form opsional)
                function closeModal(modalId, formId = null, shouldReset = true) {
                    const modal = document.getElementById(modalId);
                    // Menggunakan fungsi bantu untuk mendapatkan content ID yang benar
                    const contentId = getModalContentId(modalId);
                    const content = contentId ? document.getElementById(contentId) : null;
                    const form = formId ? document.getElementById(formId) : null;

                    if (content) {
                        content.classList.replace('scale-100', 'scale-95');
                        content.classList.replace('opacity-100', 'opacity-0');
                    }

                    if (shouldReset && form) {
                        form.reset();
                        form.querySelectorAll('.text-red-500').forEach(el => el.remove());
                        form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

                        const passwordInput = form.querySelector('input[name="password"]');
                        if (passwordInput) passwordInput.value = '';
                    }

                    setTimeout(() => {
                        if (modal) {
                            modal.classList.replace('flex', 'hidden');
                        }
                    }, 300);
                }

                // Fungsi untuk menampilkan/menyembunyikan sandi
                function toggleSandi(inputId, iconId) {
                    const input = document.getElementById(inputId);
                    const icon = document.getElementById(iconId);
                    if (input && icon) {
                        if (input.type === "password") {
                            input.type = "text";
                            icon.classList.replace('fa-eye-slash', 'fa-eye');
                        } else {
                            input.type = "password";
                            icon.classList.replace('fa-eye', 'fa-eye-slash');
                        }
                    }
                }

                window.onclick = function(event) {
                    const modalTambah = document.getElementById('modalTambah');
                    const deleteModal = document.getElementById('deleteConfirmationModal');
                    const editConfirmModal = document.getElementById('editConfirmation'); // ID modal konfirmasi pembatalan

                    // Penanganan klik di luar modalTambah
                    if (event.target == modalTambah) {
                        closeModal('modalTambah', 'formTambahPengguna');
                    }

                    // Penanganan klik di luar deleteConfirmationModal
                    if (event.target == deleteModal) {
                        closeModal('deleteConfirmationModal');
                    }

                    // Penanganan klik di luar editConfirmation (Modal Pembatalan)
                    if (event.target == editConfirmModal) {
                        closeModal('editConfirmation');
                    }

                    // Cek semua modal edit
                    document.querySelectorAll('[id^="modalEdit_"]').forEach(modal => {
                        if (event.target === modal) {
                            const userId = modal.id.split('_')[1];
                            openDiscardConfirmation(
                                'Pengguna',
                                modal.id,
                                `formEditPengguna_${userId}`
                            );
                        }
                    });
                }

                // Global state untuk menyimpan data asli Pengguna
                let initialUserData = {};

                // 1. Modifikasi fungsi toggleModal agar merekam data saat modal edit user dibuka
                // Tambahkan pengecekan ini di dalam fungsi toggleModal Anda yang sudah ada
                const originalToggleModalUser = toggleModal;
                toggleModal = function(id) {
                    originalToggleModalUser(id);

                    if (id.startsWith('modalEdit_')) {
                        const userId = id.split('_')[1];
                        setTimeout(() => {
                            trackInitialUserData(userId);
                        }, 100);
                    }
                };

                // 2. Fungsi merekam data asli dari form
                function trackInitialUserData(id) {
                    const form = document.getElementById('formEditUser_' + id);
                    if (!form) return;

                    const formData = new FormData(form);
                    initialUserData[id] = {};

                    formData.forEach((value, key) => {
                        // Jangan simpan password karena defaultnya kosong di form edit
                        if (key !== 'password' && key !== '_token' && key !== '_method') {
                            initialUserData[id][key] = value;
                        }
                    });
                }

                // 3. Fungsi Cek Perubahan User (Dirty Check)
                function checkChangesUser(id) {
                    const form = document.getElementById('formEditUser_' + id);
                    const btnSimpan = document.getElementById('btnSimpanUser_' + id);
                    if (!form || !btnSimpan) return false;

                    const currentData = new FormData(form);
                    let hasChanged = false;

                    for (let [key, value] of currentData.entries()) {
                        if (key === '_token' || key === '_method' || key === 'user_id_for_edit') continue;

                        // Jika password diisi, anggap ada perubahan
                        if (key === 'password') {
                            if (value.length > 0) {
                                hasChanged = true;
                                break;
                            }
                            continue;
                        }

                        // Cek apakah nilai input sekarang berbeda dengan nilai awal
                        if (value !== initialUserData[id][key]) {
                            hasChanged = true;
                            break;
                        }
                    }

                    // Update UI Tombol Simpan
                    if (hasChanged) {
                        btnSimpan.disabled = false;
                        btnSimpan.classList.remove('bg-gray-400', 'cursor-not-allowed');
                        btnSimpan.classList.add('bg-birua', 'hover:opacity-90', 'cursor-pointer', 'shadow-birua/20');
                    } else {
                        btnSimpan.disabled = true;
                        btnSimpan.classList.add('bg-gray-400', 'cursor-not-allowed');
                        btnSimpan.classList.remove('bg-birua', 'hover:opacity-90', 'cursor-pointer', 'shadow-birua/20');
                    }

                    return hasChanged;
                }

                // 4. Fungsi Batal User (Hanya muncul konfirmasi jika ada perubahan)
                function handleCancelEditUser(id) {
                    const modalId = 'modalEdit_' + id;
                    const formId = 'formEditUser_' + id;

                    if (checkChangesUser(id)) {
                        // Jika ada perubahan, tampilkan modal konfirmasi (seperti banner)
                        openDiscardConfirmation('Pengguna', modalId, formId);
                    } else {
                        // Jika tidak ada perubahan, langsung tutup modal
                        closeModal(modalId, formId);
                    }
                }


                // ==========================================
                // FUNGSI KONFIRMASI HAPUS KHUSUS
                // ==========================================
                function showDeleteConfirmation(deleteUrl) {
                    const modal = document.getElementById('deleteConfirmationModal');
                    const content = document.getElementById('deleteConfirmationModalContent');
                    const deleteForm = document.getElementById('deleteForm');
                    const confirmButton = document.getElementById('confirmDeleteButton');

                    // 1. Tampilkan modal konfirmasi
                    if (modal && content) {
                        modal.classList.replace('hidden', 'flex');
                        setTimeout(() => {
                            content.classList.replace('scale-95', 'scale-100');
                            content.classList.replace('opacity-0', 'opacity-100');
                        }, 10);
                    }

                    // 2. Set URL aksi pada form hapus
                    deleteForm.setAttribute('action', deleteUrl);

                    // 3. Atur event listener untuk tombol 'Ya'
                    const newConfirmButton = confirmButton.cloneNode(true);
                    confirmButton.replaceWith(newConfirmButton);

                    newConfirmButton.onclick = function() {
                        // TUTUP modal konfirmasi
                        closeModal('deleteConfirmationModal');
                        newConfirmButton.disabled = true;

                        // Submit form DELETE
                        deleteForm.submit();
                    };
                }

                // =================================================================
                // FUNGSI UMUM: MEMBUKA MODAL KONFIRMASI PEMBATALAN (editConfirmation)
                // =================================================================
                /**
                 * Membuka modal konfirmasi pembatalan perubahan.
                 * @param {string} contextText - Teks konteks yang dibatalkan (misal: "Pengguna").
                 * @param {string} modalToCloseId - ID modal edit yang akan ditutup (misal: "modalEdit_123").
                 * @param {string} formId - ID form yang akan direset (misal: "formEditPengguna_123").
                 */
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

                    // 5. Mengatur Tombol 'Tidak' (Tombol Batal, biasanya tombol merah/kiri)
                    // Tombol ini harus membuka kembali modal edit yang sedang aktif
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

                // ==========================================
                // FUNGSI FILTER DAN SEARCH
                // ==========================================
                const filterBtn = document.getElementById('filterBtn');
                const filterDropdown = document.getElementById('filterDropdown');
                const filterText = document.getElementById('filterText');
                const statusInput = document.getElementById('statusInput');
                const searchInput = document.getElementById('searchInput');
                const filterForm = document.getElementById('filterForm');
                const submitBtn = document.getElementById('submitBtn');

                // Buka / tutup dropdown filter
                filterBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    filterDropdown.classList.toggle('hidden');
                });

                // Klik item dropdown filter
                document.querySelectorAll('.filter-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const selectedStatus = this.dataset.status;
                        filterText.textContent = this.textContent;
                        statusInput.value = selectedStatus;
                        filterDropdown.classList.add('hidden');

                        // Submit form filter
                        filterForm.submit();
                    });
                });

                // Tutup dropdown jika klik luar
                document.addEventListener('click', function() {
                    filterDropdown.classList.add('hidden');
                });

                // Debounce function untuk search
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        filterForm.submit();
                    }, 500); // Delay 500ms setelah user berhenti mengetik
                });

                // Enter pada search input langsung submit
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        filterForm.submit();
                    }
                });
            </script>

            @if ($errors->tambah->any() && old('_token'))
                <script>
                    toggleModal('modalTambah');
                </script>
            @endif

            @if ($errors->edit->any() && old('_token') && old('user_id_for_edit'))
                <script>
                    const userIdForError = {{ old('user_id_for_edit') }};
                    toggleModal(`modalEdit_${userIdForError}`);
                </script>
            @endif
        </div>
    @endsection
</body>

</html>
