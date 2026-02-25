@extends('layout.admin')

@section('content')
    <div class="h-full space-y-6">
        {{-- 1. ROW ATAS: KARTU STATISTIK --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Klien --}}
            <div class="bg-white p-6 rounded-[20px] shadow-sm flex justify-between items-center border border-gray-100">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Klien</p>
                    <h3 class="text-4xl font-bold text-gray-800 mt-1">{{ $stats['klien'] }}</h3>
                    <p class="text-gray-400 text-[10px] mt-2">Semua layanan</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-2xl">
                    <i class="fa-solid fa-user-tie text-3xl text-gray-700"></i>
                </div>
            </div>

            {{-- Layanan --}}
            <div class="bg-white p-6 rounded-[20px] shadow-sm flex justify-between items-center border border-gray-100">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Layanan</p>
                    <h3 class="text-4xl font-bold text-gray-800 mt-1">{{ $stats['layanan'] }}</h3>
                    <p class="text-gray-400 text-[10px] mt-2">Layanan tersedia</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-2xl">
                    <i class="fa-solid fa-hand-holding-heart text-3xl text-gray-700"></i>
                </div>
            </div>

            {{-- Pengunjung --}}
            <div class="bg-white p-6 rounded-[20px] shadow-sm flex justify-between items-center border border-gray-100">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pengunjung</p>
                    <h3 class="text-4xl font-bold text-gray-800 mt-1">{{ $stats['pengunjung'] }}</h3>
                    <p class="text-gray-400 text-[10px] mt-2">Orang telah mengunjungi</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-2xl">
                    <i class="fa-solid fa-users text-3xl text-gray-700"></i>
                </div>
            </div>
        </div>

        {{-- 2. ROW TENGAH: GRAFIK & RIWAYAT --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- Statistik Pengunjung (Donat) --}}
            <div class="lg:col-span-3 bg-white p-6 rounded-[20px] shadow-sm border border-gray-100">
                <h3 class="text-gray-800 font-bold text-sm">Statistik Pengunjung</h3>
                <p class="text-gray-400 text-[10px] mb-6">Tanggal: 13 - 19 Oktober 2025</p>

                <div class="relative flex justify-center items-center mb-6">
                    <canvas id="donutChart" width="200" height="200"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-bold text-gray-800">143</span>
                    </div>
                </div>

                {{-- Legend Donat --}}
                <div class="grid grid-cols-2 gap-2 mt-4">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-blue-700"></div>
                        <span class="text-[10px] text-gray-600">Elite</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-blue-400"></div>
                        <span class="text-[10px] text-gray-600">CodingSite</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-yellow-400"></div>
                        <span class="text-[10px] text-gray-600">Ekual</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-green-800"></div>
                        <span class="text-[10px] text-gray-600">Dapur Negeriku</span>
                    </div>
                </div>
            </div>

            {{-- Grafik Pengunjung (Line Chart) --}}
            <div class="lg:col-span-6 bg-white p-6 rounded-[20px] shadow-sm border border-gray-100 relative">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-gray-800 font-bold text-sm">Grafik Pengunjung</h3>
                        <p class="text-gray-400 text-[10px]">Bulan: Oktober</p>
                    </div>
                    {{-- Filter Tab --}}
                    <div class="inline-flex bg-gray-100 p-1 rounded-lg text-[10px]">
                        <button class="px-3 py-1 text-gray-500">Harian</button>
                        <button class="px-3 py-1 bg-black text-white rounded-md font-bold">Mingguan</button>
                        <button class="px-3 py-1 text-gray-500">Bulanan</button>
                    </div>
                </div>

                <div class="h-[250px]">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>

            {{-- Riwayat Aksi Model Card Ringkas --}}
            <div class="lg:col-span-3 bg-white p-6 rounded-[20px] shadow-sm border border-gray-100 flex flex-col h-[450px]">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-gray-800 font-bold text-sm">Riwayat Aksi</h3>
                    <span class="text-[9px] text-gray-800 italic bg-gray-200 p-1 px-4 rounded-2xl">Terbaru</span>
                </div>

                <div class="space-y-3 overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($logs as $log)
                        {{-- Card Item --}}
                        <div
                            class="group bg-white border border-gray-100 rounded-xl p-3 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] hover:shadow-md transition-all duration-300 border-l-[4px]
                @if ($log->aksi == 'Tambah') border-l-green-500
                @elseif($log->aksi == 'Edit') border-l-yellow-400
                @else border-l-red-500 @endif">

                            <div class="flex justify-between items-start mb-1">
                                {{-- Judul Gabungan: Aksi + Model --}}
                                <p class="text-[11px] font-bold text-gray-800">
                                    <span
                                        class="@if ($log->aksi == 'Tambah') text-green-600
                                     @elseif($log->aksi == 'Edit') text-yellow-600
                                     @else text-red-600 @endif">
                                        {{ $log->aksi }}
                                    </span>
                                    <span class="text-gray-400 mx-1">•</span>
                                    {{ $log->model }}
                                </p>
                                <span class="text-[8px] text-gray-400 whitespace-nowrap ml-2">
                                    {{ $log->created_at->diffForHumans(null, true) }}
                                </span>
                            </div>

                            <p class="text-[10px] text-gray-500 leading-relaxed">
                                <span class="font-bold text-birua">{{ $log->user->username ?? 'Sistem' }}</span>
                                {{ $log->deskripsi }}
                            </p>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-20 opacity-50 text-center">
                            <i class="fa-solid fa-inbox text-2xl text-gray-300 mb-2"></i>
                            <p class="text-[10px] text-gray-400">Belum ada aktivitas</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <style>
                .custom-scrollbar::-webkit-scrollbar {
                    width: 4px;
                }

                .custom-scrollbar::-webkit-scrollbar-track {
                    background: transparent;
                }

                .custom-scrollbar::-webkit-scrollbar-thumb {
                    background: #f1f1f1;
                    border-radius: 10px;
                }

                .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                    background: #e5e7eb;
                }
            </style>

        </div>
    </div>

    {{-- Tambahkan library Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // 1. Donut Chart
        const ctxDonut = document.getElementById('donutChart').getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [30, 40, 15, 15],
                    backgroundColor: ['#1d4ed8', '#60a5fa', '#facc15', '#166534'],
                    borderWidth: 0,
                    borderRadius: 0
                }]
            },
            options: {
                cutout: '75%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // 2. Line Chart
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'],
                datasets: [{
                    data: [40, 120, 80, 140, 200],
                    borderColor: '#1d4ed8',
                    backgroundColor: 'rgba(29, 78, 216, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#1d4ed8',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5]
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
