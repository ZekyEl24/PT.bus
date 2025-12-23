@if (session('success_type'))
    @php
        $type = session('success_type');

        $messages = [
            'buat' => 'Data Berhasil Dibuat!',
            'simpan' => 'Data Berhasil Diperbarui!',
            'hapus' => 'Data Berhasil Dihapus!',
        ];
    @endphp

    <div id="successPopup" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md px-10 py-8 text-center animate-scale-in">
            {{-- Close --}}
            <button onclick="closeSuccessPopup()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                ✕
            </button>

            {{-- ICON --}}
            <div class="flex justify-center mb-5">
                <div class="w-20 h-20 rounded-full flex items-center justify-center
                    bg-green-500">
                    {{-- CHECK --}}
                    @if ($type === 'buat')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    @elseif ($type === 'simpan')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M17 3H3v18h18V7zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3s3 1.34 3 3s-1.34 3-3 3m3-10H5V5h10z" />
                        </svg>
                    @else
                        {{-- TRASH --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M15 16h4v2h-4zm0-8h7v2h-7zm0 4h6v2h-6zM3 18c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2V8H3zM14 5h-3l-1-1H6L5 5H2v2h12z" />
                        </svg>
                    @endif
                </div>
            </div>

            {{-- TEXT --}}
            <h2 class="text-lg font-bold text-gray-800">
                {{ $messages[$type] ?? 'Berhasil!' }}
            </h2>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        function closeSuccessPopup() {
            document.getElementById('successPopup')?.remove();
        }

        setTimeout(() => {
            closeSuccessPopup();
        }, 2500);
    </script>

    {{-- ANIMATION --}}
    <style>
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-scale-in {
            animation: scaleIn 0.25s ease-out forwards;
        }
    </style>
@endif
