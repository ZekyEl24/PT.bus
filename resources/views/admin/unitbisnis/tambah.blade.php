<style>
    .field-error {
        border: 2px solid #ef4444 !important;
    }
</style>


<div id="modalTambahUB" class="fixed inset-0 hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4 z-40">

    <div id="modalContentTambahUB"
        class="bg-white rounded-[15px] shadow-2xl w-full max-w-[850px] transform transition-all scale-95 opacity-0 duration-300 max-h-[95vh] overflow-y-auto scrollbar-hide">

        {{-- Judul Modal --}}
        <div class="py-6 border-b border-gray-100 text-center sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">Tambah Unit Bisnis</h3>
            <button type="button" onclick="closeModal('modalTambahUB', 'formTambahUB')"
                class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        {{-- Form Body --}}
        <form id="formTambahUB" action="{{ route('ub.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">
                {{-- Sisi Kiri: Nama & Deskripsi --}}
                <div class="space-y-6">
                    <div>
                        <label class="flex justify-between items-center text-xs font-bold text-gray-700 mb-2">
                            <span>Nama Unit Bisnis</span>
                        </label>
                        <input type="text" name="nama_ub" placeholder="Masukkan Nama Unit Bisnis" required
                            class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi_ub" rows="6" placeholder="Masukkan deskripsi Unit Bisnis" required
                            class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400 resize-none"></textarea>
                    </div>
                </div>

                {{-- Sisi Kanan: Upload Logo --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Logo Unit Bisnis <span
                            class="text-[10px] text-gray-400 font-light italic">(Gunakan Gambar tanpa latar
                            belakang)</span></label>
                    <div class="relative group">
                        <label for="inputLogoTambah" class="cursor-pointer">
                            <div id="previewContainerLogo"
                                class="w-full h-[180px] border-2 border-dashed border-gray-400/70 rounded-xl flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden">
                                <div id="placeholderLogo" class="flex flex-col items-center">
                                    <i class="fa-solid fa-image-user text-4xl text-gray-300 font-light"></i>
                                    <span class="text-[20px] text-gray-300 mt-2"><i
                                            class="fa-solid fa-image-plus"></i></span>
                                </div>
                                <img id="previewLogo" src="#" alt="Preview Logo"
                                    class="hidden max-w-[90%] max-h-[90%] object-contain">
                            </div>
                        </label>
                        <input type="file" id="inputLogoTambah" name="logo_ub" accept="image/*" class="hidden"
                            required onchange="previewFileUB('Logo')">
                    </div>
                    <button type="button" onclick="document.getElementById('inputLogoTambah').click()"
                        class="w-full mt-4 py-3 bg-[#2D3E50] text-white text-xs font-bold rounded-lg hover:opacity-90 transition">
                        Unggah Foto/Logo
                    </button>
                </div>

                {{-- Baris Tengah: Foto Utama (Full Width dalam grid) --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-2">Foto Unit Bisnis </label>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div id="previewContainerFoto"
                            class="flex-1 h-40 border-2 border-dashed border-gray-400/70 rounded-xl flex items-center justify-center bg-gray-50 overflow-hidden">
                            <div id="placeholderFoto" class="text-gray-300 text-4xl"><i
                                    class="fa-solid fa-image-plus"></i></div>
                            <img id="previewFoto" src="#" alt="Preview Foto"
                                class="hidden max-w-[95%] max-h-[95%] object-contain">
                        </div>
                        <label for="inputFotoTambah" class="cursor-pointer">
                            <div
                                class="w-full md:w-48 h-40 bg-[#2D3E50] rounded-xl flex flex-col items-center justify-center text-white gap-3 hover:opacity-90 transition">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl"></i>
                                <span class="text-xs font-bold">Unggah Foto</span>
                            </div>
                        </label>
                        <input type="file" id="inputFotoTambah" name="gambar_ub" accept="image/*" class="hidden"
                            required onchange="previewFileUB('Foto')">
                    </div>
                </div>

                {{-- Link Website & Medsos --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Link Website </label>
                    <input type="url" name="link_web_ub" placeholder="Contoh: https://website.com" required
                        class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Link Media Sosial</label>
                    <input type="url" name="link_ig_ub" placeholder="Contoh: https://instagram.com/user" required
                        class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition">
                </div>

                {{-- Layanan --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-2">Layanan</label>

                    {{-- Container tempat baris input baru akan muncul --}}
                    <div id="layananContainerTambah" class="space-y-3">
                        {{-- Baris Pertama (Default) --}}
                        <div class="flex items-center gap-2">
                            <input type="text" name="layanan[]" placeholder="Contoh: Pembuatan Website" required
                                class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition">
                            {{-- Tombol hapus disembunyikan untuk input pertama agar minimal ada 1 layanan --}}
                            <div class="w-9"></div>
                        </div>
                    </div>

                    {{-- Tombol Tambah Baris Baru --}}
                    <button type="button" onclick="addLayananFieldTambah()"
                        class="mt-3 flex items-center gap-2 text-xs font-bold text-birua hover:text-biruc transition">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Layanan Baru
                    </button>
                </div>


                {{-- Status (Radio) --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-3">Status</label>
                    <div class="flex items-center gap-8">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="status" value="aktif"
                                class="w-5 h-5 accent-birugelapxl cursor-pointer" required
                                {{ old('status') == 'aktif' || !old('status') ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-gray-700">Aktif</span>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="status" value="tidak aktif"
                                class="w-5 h-5 accent-birugelapxl cursor-pointer" required
                                {{ old('status') == 'tidak aktif' ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-gray-700">Tidak Aktif</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-between items-center pt-10 mt-4">
                <button type="button" onclick="closeModal('modalTambahUB', 'formTambahUB')"
                    class="px-12 py-3 border border-birua text-birua rounded-xl text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-12 py-3 bg-birua text-white rounded-xl text-xs font-bold hover:opacity-90 transition shadow-lg shadow-birua/20">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>



<script>
    // Fungsi Preview File yang sudah ada
    function previewFileUB(type) {
        const input = document.getElementById(`input${type}Tambah`);
        const preview = document.getElementById(`preview${type}`);
        const placeholder = document.getElementById(`placeholder${type}`);

        // Logika sembunyikan badge wajib untuk file
        const container = input.closest('div');
        const badge = container.querySelector('.badge-wajib');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');

                // Sembunyikan badge jika file dipilih
                if (badge) badge.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            // Tampilkan badge jika batal pilih file
            if (badge) badge.classList.remove('hidden');
        }
    }

    // --- FUNGSI BARU UNTUK LAYANAN ---
    function addLayananFieldTambah() {
        const container = document.getElementById('layananContainerTambah');
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2 mt-2';
        div.innerHTML = `
            <input type="text" name="layanan[]" placeholder="Contoh: Pembuatan Website" required
                class="w-full px-4 py-3 text-xs border border-dashed border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition">
            <button type="button" onclick="this.parentElement.remove()"
                class="bg-birub text-white w-9 h-9 rounded-lg flex items-center justify-center hover:bg-birue transition flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6zM8 9h8v10H8zm7.5-5l-1-1h-5l-1 1H5v2h14V4z" />
                                    </svg>
            </button>
        `;
        container.appendChild(div);
    }

    function addLayananUB() {
        const input = document.getElementById('layanan_input');
        const container = document.getElementById('layananContainerUB');
        const hiddenContainer = document.getElementById('hiddenLayananInputs');
        const value = input.value.trim();

        if (value === "") return;

        // Buat ID unik berdasarkan waktu
        const uniqueId = 'ub_' + Date.now();

        // 1. Buat Card Visual (mirip contoh gambar)
        const card = document.createElement('div');
        card.id = `card_${uniqueId}`;
        card.className =
            "flex items-center gap-3 px-4 py-2 border border-slate-600 rounded-full bg-white shadow-sm transition hover:border-birua";
        card.innerHTML = `
                <span class="text-[11px] font-medium text-slate-700">${value}</span>
                <button type="button" onclick="removeLayananUB('${uniqueId}')" class="text-slate-400 hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6zM8 9h8v10H8zm7.5-5l-1-1h-5l-1 1H5v2h14V4z" />
                                                    </svg>
                </button>
            `;

        // 2. Buat Hidden Input untuk Form Submit
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'layanan[]'; // Array untuk controller
        hiddenInput.value = value;
        hiddenInput.id = `input_${uniqueId}`;

        // 3. Masukkan ke DOM
        container.appendChild(card);
        hiddenContainer.appendChild(hiddenInput);

        // 4. Reset Input
        input.value = "";
        input.focus();
    }

    function removeLayananUB(id) {
        document.getElementById(`card_${id}`).remove();
        document.getElementById(`input_${id}`).remove();
    }

    // Support tekan "Enter" untuk menambah layanan
    document.getElementById('layanan_input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addLayananUB();
        }
    });

    document.getElementById('formTambahUB').addEventListener('submit', function(e) {

        // ⛔ STOP SUBMIT DULU
        e.preventDefault();

        let valid = true;

        // bersihkan error lama
        document.querySelectorAll('.field-error').forEach(el => {
            el.classList.remove('field-error');
        });

        // ================= TEXT & TEXTAREA =================
        this.querySelectorAll('input[required]:not([type="file"]):not([type="radio"]), textarea[required]')
            .forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('field-error');
                    valid = false;
                }
            });

        // ================= FILE =================
        const logo = document.getElementById('inputLogoTambah');
        if (!logo.files.length) {
            document.getElementById('previewContainerLogo').classList.add('field-error');
            valid = false;
        }

        const foto = document.getElementById('inputFotoTambah');
        if (!foto.files.length) {
            document.getElementById('previewContainerFoto').classList.add('field-error');
            valid = false;
        }

        // ================= RADIO =================
        const statusChecked = this.querySelector('input[name="status"]:checked');
        if (!statusChecked) {
            this.querySelectorAll('input[name="status"]').forEach(r => {
                r.classList.add('field-error');
            });
            valid = false;
        }

        // ================= FINAL =================
        if (!valid) {
            alert('Masih ada data wajib yang belum diisi!');
            return;
        }

        // ✅ BARU SUBMIT MANUAL
        this.submit();
    });
</script>
