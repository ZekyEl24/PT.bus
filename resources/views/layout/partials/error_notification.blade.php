@if (session('error_type') || $errors->any())
    @php
        $type = session('error_type');

        $messages = [
            'gagal' => 'Terjadi Kesalahan, Silahkan Coba Lagi!',
            'akses' => 'Anda Tidak Memiliki Akses!',
            'validasi' => 'Data yang Dimasukkan Tidak Valid!',
            'hapus' => 'Data Gagal Dihapus!',
        ];

        // Jika ada error dari validator Laravel ($errors), set type ke 'validasi'
        if ($errors->any()) {
            $type = 'validasi';
        }
    @endphp

    <div id="errorPopup" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md px-10 py-8 text-center animate-scale-in">
            {{-- Close --}}
            <button onclick="closeErrorPopup()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                ✕
            </button>

            {{-- ICON --}}
            <div class="flex justify-center mb-5">
                <div class="w-20 h-20 rounded-full flex items-center justify-center bg-red-500 shadow-lg shadow-red-200">
                    {{-- SVG X / WARNING --}}
                    @if ($type === 'akses')
                        {{-- Icon Gembok/Akses --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    @else
                        {{-- Icon X --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    @endif
                </div>
            </div>

            {{-- TEXT --}}
            <h2 class="text-lg font-bold text-gray-800">
                {{ $messages[$type] ?? 'Opps! Terjadi Kesalahan' }}
            </h2>

            {{-- Detail Error (Optional: Jika ingin menampilkan list error validasi) --}}
            @if($errors->any())
                <p class="text-xs text-red-500 mt-2 line-clamp-2">
                    {{ $errors->first() }}
                </p>
            @endif
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        function closeErrorPopup() {
            const popup = document.getElementById('errorPopup');
            if (popup) {
                popup.style.opacity = '0';
                popup.style.transition = 'opacity 0.2s ease';
                setTimeout(() => popup.remove(), 200);
            }
        }

        // Error popup biasanya dibiarkan sedikit lebih lama atau tidak otomatis tertutup
        // agar user bisa membaca kesalahannya. Tapi jika ingin otomatis (misal 4 detik):
        setTimeout(() => {
            closeErrorPopup();
        }, 4000);
    </script>
@endif
