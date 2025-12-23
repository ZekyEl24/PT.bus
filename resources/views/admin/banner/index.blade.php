<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banner</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-[#f8fafc] font-habanera">
    @extends('layout.admin')

    @section('content')
        <div class="h-full font-habanera">
            <div
                class="bg-gradient-to-t from-kuning via-kuningterang to-white p-6 rounded-[10px] shadow-lg min-h-[85vh] relative flex flex-col">

                {{-- Header & Filter --}}
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 px-2">
                    <h2 class="text-base font-bold text-black">Data Banner</h2>

                    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                        <form method="GET" action="{{ route('banner.index') }}" id="filterForm"
                            class="flex flex-wrap items-center gap-3 w-full md:w-auto">

                            {{-- Filter Kategori --}}
                            <div
                                class="inline-flex bg-white border border-gray-300 rounded-[10px] p-1 h-[34px] items-center">
                                <input type="hidden" name="kategori" id="kategoriInput"
                                    value="{{ request('kategori', 'utama') }}">
                                <button type="button" onclick="updateKategori('utama')"
                                    class="px-5 py-1.5 rounded-[10px] text-[10px] font-bold transition-all {{ request('kategori', 'utama') == 'utama' ? 'bg-black text-white' : 'text-gray-500 hover:text-black' }}">
                                    Utama
                                </button>
                                <button type="button" onclick="updateKategori('tentang kami')"
                                    class="px-5 py-1.5 rounded-[10px] text-[10px] font-bold transition-all {{ request('kategori') == 'tentang kami' ? 'bg-black text-white' : 'text-gray-500 hover:text-black' }}">
                                    Tentang Kami
                                </button>
                            </div>

                            {{-- Filter Status --}}
                            <div class="relative">
                                <input type="hidden" name="status" id="statusInput"
                                    value="{{ request('status', 'semua') }}">
                                <button type="button" id="filterBtn"
                                    class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-[10px] text-gray-600 bg-white hover:bg-gray-50 h-[34px]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5" d="M4.5 7h15M7 12h10m-7 5h4" />
                                    </svg>
                                    <span id="filterText" class="capitalize">
                                        {{ request('status') == 'tidak aktif' ? 'Tidak Aktif' : request('status', 'Semua') }}
                                    </span>
                                    <i class="fa-solid fa-chevron-down text-[10px] ml-2"></i>
                                </button>
                                <div id="filterDropdown"
                                    class="hidden absolute right-0 mt-2 w-36 bg-white border border-gray-200 rounded-lg shadow-lg z-20">
                                    <button type="button" onclick="updateStatus('semua')"
                                        class="w-full text-left px-4 py-2 text-[10px] hover:bg-gray-100">Semua</button>
                                    <button type="button" onclick="updateStatus('aktif')"
                                        class="w-full text-left px-4 py-2 text-[10px] hover:bg-gray-100">Aktif</button>
                                    <button type="button" onclick="updateStatus('tidak aktif')"
                                        class="w-full text-left px-4 py-2 text-[10px] hover:bg-gray-100">Tidak
                                        Aktif</button>
                                </div>
                            </div>

                            {{-- Search --}}
                            <div class="relative w-full md:w-[280px]">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fa-solid fa-magnifying-glass text-[12px]"></i>
                                </span>
                                <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                    placeholder="Cari Berdasarkan Judul" oninput="autoSearch()"
                                    class="bg-white w-full h-[34px] pl-10 pr-4 text-[10px] border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-kuning">
                            </div>
                        </form>

                        <button onclick="toggleModal('modalTambahBanner')"
                            class="bg-birua hover:bg-biruc text-white px-6 py-2 rounded-[10px] text-xs font-bold flex items-center gap-2 transition shadow-md h-[34px]">
                            Tambah <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

                {{-- Table --}}
                <div class="bg-white rounded-[10px] shadow-sm flex-1 flex flex-col overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border-separate border-spacing-0">
                            <thead>
                                <tr class="bg-kuning text-black text-xs font-bold text-center">
                                    <th class="py-4 px-6 border-b border-gray-200">Gambar</th>
                                    <th class="py-4 px-6 border-b border-gray-200">Judul</th>
                                    <th class="py-4 px-6 border-b border-gray-200">Dibuat</th>
                                    <th class="py-4 px-6 border-b border-gray-200">Status</th>
                                    <th class="py-4 px-6 border-b border-gray-200">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs">
                                @foreach ($banners as $banner)
                                    <tr class="hover:bg-gray-50 transition text-center">
                                        <td class="py-3 px-6 border-b border-gray-100">
                                            <img src="{{ asset('storage/' . $banner->gambar) }}"
                                                class="w-30 h-18 object-cover rounded-sm mx-auto shadow-sm">
                                        </td>
                                        <td
                                            class="py-3 px-6 border-b border-gray-100 text-center font-medium text-gray-700">
                                            {{ $banner->judul }}
                                        </td>
                                        <td class="py-3 px-6 border-b border-gray-100 text-gray-500">
                                            {{ $banner->created_at->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="py-3 px-6 border-b border-gray-100">
                                            <div
                                                class="inline-flex items-center gap-2 border border-gray-300 rounded-full px-5 py-1.5 bg-white min-w-[120px] justify-center">
                                                <div
                                                    class="w-2.5 h-2.5 rounded-full {{ $banner->status == 'aktif' ? 'bg-aktif' : 'bg-nonaktif' }}">
                                                </div>
                                                <span class="font-bold text-xs capitalize">{{ $banner->status }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 border-b border-gray-100">
                                            <div class="flex justify-center gap-2">
                                                <button onclick="toggleModal('modalEditBanner_{{ $banner->id }}')"
                                                    class="w-8 h-8 rounded-full bg-kuning text-black flex items-center justify-center hover:bg-yellow-500 shadow-sm transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="m7 17.013l4.413-.015l9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583zM18.045 4.458l1.589 1.583l-1.597 1.582l-1.586-1.585zM9 13.417l6.03-5.973l1.586 1.586l-6.029 5.971L9 15.006z" />
                                                        <path fill="currentColor"
                                                            d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01c-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2" />
                                                    </svg>
                                                </button>
                                                <button type="button"
                                                    onclick="showDeleteConfirmation('{{ route('banner.destroy', $banner->id) }}')"
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
                                    @include('admin.banner.edit')
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-auto py-6 flex justify-center">
                        {{-- Pagination --}}
                        <div class="mt-auto py-8 flex justify-center items-center gap-2">
                            {{-- Tombol Previous --}}
                            @if ($banners->onFirstPage())
                                <span class="p-2 text-gray-300 cursor-not-allowed">
                                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                                </span>
                            @else
                                <a href="{{ $banners->previousPageUrl() }}"
                                    class="p-2 text-gray-500 hover:text-black transition">
                                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                                </a>
                            @endif

                            {{-- Angka Halaman --}}
                            @foreach ($banners->getUrlRange(1, $banners->lastPage()) as $page => $url)
                                @if ($page == $banners->currentPage())
                                    <span
                                        class="w-7 h-7 flex items-center justify-center rounded bg-kuning text-black font-bold text-xs shadow-sm">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="w-7 h-7 flex items-center justify-center rounded text-gray-500 hover:bg-gray-100 text-xs font-bold transition">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Tombol Next --}}
                            @if ($banners->hasMorePages())
                                <a href="{{ $banners->nextPageUrl() }}"
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
            </div>
        </div>

        @include('layout.partials.delete_confirmation_modal')
        @include('layout.partials.success_notification')
        @include('admin.banner.tambah')


        <script>
            // MODAL CORE FUNCTIONS
            function getModalContentId(modalId) {
                if (modalId.startsWith('modalEditBanner_')) return `modalContentEditBanner_${modalId.split('_')[1]}`;
                if (modalId === 'modalTambahBanner') return 'modalContentTambahBanner';
                if (modalId === 'deleteConfirmationModal') return 'deleteConfirmationModalContent';
                return null;
            }

            function toggleModal(modalId) {
                const modal = document.getElementById(modalId);
                const contentId = getModalContentId(modalId);
                const content = document.getElementById(contentId);
                if (modal.classList.contains('hidden')) {
                    modal.classList.replace('hidden', 'flex');
                    setTimeout(() => {
                        content.classList.replace('scale-95', 'scale-100');
                        content.classList.replace('opacity-0', 'opacity-100');
                    }, 10);
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

            // IMAGE PREVIEW FUNCTION
            function previewFile(suffix) {
                const file = document.getElementById('inputGambar' + suffix).files[0];
                const preview = document.getElementById('previewImage' + suffix);
                const placeholder = document.getElementById('placeholder' + suffix);
                const reader = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                }

                if (file) {
                    reader.readAsDataURL(file);
                }
            }

            // FILTER & DROPDOWN LOGIC
            function updateKategori(val) {
                document.getElementById('kategoriInput').value = val;
                document.getElementById('filterForm').submit();
            }

            function updateStatus(val) {
                document.getElementById('statusInput').value = val;
                document.getElementById('filterForm').submit();
            }

            const filterBtn = document.getElementById('filterBtn');
            const filterDropdown = document.getElementById('filterDropdown');
            if (filterBtn) {
                filterBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    filterDropdown.classList.toggle('hidden');
                });
            }

            window.onclick = (e) => {
                if (e.target.id.startsWith('modal')) {
                    closeModal(e.target.id);
                }
                filterDropdown?.classList.add('hidden');
            };


            // DELETE CONFIRMATION
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
                    newConfirmButton.innerText = "Memproses...";

                    deleteForm.submit();
                }
            }


            // AUTO SEARCH WITH DEBOUNCE
            let typingTimer;
            const doneTypingInterval = 500; // Tunggu 0.5 detik setelah user berhenti mengetik

            function autoSearch() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(function() {
                    document.getElementById('filterForm').submit();
                }, doneTypingInterval);
            }

            // Opsional: Pastikan kursor tetap di akhir teks setelah halaman refresh/submit
            const searchInput = document.getElementById('searchInput');
            if (searchInput.value) {
                searchInput.focus();
                const val = searchInput.value;
                searchInput.value = '';
                searchInput.value = val;
            }
        </script>
    @endsection
</body>

</html>
