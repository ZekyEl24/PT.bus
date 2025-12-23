<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Bisnis</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-[#f8fafc] font-habanera">
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

                /* Menghilangkan border double saat sticky */
                .sticky {
                    z-index: 10;
                }
            </style>

            <div
                class="bg-gradient-to-t from-kuning via-kuningterang to-white p-6 rounded-[10px] shadow-lg min-h-[85vh] relative flex flex-col">

                {{-- Header & Filter --}}
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 px-2">
                    <h2 class="text-base font-bold text-black">Data Unit Bisnis</h2>

                    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                        {{-- Filter Status --}}
                        <form method="GET" action="{{ route('ub.index') }}" id="filterForm"
                            class="flex flex-wrap items-center gap-3 w-full md:w-auto">

                            {{-- Filter Status Dropdown --}}
                            <div class="relative">
                                {{-- Input hidden ini sekarang di dalam form --}}
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

                            {{-- Input Search --}}
                            <div class="relative w-full md:w-[280px]">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fa-solid fa-magnifying-glass text-[12px]"></i>
                                </span>
                                <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                    placeholder="Cari Berdasarkan Nama UB" oninput="autoSearch()"
                                    class="bg-white w-full h-[34px] pl-10 pr-4 text-[10px] border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-kuning">
                            </div>
                        </form>

                        <button onclick="toggleModal('modalTambahUB')"
                            class="bg-birua hover:bg-biruc text-white px-6 py-2 rounded-[10px] text-xs font-bold flex items-center gap-2 transition shadow-md h-[34px]">
                            Tambah <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

                {{-- Table Container dengan Horizontal Scroll --}}
                <div class="bg-white rounded-[10px] shadow-sm flex-1 flex flex-col overflow-hidden">
                    <div class="overflow-x-auto scrollbar-hide">
                        {{-- min-w-[1300px] memaksa tabel untuk bisa di-scroll ke samping --}}
                        <table class="w-full border-separate border-spacing-0 min-w-[1300px]">
                            <thead>
                                <tr class="bg-kuning text-black text-[11px] font-bold text-center tracking-wider">
                                    <th class="py-4 px-10 border-b border-gray-200">Logo</th>
                                    <th class="py-4 px-8 border-b border-gray-200">Nama Unit Bisnis</th>
                                    <th class="py-4 px-16 border-b border-gray-200">Deskripsi</th>
                                    <th class="py-4 px-8 border-b border-gray-200">Layanan</th>
                                    <th class="py-4 px-16 border-b border-gray-200">Gambar</th>
                                    <th class="py-4 px-8 border-b border-gray-200">Link Website</th>
                                    <th class="py-4 px-8 border-b border-gray-200">Link Media Sosial</th>
                                    <th class="py-4 px-8 border-b border-gray-200">Status</th>
                                    <th class="py-4 px-8 border-b border-gray-200">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-[12px]">
                                @foreach ($unitBisnis as $ub)
                                    <tr class="hover:bg-gray-50 transition text-center group">
                                        {{-- Logo (Sticky Left) --}}
                                        <td class="py-3 px-8 border-b border-gray-100 ">
                                            <img src="{{ asset('storage/' . $ub->logo_ub) }}"
                                                class="w-10 h-10 object-contain mx-auto">
                                        </td>

                                        {{-- Nama --}}
                                        <td class="py-3 px-16 border-b border-gray-100 font-light text-gray-700 ">
                                            {{ $ub->nama_ub }}
                                        </td>

                                        {{-- Deskripsi --}}
                                        <td
                                            class="py-3 px-6 border-b border-gray-100 text-[10px] text-gray-500 min-w-[300px] max-w-[400px] text-left">
                                            <p class="line-clamp-2 leading-relaxed warp-break-words whitespace-normal">
                                                {{ $ub->deskripsi_ub }}</p>
                                        </td>

                                        {{-- Layanan --}}
                                        <td class="py-3 px-8 border-b border-gray-100">
                                            <button
                                                onclick="openLayananModal('{{ $ub->nama_ub }}', {{ json_encode($ub->layanan) }})"
                                                class="flex items-center justify-center gap-2 border border-gray-300 rounded-full px-6 py-1 bg-white hover:bg-gray-50 transition min-w-20 whitespace-nowrap">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M3.161 4.469a6.5 6.5 0 0 1 8.84-.328a6.5 6.5 0 0 1 9.178 9.154l-7.765 7.79a2 2 0 0 1-2.719.102l-.11-.101l-7.764-7.791a6.5 6.5 0 0 1 .34-8.826m1.414 1.414a4.5 4.5 0 0 0-.146 6.21l.146.154L12 19.672l5.303-5.305l-3.535-3.534l-1.06 1.06a3 3 0 0 1-4.244-4.242l2.102-2.103a4.5 4.5 0 0 0-5.837.189zm8.486 2.828a1 1 0 0 1 1.414 0l4.242 4.242l.708-.706a4.5 4.5 0 0 0-6.211-6.51l-.153.146l-3.182 3.182a1 1 0 0 0-.078 1.327l.078.087a1 1 0 0 0 1.327.078l.087-.078z" />
                                                </svg>
                                                <span class="font-bold text-[9px]">Lihat Layanan</span>
                                            </button>
                                        </td>

                                        {{-- Gambar --}}
                                        <td class="py-4 px-8 border-b border-gray-100">
                                            <img src="{{ asset('storage/' . $ub->gambar_ub) }}"
                                                class="w-26 h-16 object-cover rounded-md mx-auto shadow-sm border border-gray-100">
                                        </td>

                                        {{-- Link Website (Konsep Pill) --}}
                                        <td class="py-3 px-8 border-b border-gray-100">
                                            <a href="{{ $ub->link_web_ub }}" target="_blank"
                                                class="inline-flex items-center gap-2 bg-[#E5E7EB] text-gray-700 py-1.5 px-20 rounded-full hover:bg-gray-300 transition w-32 justify-center shadow-inner">
                                                <i class="fa-solid fa-link text-[9px]"></i>
                                                <span
                                                    class="font-bold tracking-tighter text-[10px]">{{ $ub->link_web_ub ? parse_url($ub->link_web_ub, PHP_URL_HOST) : 'No Link' }}</span>
                                            </a>
                                        </td>

                                        {{-- Link Media Sosial (Konsep Pill) --}}
                                        <td class="py-3 px-6 border-b border-gray-100">
                                            <a href="{{ $ub->link_ig_ub }}" target="_blank"
                                                class="inline-flex items-center gap-2 bg-[#E5E7EB] text-gray-700 px-4 py-1.5 rounded-full hover:bg-gray-300 transition w-32 justify-center shadow-inner">
                                                <i class="fa-solid fa-link text-[9px]"></i>
                                                <span class="font-bold tracking-tighter text-[10px]">
                                                    @if ($ub->link_ig_ub)
                                                        {{-- Mengambil 'instagram.com' atau host lainnya --}}
                                                        {{ str_replace('www.', '', parse_url($ub->link_ig_ub, PHP_URL_HOST)) }}
                                                    @else
                                                        No Link
                                                    @endif
                                                </span>
                                            </a>
                                        </td>

                                        {{-- Status --}}
                                        <td class="py-3 px-6 border-b border-gray-100">
                                            <div
                                                class="inline-flex items-center gap-2 border border-gray-300 rounded-full px-5 py-1.5 bg-white min-w-[120px] justify-center">
                                                <div
                                                    class="w-2.5 h-2.5 rounded-full {{ $ub->status == 'aktif' ? 'bg-aktif' : 'bg-nonaktif' }}">
                                                </div>
                                                <span class="font-bold text-xs capitalize">{{ $ub->status }}</span>
                                            </div>
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="py-3 px-6 border-b border-gray-100 ">
                                            <div class="flex justify-center gap-2">
                                                <button onclick="toggleModal('modalEditUB_{{ $ub->id_ub }}')"
                                                    class="w-7 h-7 rounded-full bg-kuning text-black flex items-center justify-center hover:bg-yellow-500 shadow-sm transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="m7 17.013l4.413-.015l9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583zM18.045 4.458l1.589 1.583l-1.597 1.582l-1.586-1.585zM9 13.417l6.03-5.973l1.586 1.586l-6.029 5.971L9 15.006z" />
                                                        <path fill="currentColor"
                                                            d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01c-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2" />
                                                    </svg>
                                                </button>
                                                <button type="button"
                                                    onclick="showDeleteConfirmation('{{ route('ub.destroy', $ub->id_ub) }}')"
                                                    class="w-7 h-7 rounded-full bg-birud text-white flex items-center justify-center hover:bg-red-900 transition shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6zM8 9h8v10H8zm7.5-5l-1-1h-5l-1 1H5v2h14V4z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('admin.unitbisnis.edit')
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-auto py-6 flex justify-center items-center gap-2">
                        {{-- ... bagian pagination tetap sama ... --}}
                        @if ($unitBisnis->onFirstPage())
                            <span class="p-2 text-gray-300 cursor-not-allowed"><i
                                    class="fa-solid fa-chevron-left text-[10px]"></i></span>
                        @else
                            <a href="{{ $unitBisnis->previousPageUrl() }}"
                                class="p-2 text-gray-500 hover:text-black transition"><i
                                    class="fa-solid fa-chevron-left text-[10px]"></i></a>
                        @endif

                        @foreach ($unitBisnis->getUrlRange(1, $unitBisnis->lastPage()) as $page => $url)
                            <a href="{{ $url }}"
                                class="w-7 h-7 flex items-center justify-center rounded text-xs font-bold transition {{ $page == $unitBisnis->currentPage() ? 'bg-kuning text-black shadow-sm' : 'text-gray-500 hover:bg-gray-100' }}">
                                {{ $page }}
                            </a>
                        @endforeach

                        @if ($unitBisnis->hasMorePages())
                            <a href="{{ $unitBisnis->nextPageUrl() }}"
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


        @include('layout.partials.delete_confirmation_modal')
        @include('layout.partials.success_notification')
        @include('admin.unitbisnis.tambah')
        @include('admin.unitbisnis.layanan')




        <script>
            function openLayananModal(namaUb, layananData) {
                const modal = document.getElementById('modalLayanan');
                const content = document.getElementById('modalContentLayanan');
                const listContainer = document.getElementById('listLayanan');

                // Bersihkan isi modal sebelumnya
                listContainer.innerHTML = '';

                // Logika parsing data (Handle jika data berupa string dipisah koma atau array)
                let layananArray = [];
                if (Array.isArray(layananData)) {
                    layananArray = layananData;
                } else if (typeof layananData === 'string') {
                    layananArray = layananData.split(',').map(s => s.trim());
                }

                // Buat elemen visual sesuai foto (dashed border)
                if (layananArray && layananArray.length > 0) {
                    layananArray.forEach(item => {
                        const div = document.createElement('div');
                        div.className =
                            "w-full p-4 border-2 border-dashed border-gray-300 rounded-xl text-gray-600 font-medium text-sm text-center";
                        div.textContent = `<< ${item} >>`;
                        listContainer.appendChild(div);
                    });
                } else {
                    listContainer.innerHTML =
                        '<p class="text-center text-gray-400 py-4 italic">Belum ada layanan untuk unit ini.</p>';
                }

                // Tampilkan Modal
                modal.classList.replace('hidden', 'flex');
                setTimeout(() => {
                    content.classList.replace('scale-95', 'scale-100');
                    content.classList.replace('opacity-0', 'opacity-100');
                }, 10);
            }

            function closeLayananModal() {
                const modal = document.getElementById('modalLayanan');
                const content = document.getElementById('modalContentLayanan');

                content.classList.replace('scale-100', 'scale-95');
                content.classList.replace('opacity-100', 'opacity-0');
                setTimeout(() => {
                    modal.classList.replace('flex', 'hidden');
                }, 300);
            }

            function getModalContentId(modalId) {
                if (modalId.startsWith('modalEditUB_')) return `modalContentEditUB_${modalId.split('_')[1]}`;
                if (modalId === 'modalTambahUB') return 'modalContentTambahUB';
                if (modalId === 'deleteConfirmationModal') return 'deleteConfirmationModalContent';
                return null;
            }

            function toggleModal(modalId) {
                const modal = document.getElementById(modalId);
                const contentId = getModalContentId(modalId);
                const content = document.getElementById(contentId);
                if (modal && modal.classList.contains('hidden')) {
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

            let typingTimer;

            function autoSearch() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(function() {
                    document.getElementById('filterForm').submit();
                }, 500);
            }

            function showDeleteConfirmation(deleteUrl) {
                const modal = document.getElementById('deleteConfirmationModal');
                const content = document.getElementById('deleteConfirmationModalContent');
                const deleteForm = document.getElementById('deleteForm');
                if (modal && content) {
                    modal.classList.replace('hidden', 'flex');
                    setTimeout(() => {
                        content.classList.replace('scale-95', 'scale-100');
                        content.classList.replace('opacity-0', 'opacity-100');
                    }, 10);
                }
                deleteForm.setAttribute('action', deleteUrl);
            }

            window.onclick = (e) => {
                if (e.target.id.startsWith('modal')) closeModal(e.target.id);
            };

            // Tambahkan fungsi ini di dalam script
            function updateStatus(val) {
                document.getElementById('statusInput').value = val;
                document.getElementById('filterForm').submit();
            }

            // Logic untuk membuka/tutup dropdown status
            const filterBtn = document.getElementById('filterBtn');
            const filterDropdown = document.getElementById('filterDropdown');

            if (filterBtn) {
                filterBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    filterDropdown.classList.toggle('hidden');
                });
            }

            // Menutup dropdown jika klik di luar
            window.onclick = (e) => {
                if (e.target.id.startsWith('modal')) {
                    closeModal(e.target.id);
                }
                if (filterDropdown && !filterBtn.contains(e.target)) {
                    filterDropdown.classList.add('hidden');
                }
            };

            // Fungsi untuk Modal TAMBAH
            function addLayananFieldTambah() {
                const container = document.getElementById('layananContainerTambah');
                const div = document.createElement('div');
                div.className = 'flex items-center gap-2 mt-2';
                div.innerHTML = `
                    <input type="text" name="layanan[]" placeholder="Masukkan Nama Layanan"
                        class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition">
                    <button type="button" onclick="this.parentElement.remove()"
                        class="bg-birue text-white w-9 h-9 rounded-lg flex items-center justify-center hover:bg-red-600 transition flex-shrink-0">
                        <i class="fa-solid fa-trash-can text-xs"></i>
                    </button>
                `;
                container.appendChild(div);
            }

            // Fungsi untuk Modal EDIT (Dinamis berdasarkan ID UB)
            function addLayananFieldEdit(id) {
                const container = document.getElementById(`layananContainerEdit_${id}`);
                const div = document.createElement('div');
                div.className = 'flex items-center gap-2 mt-2';
                div.innerHTML = `
                    <input type="text" name="nama_layanan[]" placeholder="Masukkan Layanan Baru"
                        class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition">
                    <button type="button" onclick="this.parentElement.remove()"
                        class="bg-birue text-white w-9 h-9 rounded-lg flex items-center justify-center hover:bg-red-600 transition flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6zM8 9h8v10H8zm7.5-5l-1-1h-5l-1 1H5v2h14V4z" /></svg>
                    </button>
                `;
                container.appendChild(div);
            }
        </script>
    @endsection
</body>

</html>
