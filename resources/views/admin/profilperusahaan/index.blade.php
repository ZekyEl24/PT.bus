<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Perusahaan</title>
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

        .custom-scrollbar::-webkit-scrollbar-button {
            display: none;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #2A3546;
            border-radius: 999px;
            border: 1px solid transparent;
            background-clip: content-box;
        }
    </style>
</head>

<body class="bg-[#f8fafc] font-habanera">
    @extends('layout.admin')

    @section('content')
        <div class="h-full">
            {{-- FORM DENGAN ALPINE.JS TERPUSAT --}}
            <form action="{{ route('profilperusahaan.update', $profil->id ?? 1) }}" method="POST"
                enctype="multipart/form-data" x-data="{
                    {{-- Data Asli dari Database --}}
                    origNama: '{{ $profil->nama_profil ?? '' }}',
                        origDeskripsi: '{{ $profil->deskripsi_profil ?? '' }}',
                        origVisi: '{{ $profil->visi ?? '' }}',
                        origMisi: {{ json_encode($profil->misi->map(fn($m) => ['id' => $m->id, 'text' => $m->misi])->values()) }},

                        {{-- Data Input Saat Ini --}}
                    nama: '{{ old('nama_profil', $profil->nama_profil ?? '') }}',
                        deskripsi: '{{ old('deskripsi_profil', $profil->deskripsi_profil ?? '') }}',
                        visi: '{{ old('visi', $profil->visi ?? '') }}',
                        misiList: [],

                        {{-- Logo State --}}
                    logoPreview: '{{ $profil->logo ? asset('storage/' . str_replace('public/', '', $profil->logo)) : asset('assets/default-logo.png') }}',
                        fileName: '{{ $profil->logo ? 'Ganti Logo' : 'Unggah Foto/Logo' }}',
                        isLogoChanged: false,

                        init() {
                            {{-- Copy data asli ke list misi --}}
                            this.misiList = JSON.parse(JSON.stringify(this.origMisi));

                            {{-- Listener untuk Reset --}}
                            window.addEventListener('reset-profil', () => {
                                this.nama = '';
                                this.deskripsi = '';
                                this.visi = '';
                                this.misiList = [];
                                this.isLogoChanged = true;
                                this.logoPreview = '{{ asset('assets/default-logo.png') }}';
                            });
                        },

                        addMisi() { this.misiList.push({ id: null, text: '' }); },
                        removeMisi(index) { this.misiList.splice(index, 1); },

                        {{-- FUNGSI CEK PERUBAHAN --}}
                    get hasChanges() {
                        let isMisiChanged = JSON.stringify(this.misiList) !== JSON.stringify(this.origMisi);
                        return (this.nama !== this.origNama) ||
                            (this.deskripsi !== this.origDeskripsi) ||
                            (this.visi !== this.origVisi) ||
                            this.isLogoChanged ||
                            isMisiChanged;
                    }
                }">
                @csrf
                @method('PUT')

                <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 min-h-[80vh] relative flex flex-col">
                    <div class="flex justify-end mb-1">
                        <button type="button" onclick="openResetConfirmation()"
                            class="bg-kuning text-black text-xs font-bold px-8 py-2 rounded-[13px] hover:bg-kuningterang transition flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 16c1.671 0 3-1.331 3-3s-1.329-3-3-3s-3 1.331-3 3s1.329 3 3 3" />
                                <path fill="currentColor"
                                    d="M20.817 11.186a8.9 8.9 0 0 0-1.355-3.219a9 9 0 0 0-2.43-2.43a9 9 0 0 0-3.219-1.355a9 9 0 0 0-1.838-.18V2L8 5l3.975 3V6.002c.484-.002.968.044 1.435.14a7 7 0 0 1 2.502 1.053a7 7 0 0 1 1.892 1.892A6.97 6.97 0 0 1 19 13a7 7 0 0 1-.55 2.725a7 7 0 0 1-.644 1.188a7 7 0 0 1-.858 1.039a7.03 7.03 0 0 1-3.536 1.907a7.1 7.1 0 0 1-2.822 0a7 7 0 0 1-2.503-1.054a7 7 0 0 1-1.89-1.89A7 7 0 0 1 5 13H3a9 9 0 0 0 1.539 5.034a9.1 9.1 0 0 0 2.428 2.428A8.95 8.95 0 0 0 12 22a9 9 0 0 0 1.814-.183a9 9 0 0 0 3.218-1.355a9 9 0 0 0 1.331-1.099a9 9 0 0 0 1.1-1.332A8.95 8.95 0 0 0 21 13a9 9 0 0 0-.183-1.814" />
                            </svg> Reset
                        </button>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-2 gap-10 flex-1">
                        {{-- KIRI --}}
                        <div class="md:col-span-1 space-y-4">
                            <div class="font-montserrat">
                                <label class="text-base font-semibold text-gray-800 block mb-1">Nama Perusahaan</label>
                                <input type="text" name="nama_profil" x-model="nama"
                                    class="w-[90%] border border-dashed border-gray-400 focus:border-birue rounded-lg p-5 outline-none py-2 text-sm bg-transparent transition duration-150"
                                    placeholder="Masukkan nama perusahaan">
                            </div>

                            <div class="font-montserrat">
                                <label class="text-base font-semibold text-gray-800 block mb-1">Deskripsi</label>
                                <textarea name="deskripsi_profil" rows="4" x-model="deskripsi"
                                    class="w-[90%] border border-dashed border-gray-300 rounded-lg p-5 text-xs focus:border-birue outline-none resize-none transition duration-150 custom-scrollbar"
                                    placeholder="Tuliskan deskripsi singkat perusahaan..."></textarea>
                            </div>

                            <div class="font-montserrat">
                                <label class="text-base font-semibold text-gray-800 block mb-1">Visi</label>
                                <textarea name="visi" rows="3" x-model="visi"
                                    class="w-[90%] border border-dashed border-gray-300 rounded-lg p-5 text-xs focus:border-birue outline-none resize-none transition duration-150 custom-scrollbar"
                                    placeholder="Tuliskan visi perusahaan..."></textarea>
                            </div>
                        </div>

                        {{-- KANAN: Logo --}}
                        <div class="md:col-span-1 space-y-4">
                            <label class="text-lg font-semibold text-gray-800 font-montserrat">Logo</label>
                            <p class="text-xs text-gray-500 mb-4 font-montserrat">Logo yang Anda gunakan saat ini:</p>

                            <div
                                class="border-2 border-dashed border-gray-400/70 rounded-xl p-4 flex items-center justify-center w-full h-55 relative overflow-hidden">
                                <img :src="logoPreview" class="max-w-[70%] max-h-[70%] object-contain">
                            </div>

                            <label class="block cursor-pointer">
                                <input type="file" name="logo" id="logo" class="hidden"
                                    @change="
                                        const file = $event.target.files[0];
                                        if (file) {
                                            logoPreview = URL.createObjectURL(file);
                                            fileName = 'Ganti Logo';
                                            isLogoChanged = true;
                                        }
                                    ">
                                <div
                                    class="bg-birue text-white font-semibold py-3 px-4 rounded-[13px] text-xs text-center shadow-md transition duration-150">
                                    <span x-text="fileName"></span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- MISI SECTION --}}
                    <div class="mt-2 pt-6">
                        <label class="text-base font-semibold text-gray-800 block mb-2 font-montserrat">Misi</label>
                        <div class="relative">
                            <div
                                class="flex overflow-x-auto overflow-y-hidden max-w-full pt-3 pl-3 pb-6 space-x-6 custom-scrollbar">
                                <template x-for="(misi, index) in misiList" :key="index">
                                    <div
                                        class="flex-shrink-0 w-[220px] h-[210px] p-5 rounded-lg bg-[#FAFAFA] relative border border-dashed border-gray-300 transition-all duration-200 focus-within:border-birue">
                                        <div class="w-8 h-8 rounded-full bg-birue text-white flex items-center justify-center text-xs font-semibold absolute top-[-10px] left-[-10px] shadow-md"
                                            x-text="index + 1"></div>
                                        <input type="hidden" :name="'misi_id_' + index" :value="misi.id">
                                        <textarea :name="'misi_list[' + index + ']'" rows="7" x-model="misi.text"
                                            class="w-full h-full font-habanera font-light text-xs text-black resize-none bg-transparent border-none outline-none focus:ring-0"
                                            placeholder="Tuliskan poin misi..."></textarea>
                                        <button type="button" @click="removeMisi(index)"
                                            class="absolute bottom-2 right-2 w-8 h-8 rounded-full bg-yellow-400 text-black flex items-center justify-center hover:bg-kuning transition shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6zM8 9h8v10H8zm7.5-5l-1-1h-5l-1 1H5v2h14V4z" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>

                                <div @click="addMisi()"
                                    class="flex-shrink-0 w-[180px] h-[210px] p-4 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-100 transition">
                                    <i class="fa-solid fa-plus text-gray-400 text-2xl"></i>
                                    <span class="text-sm text-gray-500 mt-2">Tambah Misi</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="mt-10 flex justify-between items-center">
                        {{-- Tombol Batal --}}
                        <button type="button" @click="openCancelConfirmation('Profil Perusahaan')" :disabled="!hasChanges"
                            class="text-xs font-bold py-3 px-12 rounded-[13px] transition border text-center"
                            :class="hasChanges ? 'bg-white border-birua text-birua hover:bg-gray-100' :
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

    {{-- modal edit --}}
    @include('layout.partials.edit_confirmation')

    <script>
        // Fungsi Modal BATAL
        function openCancelConfirmation(context) {
            const modal = document.getElementById('editConfirmation');
            const content = document.getElementById('editConfirmationContent'); // Perbaikan typo ID
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
                window.location.href = "{{ route('profilperusahaan.index') }}";
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
                window.dispatchEvent(new Event('reset-profil'));
                closeModal('resetConfirmationModal');
            };
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            const content = document.getElementById(id + 'Content');
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
