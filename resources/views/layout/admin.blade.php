<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* TRANSISI HALUS UTAMA */
        #sidebar,
        #sidebar .menu-text,
        #sidebar .logo-text,
        #sidebar .logo-img {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* LEBAR SIDEBAR AWAL */
        #sidebar {
            width: 298px;
            overflow: hidden;
            /* Mencegah scrollbar muncul saat animasi */
        }

        /* LEBAR SAAT COLLAPSED */
        #sidebar.collapsed {
            width: 80px;
            /* Sedikit diperlebar agar ikon pas di tengah */
        }

        /* MENGHILANGKAN TEKS SECARA HALUS */
        /* Kita manipulasi opacity dan width, bukan display:none */
        #sidebar.collapsed .menu-text,
        #sidebar.collapsed .logo-text {
            opacity: 0;
            width: 0;
            margin: 0;
            pointer-events: none;
            /* Agar tidak bisa diklik saat hilang */
        }

        /* MENGATUR POSISI ITEM AGAR IKON TIDAK GESER */
        .menu-item {
            display: flex;
            align-items: center;
            white-space: nowrap;
            /* Mencegah teks turun baris saat menyempit */
        }

        /* MEMBUAT CONTAINER IKON FIXED WIDTH */
        /* Ini kunci agar ikon tidak goyang saat sidebar menutup */
        .icon-container {
            min-width: 50px;
            /* Lebar tetap untuk area ikon */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* MENYESUAIKAN PADDING SAAT COLLAPSED */
        #sidebar.collapsed .menu-link {
            padding-left: 15px;
            /* Menyesuaikan agar ikon terlihat di tengah sidebar 80px */
            padding-right: 0;
        }

        /* LOGO SAAT COLLAPSED */
        #sidebar.collapsed .logo-area {
            justify-content: left;
            padding-left: 20px;
            padding-right: 0;
        }
    </style>

    @if (session('success_type'))
        <meta name="success-type" content="{{ session('success_type') }}">
    @endif

</head>

<body class="bg-[#f8fafc] font-habanera">
    <div class="flex h-screen overflow-hidden">

        <aside id="sidebar" class="bg-white border-r border-abutext shadow-sm flex flex-col h-full z-20">

            <div class="logo-area py-5 px-6 flex items-center gap-3 min-h-20">
                <img src="{{ $profilPerusahaan && $profilPerusahaan->logo
                    ? asset($profilPerusahaan->logo)
                    : asset('assets/default-logo.png') }}"
                    class="logo-img w-10 h-10 object-contain" alt="Logo Perusahaan">

                <div class="logo-text overflow-hidden whitespace-nowrap">
                    <h1 class="text-sm font-bold leading-4">
                        {{ $profilPerusahaan->nama_profil ?? 'Nama Perusahaan' }}
                    </h1>
                </div>
            </div>

            <nav class="mt-1 text-sm flex-1 overflow-y-auto overflow-x-hidden custom-scrollbar">
                <ul class="space-y-1">
                    <div class="w-3xs">
                        {{-- MENU YANG BISA DIAKSES SEMUA ROLE (ADMIN & EDITOR UB) --}}
                        <li>
                            <a href="{{ route('dasbor.index') }}"
                                class="menu-link flex items-center gap-3 py-3 px-4 rounded-md transition-colors duration-200
               {{ $active == 'dashboard' ? 'bg-kuning font-bold' : 'hover:bg-gray-100' }}">
                                <div class="icon-container">
                                    <i class="fa-solid fa-home text-lg"></i>
                                </div>
                                <span
                                    class="menu-text overflow-hidden whitespace-nowrap opacity-100 transition-opacity duration-300">
                                    Dasbor
                                </span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('informasiterkini.index') }}"
                                class="menu-link flex items-center gap-3 py-3 px-4 rounded-md transition-colors duration-200
                   {{ $active == 'informasi' ? 'bg-kuning font-bold' : 'hover:bg-gray-100' }}">
                                <div class="icon-container">
                                    <i class="fa-solid fa-newspaper text-lg"></i>
                                </div>
                                <span class="menu-text overflow-hidden whitespace-nowrap opacity-100">
                                    Informasi Terkini
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('ub.index') }}"
                                class="menu-link flex items-center gap-3 py-3 px-4 rounded-md transition-colors duration-200
                   {{ $active == 'ub' ? 'bg-kuning font-bold' : 'hover:bg-gray-100' }}">
                                <div class="icon-container">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M14.121 10.48a1 1 0 0 0-1.414 0l-.707.706a2 2 0 0 1-2.828-2.828l5.63-5.632a6.5 6.5 0 0 1 6.377 10.568l-2.108 2.135zM3.161 4.468a6.5 6.5 0 0 1 8.009-.938L7.757 6.944a4 4 0 0 0 5.513 5.794l.144-.137l4.243 4.242l-4.243 4.243a2 2 0 0 1-2.828 0L3.16 13.66a6.5 6.5 0 0 1 0-9.192" />
                                    </svg>
                                </div>
                                <span class="menu-text overflow-hidden whitespace-nowrap opacity-100">
                                    Unit Bisnis
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('banner.index') }}"
                                class="menu-link flex items-center gap-3 py-3 px-4 rounded-md transition-colors duration-200
                   {{ $active == 'banner' ? 'bg-kuning font-bold' : 'hover:bg-gray-100' }}">
                                <div class="icon-container">
                                    <i class="fa-solid fa-image text-lg"></i>
                                </div>
                                <span class="menu-text overflow-hidden whitespace-nowrap opacity-100">
                                    Banner
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profilklien.index') }}"
                                class="menu-link flex items-center gap-3 py-3 px-4 rounded-md transition-colors duration-200
                   {{ $active == 'profilklien' ? 'bg-kuning font-bold' : 'hover:bg-gray-100' }}">
                                <div class="icon-container">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 448 512">
                                        <path fill="currentColor"
                                            d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128m95.8 32.6L272 480l-32-136l32-56h-96l32 56l-32 136l-47.8-191.4C56.9 292 0 350.3 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-72.1-56.9-130.4-128.2-133.8" />
                                    </svg>
                                </div>
                                <span class="menu-text overflow-hidden whitespace-nowrap opacity-100">
                                    Profil Klien
                                </span>
                            </a>
                        </li>

                        {{-- MENU KHUSUS ADMIN SAJA --}}
                        @if (Auth::user()->role == 'admin')
                            <li>
                                <a href="{{ route('user.index') }}"
                                    class="menu-link flex items-center gap-3 py-3 px-4 rounded-md transition-colors duration-200
               {{ $active == 'user' ? 'bg-kuning font-bold' : 'hover:bg-gray-100' }}">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-users text-lg"></i>
                                    </div>
                                    <span class="menu-text overflow-hidden whitespace-nowrap opacity-100">
                                        Pengguna
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('profilperusahaan.index') }}"
                                    class="menu-link flex items-center gap-3 py-3 px-4 rounded-md transition-colors duration-200
                   {{ $active == 'profilperusahaan' ? 'bg-kuning font-bold ' : 'hover:bg-gray-100' }}">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-building text-lg"></i>
                                    </div>
                                    <span class="menu-text overflow-hidden whitespace-nowrap opacity-100">
                                        Profil Perusahaan
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('infokontak.index') }}"
                                    class="menu-link flex items-center gap-3 py-3 px-4 rounded-md transition-colors duration-200
                   {{ $active == 'infokontak' ? 'bg-kuning font-bold' : 'hover:bg-gray-100' }}">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-address-card text-lg"></i>
                                    </div>
                                    <span class="menu-text overflow-hidden whitespace-nowrap opacity-100">
                                        Info Kontak
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('hubungi.index') }}"
                                    class="menu-link flex items-center gap-3 py-3 px-4 rounded-md transition-colors duration-200
                   {{ $active == 'hubungi' ? 'bg-kuning font-bold' : 'hover:bg-gray-100' }}">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-phone text-lg"></i>
                                    </div>
                                    <span class="menu-text overflow-hidden whitespace-nowrap opacity-100">
                                        Hubungi
                                    </span>
                                </a>
                            </li>
                        @endif
                    </div>
                </ul>
            </nav>

            <div class="p-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="menu-link flex w-full items-center gap-3 text-sm px-1 py-3 rounded-lg transition">
                        <div class="icon-container text-red-500 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6q.425 0 .713.288T12 4t-.288.713T11 5H5v14h6q.425 0 .713.288T12 20t-.288.713T11 21zm12.175-8H10q-.425 0-.712-.288T9 12t.288-.712T10 11h7.175L15.3 9.125q-.275-.275-.275-.675t.275-.7t.7-.313t.725.288L20.3 11.3q.3.3.3.7t-.3.7l-3.575 3.575q-.3.3-.712.288t-.713-.313q-.275-.3-.262-.712t.287-.688z" />
                            </svg>
                        </div>
                        <span class="menu-text overflow-hidden whitespace-nowrap opacity-100 text-red-500">
                            Keluar
                        </span>
                    </button>
                </form>
            </div>
        </aside>


        <div class="flex-1 flex flex-col h-screen overflow-y-auto">

            <header
                class="h-[85px] w-full bg-white shadow-sm px-6 flex items-center justify-between sticky top-0 z-10 flex-shrink-0">

                <div class="flex items-center gap-2">
                    <button id="toggleSidebar" class="text-black p-2 rounded hover:bg-gray-100 transition">
                        <svg id="sidebarIcon" class="transition-transform duration-300"
                            xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="m9 10l-2 2l2 2m3-9v14M5 4h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1" />
                        </svg>
                    </button>
                    <h1 class="text-xl font-bold tracking-wide">{{ $title }}</h1>
                </div>

                <div class="flex flex-col items-end gap-1.5">
                    <div class="text-black text-xs font-bold">Halo, {{ Auth::user()->username }}!</div>
                    <div class="font-semibold text-[10px] text-white bg-birua px-5 py-1 rounded-full">
                        {{ Str::ucfirst(Auth::user()->role) }}
                    </div>
                </div>

            </header>

            <main class="flex-1 overflow-y-auto bg-[#f8fafc] p-6">
                <div class="flex-1">
                    @yield('content')
                </div>

                {{-- FOOTER --}}
                <div class="mt-8 mb-1 flex justify-center items-center">
                    <p class="text-[11px] text-gray-800 font-medium font-poppins tracking-wide">
                        © 2025 <span class="text-[#38A1E2] font-bold">coding</span><span
                            class="text-[#3B3B3B] font-bold">.site</span> - Created for PT.Berkat Untuk
                        Sesama. All rights reserved.
                    </p>
                </div>
            </main>

        </div>

    </div>

    {{-- Panggil partial view notifikasi di akhir body --}}
    @include('layout.partials.success_notification')

    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            // 1. Ubah ukuran sidebar
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');

            // 2. Putar Icon
            const icon = document.getElementById('sidebarIcon');
            icon.classList.toggle('rotate-180');
        });
    </script>

</body>

</html>
