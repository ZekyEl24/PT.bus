<!doctype html>
<html class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @if (isset($profil->logo))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $profil->logo) }}">
    @endif
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <meta property="og:image"
        content="{{ isset($profil->logo) ? asset('storage/' . $profil->logo) : asset('default-logo.png') }}">
    <title>{{ $profil->nama_profil ?? 'Company Profile' }}</title>
</head>

<body class="bg-white text-gray-900 font-sans">

    <nav x-data="{ scrolled: false }" x-init="scrolled = window.pageYOffset > 20" @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'py-3 shadow-md bg-white' : 'py-12 bg-white/90'"
        class="fixed w-full z-50 transition-all duration-500 ease-in-out border-b border-gray-100">

        <div class="max-w-400 mx-auto px-6 flex justify-between items-center relative">

            <div class="flex items-center">
                <div class="relative h-10 flex items-center">
                    <img src="{{ asset('storage/' . $profil->logo) }}"
                        :class="scrolled ? 'h-10 translate-y-0 static' : 'h-40 translate-y-1 absolute top-0'"
                        class="w-auto transition-all duration-500 ease-out object-contain z-60 max-w-none shadow-none"
                        alt="Logo">
                </div>

                <span x-show="scrolled" x-transition:enter="transition opacity ease-out duration-500"
                    x-transition:enter-start="opacity-0 -translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    class="ml-3 font-bold text-lg text-gray-900 tracking-tight hidden md:block">
                    {{ $profil->nama_profil }}
                </span>
            </div>

            <div class="flex items-center">
                @if ($kontak)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kontak->nomer_telepon) }}" target="_blank"
                        class=" text-black px-6 py-2 font-bold text-xs tracking-widest transition-all duration-300 gap-2">
                        KONTAK
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <section id="beranda" class="relative h-screen w-full overflow-hidden" x-data="heroCarousel()">
        <div class="relative h-full w-full">
            {{-- Kita buat variabel pembantu untuk index agar slider AlpineJS tetap urut (0, 1, 2...) --}}
            @php $slideIndex = 0; @endphp

            @foreach ($banners as $banner)
                @if ($banner->kategori === 'utama')
                    <div x-show="activeSlide === {{ $slideIndex }}" x-cloak
                        x-transition:enter="transition opacity-100 duration-1000" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition opacity-0 duration-1000"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="absolute inset-0">
                        <div class="absolute inset-0 bg-black/30 z-10"></div>
                        <img src="{{ asset('storage/' . $banner->gambar) }}" class="w-full h-full object-cover">
                    </div>
                    @php $slideIndex++; @endphp
                @endif
            @endforeach
        </div>

        <div class="absolute bottom-12 left-10 z-30 flex space-x-3 items-center">
            @php $buttonIndex = 0; @endphp

            @foreach ($banners as $banner)
                @if ($banner->kategori === 'utama')
                    <button @click="activeSlide = {{ $buttonIndex }}; resetTimer()"
                        :class="activeSlide === {{ $buttonIndex }} ?
                            'bg-white w-3 border-transparent' :
                            'bg-transparent w-3 border-2 border-white hover:border-gray-400'"
                        class="h-3 rounded-full transition-all duration-500 ease-in-out focus:outline-none"
                        aria-label="Go to slide {{ $buttonIndex + 1 }}">
                    </button>
                    @php $buttonIndex++; @endphp
                @endif
            @endforeach
        </div>
    </section>

    <section class="py-5 bg-white overflow-hidden">
        <div class="relative flex items-center">
            <div class="absolute inset-y-0 left-0 w-20 bg-gradient-to-r from-white to-transparent z-10"></div>
            <div class="absolute inset-y-0 right-0 w-20 bg-gradient-to-l from-white to-transparent z-10"></div>

            <div class="animate-marquee flex items-center gap-16 md:gap-24">
                {{-- Loop Pertama --}}
                @foreach ($klien as $k)
                    @if ($k->status === 'aktif')
                        <div
                            class="flex items-center justify-center w-32 md:w-32 h-20 transition-all duration-500">
                            <img src="{{ asset('storage/' . $k->logo_klien) }}" alt="{{ $k->nama_klien }}"
                                class="max-h-full max-w-full object-contain">
                        </div>
                    @endif
                @endforeach

                {{-- Duplikasi Loop (Wajib ada untuk efek tak terbatas/seamless) --}}
                @foreach ($klien as $k)
                    @if ($k->status === 'aktif')
                        <div
                            class="flex items-center justify-center w-32 md:w-40 h-20 transition-all duration-500">
                            <img src="{{ asset('storage/' . $k->logo_klien) }}" alt="{{ $k->nama_klien }}"
                                class="max-h-full max-w-full object-contain">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <style>
            /* Gunakan komentar CSS seperti ini, jangan pakai // */
            @keyframes marquee {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(-50%);
                }
            }

            .animate-marquee {
                display: flex;
                width: max-content;
                /* Pastikan nama animasinya sama dengan @keyframes di atas */
                animation: marquee 30s linear infinite;
            }

            .animate-marquee:hover {
                animation-play-state: paused;
            }
        </style>
    </section>

    <section id="tentang" class="pt-5 pb-20 font-habanera overflow-hidden" x-data="{
        scrollPercent: 0,
        updateScroll(el) {
            this.scrollPercent = (el.scrollLeft / (el.scrollWidth - el.clientWidth)) * 100;
        }
    }">
        <div class="max-w-full mx-auto px-10 md:px-15">
            <p class="text-black text-[35px] leading-relaxed mb-12 font-light text-justify">
                {{ $profil->deskripsi_profil }}</p>

            <div class="flex flex-col md:flex-row items-start gap-8 mb-16">
                <div class="shrink-0">
                    <span class="text-[18px] font-bold uppercase text-yellow-500 rounded italic">Visi</span>
                </div>
                <div class="grow">
                    <h2 class="text-3xl text-justify md:text-5xl font-bold leading-relaxed text-gray-800">
                        {!! str_replace(
                            ['unggul', 'profesional', 'berdaya saing tinggi', 'kemajuan bangsa'],
                            [
                                '<span class="text-kuning">unggul</span>',
                                '<span class="text-kuning">profesional</span>',
                                '<span class="text-kuning">berdaya saing tinggi</span>',
                                '<span class="text-birua">kemajuan bangsa</span>',
                            ],
                            $profil->visi,
                        ) !!}
                    </h2>
                </div>
            </div>

            <div class="flex items-start gap-8">
                <div class="shrink-0 pt-4">
                    <span class="text-[18px] font-bold uppercase text-yellow-500 italic">Misi</span>
                </div>

                <div class="grow overflow-hidden">
                    <div class="flex overflow-x-auto gap-6 pb-12 hide-scrollbar scroll-smooth"
                        @scroll="updateScroll($el)">
                        @foreach ($profil->misi as $m)
                            <div class="min-w-[300px] md:min-w-[450px] bg-[#FFFCF7] p-10 rounded-sm ">
                                <p class="text-gray-700 leading-relaxed text-xl">
                                    @php
                                        $words = explode(' ', $m->misi);
                                        $firstWord = array_shift($words);
                                        $remainingText = implode(' ', $words);
                                    @endphp
                                    <span class="text-yellow-500 font-bold">{{ $firstWord }}</span>
                                    {{ $remainingText }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="w-full h-[2px] bg-transparent relative">
                        <div class="absolute top-0 left-0 h-full bg-yellow-500 transition-all duration-75 ease-out"
                            :style="`width: 20%; left: ${scrollPercent * 0.8}%`">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full">
        @php
            $aboutBanner = $banners->where('kategori', 'tentang kami')->where('status', 'aktif')->first();
        @endphp

        @if ($aboutBanner)
            <div class="px-10 w-full h-[200px] md:h-[500px] overflow-hidden">
                <img src="{{ asset('storage/' . $aboutBanner->gambar) }}" class="w-full h-full object-cover"
                    alt="{{ $aboutBanner->judul }}">
            </div>
        @else
            <div class="px-10 w-full h-[200px] bg-gray-100 flex items-center justify-center border-y border-gray-200">
                <div class="text-center">
                    <p class="text-gray-400 text-sm italic">Banner kategori 'tentang kami' dengan status 'aktif' tidak
                        ditemukan.</p>
                    <p class="text-gray-300 text-[10px]">Periksa kembali pengaturan Banner di Dashboard Admin.</p>
                </div>
            </div>
        @endif
    </section>

    <section id="unitbisnis" class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-[40px] font-bold uppercase tracking-widest">Unit Bisnis</h2>
                <div class="w-20 h-1 bg-yellow-500 mx-auto mt-4"></div>
                <p class="pt-5 px-50 font-habanera font-light">Kami menghadirkan unit bisnis unggul dan profesional
                    sebagai wadah pembelajaran kewirausahaan bagi siswa — membentuk generasi siap kerja, berdaya saing,
                    dan berkontribusi bagi kemajuan bangsa.</p>
            </div>

            <div class="space-y-12">
                @foreach ($unitBisnis as $index => $ub)
                    {{-- Logika selang-seling: md:flex-row untuk index genap, md:flex-row-reverse untuk index ganjil --}}
                    <div
                        class="relative flex flex-col {{ $index % 2 == 0 ? 'md:flex-row' : 'md:flex-row-reverse' }} bg-white border border-gray-200 rounded-tl-[40px] rounded-br-[40px] overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">

                        <div class="w-full md:w-[38%] h-[250px] md:h-auto overflow-hidden p-3">
                            <img src="{{ asset('storage/' . $ub->gambar_ub) }}"
                                class="w-full h-full object-cover rounded-tl-[30px] rounded-br-[30px]"
                                alt="{{ $ub->nama_ub }}">
                        </div>

                        <div class="w-full md:w-[62%] p-8 pr-14 flex flex-col justify-center overflow-hidden">

                            <div class="flex justify-between items-center mb-6"> {{-- Ganti items-start ke items-center agar sejajar secara vertikal --}}
                                <img src="{{ asset('storage/' . $ub->logo_ub) }}" class="h-14 object-contain"
                                    alt="Logo UB">

                                <div class="flex items-center gap-4">
                                    {{-- Ikon Instagram --}}
                                    <a href="{{ $ub->link_ig_ub }}" target="_blank"
                                        class="bg-yellow-500 rounded-full w-10 h-10 flex items-center justify-center text-white transition-all hover:bg-yellow-600 hover:rotate-12 shadow-sm"
                                        title="Instagram {{ $ub->nama_ub }}">
                                        <i class="fa-brands fa-instagram text-xl"></i>
                                    </a>

                                    {{-- Tombol Kunjungi dengan Panah Miring --}}
                                    <a href="{{ $ub->link_web_ub }}" target="_blank"
                                        class="flex items-center gap-2 group">
                                        <span
                                            class="text-yellow-500 font-bold text-base tracking-wider uppercase border-b-2 border-transparent group-hover:border-yellow-500 transition-all flex items-center gap-1">
                                            KUNJUNGI
                                            <i
                                                class="inline-block transform rotate-45 transition-transform group-hover:translate-x-1 group-hover:-translate-y-1">
                                                {{-- Miringkan 45 derajat & efek hover --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 16 16">
                                                    <path fill="currentColor"
                                                        d="M4.5 14c-.28 0-.5-.22-.5-.5v-9c0-.28.22-.5.5-.5s.5.22.5.5v9c0 .28-.22.5-.5.5" />
                                                    <path fill="currentColor"
                                                        d="M8 7.5a.47.47 0 0 1-.35-.15L4.5 4.2L1.35 7.35c-.2.2-.51.2-.71 0s-.2-.51 0-.71l3.5-3.5c.2-.2.51-.2.71 0l3.5 3.5c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15" />
                                                </svg>
                                            </i>
                                        </span>
                                    </a>
                                </div>
                            </div>

                            <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $ub->nama_ub }}</h3>
                            <p class="text-gray-700 text-lg leading-relaxed mb-12 text-justify">
                                {{ $ub->deskripsi_ub }}
                            </p>

                            <div class="relative w-full overflow-hidden">
                                <div
                                    class="absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-white to-transparent z-10">
                                </div>
                                <div
                                    class="absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-white to-transparent z-10">
                                </div>

                                <div class="flex items-center gap-8 whitespace-nowrap animate-scroll-text">
                                    {{-- Loop Pertama --}}
                                    @foreach ($ub->layanan as $ly)
                                        <div class="flex items-center gap-4">
                                            <span
                                                class="text-gray-800 font-medium text-lg">{{ $ly->nama_layanan }}</span>
                                            <i class="fa-solid fa-diamond text-yellow-500 text-[10px]"></i>
                                        </div>
                                    @endforeach

                                    {{-- Loop Duplikasi untuk Seamless Loop --}}
                                    @foreach ($ub->layanan as $ly)
                                        <div class="flex items-center gap-4">
                                            <span
                                                class="text-gray-800 font-medium text-lg">{{ $ly->nama_layanan }}</span>
                                            <i class="fa-solid fa-diamond text-yellow-500 text-[10px]"></i>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <style>
                @keyframes scroll-text {
                    0% {
                        transform: translateX(0);
                    }

                    100% {
                        transform: translateX(-50%);
                    }
                }

                .animate-scroll-text {
                    display: flex;
                    width: max-content;
                    animation: scroll-text 25s linear infinite;
                }

                .animate-scroll-text:hover {
                    animation-play-state: paused;
                }
            </style>
        </div>
    </section>

    <section id="informasi" class="py-24 bg-white font-habanera overflow-hidden">
        <div class="max-w-[90rem] mx-auto px-6 md:px-10">

            <div class="flex items-center gap-4 mb-14">
                <h2 class="text-3xl md:text-[40px] font-bold uppercase tracking-tight">Informasi <span
                        class="text-gray-900">Terkini</span></h2>
                <div class="h-12 w-[3px] bg-yellow-500"></div>
                <a href="#" class="text-yellow-500 font-bold hover:underline tracking-wide">BACA
                    SELENGKAPNYA</a>
            </div>

            @if ($informasi->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                    {{-- KARTU UTAMA TERBARU (Kiri Besar) --}}
                    @php $utama = $informasi->first(); @endphp
                    <div class="lg:col-span-1 lg:row-span-2">
                        <div
                            class="group bg-white rounded-[10px] border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 h-full flex flex-col overflow-hidden">
                            <div class="relative overflow-hidden h-[350px] lg:h-[500px]">
                                <img src="{{ asset('storage/' . $utama->gambar) }}"
                                    class="w-full h-full object-cover transition-transform duration-700"
                                    alt="{{ $utama->judul }}">
                                <div class="absolute top-6 left-6">
                                    <span
                                        class="bg-yellow-500 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">TERBARU</span>
                                </div>
                            </div>
                            <div class="p-8 flex flex-col flex-grow bg-white">
                                <h3
                                    class="text-2xl font-bold text-gray-900 mb-4 line-clamp-3 group-hover:text-yellow-500 transition-colors leading-tight">
                                    {{ $utama->judul }}
                                </h3>
                                <p class="text-gray-500 line-clamp-4 text-sm mb-8 leading-relaxed">
                                    {{ strip_tags($utama->isi) }}
                                </p>
                                <div class="mt-auto pt-6 border-t border-gray-50 flex justify-between items-center">
                                    <span
                                        class="px-4 py-1.5 border border-gray-300 rounded-full text-gray-500 text-[11px] font-medium">
                                        {{ $utama->created_at->format('d F Y') }}
                                    </span>
                                    <button
                                        class="text-yellow-500 font-black text-xs uppercase flex items-center gap-2 group/btn">
                                        DETAIL <i
                                            class="fa-solid fa-arrow-right-long transition-transform group-hover/btn:translate-x-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM SAMPING & BAWAH (5 KARTU LAINNYA) --}}
                    <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($informasi->skip(1)->take(5) as $item)
                            <div
                                class="group bg-white rounded-[10px] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">
                                <div class="relative overflow-hidden h-44">
                                    <img src="{{ asset('storage/' . $item->gambar) }}"
                                        class="w-full h-full object-cover transition-transform duration-700"
                                        alt="{{ $item->judul }}">
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <h4
                                        class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-yellow-500 transition-colors leading-snug">
                                        {{ $item->judul }}
                                    </h4>
                                    <p class="text-gray-500 text-xs line-clamp-2 mb-6 leading-relaxed">
                                        {{ strip_tags($item->isi) }}
                                    </p>
                                    <div
                                        class="mt-auto flex justify-between items-center pt-4 border-t border-gray-50">
                                        <span
                                            class="px-3 py-1 border border-gray-200 rounded-full text-gray-400 text-[10px] font-medium">
                                            {{ $item->created_at->format('d F Y') }}
                                        </span>
                                        <div
                                            class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-yellow-500 group-hover:bg-yellow-500 group-hover:text-white transition-all transform group-hover:rotate-45">
                                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            @else
                <div class="text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 italic font-medium">Belum ada informasi terkini yang tersedia.</p>
                </div>
            @endif
        </div>
    </section>

    <section class="py-20 px-6">
        <div
            class="max-w-7xl mx-auto bg-gray-50 rounded-[40px] flex flex-col md:flex-row items-stretch justify-between border border-gray-100 relative overflow-hidden">

            <div class="relative z-10 md:w-1/2 text-center md:text-left p-12 md:p-20">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">
                    Tertarik dengan salah satu <span class="text-yellow-500">Unit Bisnis</span> kami?
                </h2>
                <p class="text-gray-600 mb-10">
                    Hubungi kami sekarang untuk mendapatkan informasi lebih lanjut atau
                    konsultasi mengenai layanan yang kami sediakan.
                </p>
                <a href="#"
                    class="inline-block px-10 py-4 bg-blue-600 text-white rounded-full font-bold shadow-lg shadow-blue-200 hover:scale-105 transition transform">
                    Hubungi Kami
                </a>
            </div>

            <div class="md:w-1/3 relative min-h-[250px]">
                <img src="{{ isset($hubungi) && $hubungi->foto ? asset('storage/' . $hubungi->foto) : asset('default-contact.png') }}"
                    class="absolute inset-0 w-full h-full object-cover"
                    alt="{{ $hubungi->judul ?? 'Hubungi Kami' }}">
            </div>
        </div>
    </section>

    <footer id="kontak" class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-6 text-center border-t border-gray-800 pt-8">
            <p class="text-gray-500 text-sm">© 2026 {{ $profil->nama_profil }}. All Rights Reserved.</p>
        </div>
    </footer>



    {{-- // Script Carousel Hero --}}
    <script>
        function heroCarousel() {
            return {
                activeSlide: 0,
                totalSlides: {{ $banners->count() }},
                timer: null,

                init() {
                    this.startTimer();
                },

                startTimer() {
                    this.timer = setInterval(() => {
                        this.nextSlide();
                    }, 8000); // Setel ke 10000 untuk 10 detik
                },

                nextSlide() {
                    this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
                },

                resetTimer() {
                    clearInterval(this.timer);
                    this.startTimer();
                }
            }
        }
    </script>

    <style>
        /* Sembunyikan scrollbar standar di semua browser */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        /* Hilangkan background track untuk scrollbar kustom jika masih terpakai */
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Custom Scrollbar Styling */
        .custom-scrollbar::-webkit-scrollbar {
            height: 2px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #EAB308;
        }

        /* Menghilangkan scrollbar di Firefox agar lebih bersih jika ingin pakai garis custom saja */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #EAB308;
        }
    </style>

</body>

</html>
