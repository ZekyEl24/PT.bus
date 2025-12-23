<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Kontak</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #2A3546 transparent;
        }

        .custom-scrollbar::-webkit-scrollbar {
            height: 3px;
            width: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #2A3546;
            border-radius: 999px;
            background-clip: content-box;
        }
    </style>
</head>

<body class="bg-[#f8fafc] font-habanera">
    @extends('layout.admin')

    @section('content')
        <div class="h-full">
            {{-- FORM DENGAN ALPINE.JS --}}
            <form action="{{ route('infokontak.update', $kontak->id ?? 1) }}" method="POST" x-data="{
                {{-- Data Asli dari Database --}}
                origWhatsapp: '{{ $kontak->nomer_telepon ?? '' }}',
                    origEmail: '{{ $kontak->email ?? '' }}',
                    origAlamat: '{{ $kontak->alamat ?? '' }}',

                    {{-- Set default ke +62 jika kosong --}}
                whatsapp: '{{ old('nomer_telepon', $kontak->nomer_telepon ?? '+62') }}',
                    email: '{{ old('email', $kontak->email ?? '') }}',
                    alamat: '{{ old('alamat', $kontak->alamat ?? '') }}',

                    init() {
                        {{-- Logika agar input selalu diawali +62 --}}
                        this.$watch('whatsapp', value => {
                            if (!value.startsWith('+62')) {
                                {{-- Jika user mencoba menghapus +62, paksa balik ke +62 --}}
                                let digits = value.replace(/\D/g, '');
                                {{-- Jika user ngetik angka 0 di depan, ubah ke 62 --}}
                                if (digits.startsWith('0')) digits = '62' + digits.substring(1);
                                {{-- Jika gapunya 62 sama sekali, tambahin --}}
                                if (!digits.startsWith('62')) digits = '62' + digits;

                                this.whatsapp = '+' + digits;
                            }
                        });
                        {{-- Listener untuk Reset --}}
                        window.addEventListener('reset-kontak', () => {
                            this.whatsapp = '';
                            this.email = '';
                            this.alamat = '';
                        });
                    },

                    {{-- FUNGSI CEK PERUBAHAN --}}
                get hasChanges() {
                    return (this.whatsapp !== this.origWhatsapp) ||
                        (this.email !== this.origEmail) ||
                        (this.alamat !== this.origAlamat);
                }
            }">
                @csrf
                @method('PUT')

                <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 min-h-[80vh] relative flex flex-col">

                    {{-- Judul Halaman & Tombol Reset --}}
                    <div class="flex justify-end items-center mb-8">
                        <button type="button" onclick="openResetConfirmation()"
                            class="bg-kuning text-black text-xs font-bold px-8 py-2 rounded-[13px] hover:bg-kuningterang transition flex items-center gap-2 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 16c1.671 0 3-1.331 3-3s-1.329-3-3-3s-3 1.331-3 3s1.329 3 3 3" />
                                <path fill="currentColor"
                                    d="M20.817 11.186a8.9 8.9 0 0 0-1.355-3.219a9 9 0 0 0-2.43-2.43a9 9 0 0 0-3.219-1.355a9 9 0 0 0-1.838-.18V2L8 5l3.975 3V6.002c.484-.002.968.044 1.435.14a7 7 0 0 1 2.502 1.053a7 7 0 0 1 1.892 1.892A6.97 6.97 0 0 1 19 13a7 7 0 0 1-.55 2.725a7 7 0 0 1-.644 1.188a7 7 0 0 1-.858 1.039a7.03 7.03 0 0 1-3.536 1.907a7.1 7.1 0 0 1-2.822 0a7 7 0 0 1-2.503-1.054a7 7 0 0 1-1.89-1.89A7 7 0 0 1 5 13H3a9 9 0 0 0 1.539 5.034a9.1 9.1 0 0 0 2.428 2.428A8.95 8.95 0 0 0 12 22a9 9 0 0 0 1.814-.183a9 9 0 0 0 3.218-1.355a9 9 0 0 0 1.331-1.099a9 9 0 0 0 1.1-1.332A8.95 8.95 0 0 0 21 13a9 9 0 0 0-.183-1.814" />
                            </svg> Reset
                        </button>
                    </div>

                    <div class="space-y-10 flex-1">
                        {{-- BARIS 1: Whatsapp & Email --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            {{-- Whatsapp --}}
                            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                                <label class="text-base font-bold text-gray-800 block mb-4 font-montserrat tracking-wider">
                                    Nomor Whatsapp
                                </label>
                                <div class="relative flex items-center mb-2">
                                    <div class="absolute left-4 text-gray-500">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>

                                    <input type="text" name="nomer_telepon" x-model="whatsapp"
                                        class="w-full border-2 border-dashed border-gray-300 focus:border-birue rounded-xl pl-12 pr-32 py-4 outline-none text-sm transition duration-150 font-bold"
                                        placeholder="+628xxx">
                                </div>

                                {{-- Link Otomatis (Tanda + Hilang di Link) --}}
                                <div x-show="whatsapp.length > 3" class="flex items-center gap-2 px-2">
                                    <span class="text-[10px] text-gray-400">Link Aktif:</span>
                                    <a :href="'https://wa.me/' + whatsapp.replace(/\D/g, '')" target="_blank"
                                        class="text-[10px] text-birue font-bold hover:underline italic">
                                        https://wa.me/<span x-text="whatsapp.replace(/\D/g,'')"></span>
                                    </a>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                                <label
                                    class="text-base font-bold text-gray-800 block mb-4 font-montserrat tracking-wider">Email</label>
                                <div class="relative flex items-center">
                                    <div class="absolute left-4 text-gray-500">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <input type="email" name="email" x-model="email"
                                        class="w-full border-2 border-dashed border-gray-300 focus:border-birue rounded-xl px-12 py-4 outline-none text-sm transition duration-150"
                                        placeholder="ptbus_admin@gmail.com">
                                </div>
                            </div>
                        </div>

                        {{-- BARIS 2: Alamat --}}
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                            <label
                                class="text-base font-bold text-gray-800 block mb-4 font-montserrat tracking-wider">Alamat</label>
                            <div class="relative flex items-start">
                                <div class="absolute left-4 top-5 text-gray-500">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <textarea name="alamat" rows="4" x-model="alamat"
                                    class="w-full border-2 border-dashed border-gray-300 focus:border-birue rounded-xl px-12 py-4 outline-none text-sm resize-none transition duration-150 custom-scrollbar"
                                    placeholder="Masukkan alamat lengkap..."></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="mt-12 flex justify-between items-center">
                        {{-- Tombol Batal --}}
                        <button type="button"
                            @click="hasChanges ? openCancelConfirmation('Info Kontak') : window.location.href='{{ route('infokontak.index') }}'"
                            :disabled="!hasChanges"
                            class="text-xs font-bold py-3 px-12 rounded-[13px] transition border text-center"
                            :class="hasChanges ? 'bg-white border-birua text-birua hover:bg-gray-50' :
                                'bg-gray-100 border-gray-300 text-gray-400 cursor-not-allowed'">
                            Batal
                        </button>

                        {{-- Tombol Simpan --}}
                        <button type="submit" :disabled="!hasChanges"
                            class="text-xs font-bold py-3 px-12 rounded-[13px] transition"
                            :class="hasChanges ? 'bg-birua text-white hover:opacity-90' :
                                'bg-gray-400 text-white cursor-not-allowed'">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endsection

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @include('layout.partials.reset_confirmation_modal')
    @include('layout.partials.edit_confirmation')

    <script>
        // Fungsi Modal BATAL
        function openCancelConfirmation(context) {
            const modal = document.getElementById('editConfirmation');
            const content = document.getElementById('editConfirmationContent');
            const confirmBtn = document.getElementById('confirmEditButton');
            const contextText = document.getElementById('discardContextText');

            if (!modal || !content) return;
            if (contextText) contextText.innerText = context;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);

            confirmBtn.onclick = function() {
                window.location.href = "{{ route('infokontak.index') }}";
            }
        }

        // Fungsi Modal RESET
        function openResetConfirmation() {
            const modal = document.getElementById('resetConfirmationModal');
            const content = document.getElementById('resetConfirmationModalContent');
            const confirmButton = document.getElementById('confirmResetButton');

            if (!modal || !content || !confirmButton) return;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);

            const newConfirm = confirmButton.cloneNode(true);
            confirmButton.replaceWith(newConfirm);
            newConfirm.onclick = function() {
                window.dispatchEvent(new Event('reset-kontak'));
                closeModal('resetConfirmationModal');
            };
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            const content = document.getElementById(id + 'Content') || document.getElementById(id + 'ModalContent');
            if (!modal || !content) return;
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }
    </script>
</body>

</html>
