<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Banner</title>
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
            <form action="{{ route('hubungi.update', $hubungi->id ?? 1) }}" method="POST" enctype="multipart/form-data"
                x-data="{
                    {{-- Data Asli dari Database --}}
                    origJudul: '{{ $hubungi->judul ?? '' }}',
                        origDeskripsi: '{{ $hubungi->deskripsi ?? '' }}',

                        {{-- Data Input Saat Ini --}}
                    judul: '{{ old('judul', $hubungi->judul ?? '') }}',
                        deskripsi: '{{ old('deskripsi', $hubungi->deskripsi ?? '') }}',

                        {{-- Foto State --}}
                    fotoPreview: '{{ $hubungi->foto ? asset('storage/' . $hubungi->foto) : asset('assets/default-logo.png') }}',
                        isFotoChanged: false,

                        init() {
                            window.addEventListener('reset-hubungi', () => {
                                this.judul = '';
                                this.deskripsi = '';
                                this.isFotoChanged = true;
                                this.fotoPreview = '{{ asset('assets/default-logo.png') }}';
                            });
                        },

                        {{-- CEK PERUBAHAN --}}
                    get hasChanges() {
                        return (this.judul !== this.origJudul) ||
                            (this.deskripsi !== this.origDeskripsi) ||
                            this.isFotoChanged;
                    }
                }">
                @csrf
                @method('PUT')

                <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 min-h-[80vh] relative flex flex-col">

                    {{-- Tombol Reset --}}
                    <div class="flex justify-end">
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 flex-1">

                        {{-- SISI KIRI: Teks --}}
                        <div class="space-y-8">
                            <div>
                                <label
                                    class="text-base font-bold text-gray-800 block mb-3 font-montserrat tracking-wider">Judul</label>
                                {{-- Menambahkan resize-none agar ukuran tetap --}}
                                <textarea name="judul" rows="3" x-model="judul"
                                    class="w-full border-2 border-dashed border-gray-300 focus:border-birue rounded-xl p-5 outline-none text-sm transition duration-150 custom-scrollbar resize-none"
                                    placeholder="Masukkan judul..."></textarea>
                            </div>

                            <div>
                                <label
                                    class="text-base font-bold text-gray-800 block mb-3 font-montserrat tracking-wider">Deskripsi</label>
                                {{-- Menambahkan resize-none agar ukuran tetap --}}
                                <textarea name="deskripsi" rows="8" x-model="deskripsi"
                                    class="w-full border-2 border-dashed border-gray-300 focus:border-birue rounded-xl p-5 outline-none text-sm transition duration-150 custom-scrollbar resize-none"
                                    placeholder="Masukkan deskripsi lengkap..."></textarea>
                            </div>
                        </div>

                        {{-- SISI KANAN: Foto --}}
                        <div class="flex flex-col items-center">
                            <div class="w-full max-w-md">
                                <label class="text-lg font-bold text-gray-800 block mb-1 font-montserrat">Foto
                                    Hubungi</label>
                                <p class="text-[11px] text-gray-400 mb-4 font-montserrat">Foto yang Anda gunakan saat ini;
                                </p>

                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-2xl p-6 flex items-center justify-center bg-white w-full h-73 overflow-hidden mb-6 ">
                                    <img :src="fotoPreview" class="max-w-[90%] max-h-[90%] object-contain rounded-lg">
                                </div>

                                <label class="block cursor-pointer">
                                    <input type="file" name="foto" class="hidden"
                                        @change="
                                        const file = $event.target.files[0];
                                        if (file) {
                                            fotoPreview = URL.createObjectURL(file);
                                            isFotoChanged = true;
                                        }
                                    ">
                                    <div
                                        class="bg-birue text-white font-bold py-3 px-6 rounded-xl text-xs text-center shadow-lg hover:bg-opacity-90 transition duration-150 tracking-widest">
                                        Unggah Foto/Logo
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="mt-12 flex justify-between items-center pt-6 border-t border-gray-50">
                        <button type="button"
                            @click="hasChanges ? openCancelConfirmation('Halaman Hubungi') : window.location.href='{{ route('hubungi.index') }}'"
                            :disabled="!hasChanges"
                            class="text-xs font-bold py-3 px-12 rounded-[13px] transition border text-center"
                            :class="hasChanges ? 'bg-white border-birua text-birua hover:bg-gray-50' :
                                'bg-gray-100 border-gray-300 text-gray-400 cursor-not-allowed'">
                            Batal
                        </button>

                        <button type="submit" :disabled="!hasChanges"
                            class="text-xs font-bold py-3 px-12 rounded-[13px] transition shadow-md"
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
        // Modal logic (Open/Close) tetap sama seperti profil perusahaan agar konsisten
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
                window.location.href = "{{ route('hubungi.index') }}";
            }
        }

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
                window.dispatchEvent(new Event('reset-hubungi'));
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
