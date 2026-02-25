{{-- ========================================== --}}
{{-- MODAL TAMBAH PENGGUNA (POP-UP) --}}
{{-- ========================================== --}}
<div id="modalTambah" class="fixed inset-0 hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4 z-40">
    <div id="modalContentTambah"
        class="bg-white rounded-[15px] shadow-2xl w-full max-w-[600px] transform transition-all scale-95 opacity-0 duration-300 max-h-full overflow-y-auto">

        {{-- Judul Modal --}}
        <div class="py-6 border-b border-gray-100 text-center sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">Tambah Pengguna</h3>
        </div>

        {{-- Form Body --}}
        <form id="formTambahPengguna" action="{{ route('user.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            {{-- Input Username --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Username</label>
                <input type="text" name="username" placeholder="Masukkan Username" required
                    value="{{ old('username') }}"
                    class="w-full px-4 py-3 text-xs border border-dashed rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400
                                @error('username', 'tambah') border-red-500 @else border-gray-400 @enderror">
                @error('username', 'tambah')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Email --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" placeholder="Masukkan Email" required value="{{ old('email') }}"
                    class="w-full px-4 py-3 text-xs border border-dashed rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400
                                @error('email', 'tambah') border-red-500 @else border-gray-400 @enderror">
                @error('email', 'tambah')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Sandi --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Sandi</label>
                <div class="relative">
                    <input type="password" id="inputSandiTambah" name="password" placeholder="Masukkan Sandi" required
                        class="w-full px-4 py-3 text-xs border border-dashed rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400
                                    @error('password', 'tambah') border-red-500 @else border-gray-400 @enderror">
                    <button type="button" onclick="toggleSandi('inputSandiTambah', 'iconSandiTambah')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <i id="iconSandiTambah" class="fa-solid fa-eye-slash text-xs"></i>
                    </button>
                </div>
                @error('password', 'tambah')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>


            {{-- Input Role (Radio) --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-3">Role</label>
                <div class="flex items-center gap-8">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="role" value="admin" class="w-5 h-5 accent-birugelapxl" required
                            {{ old('role') == 'admin' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-700">Admin</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="role" value="editor ub" class="w-5 h-5 accent-birugelapxl"
                            required {{ old('role') == 'editor ub' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-700">Editor UB</span>
                    </label>
                </div>
                @error('role', 'tambah')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Status (Radio) --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-3">Status</label>
                <div class="flex items-center gap-8">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="status_pengguna" value="aktif" class="w-5 h-5 accent-birugelapxl"
                            required {{ old('status_pengguna') == 'aktif' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-700">Aktif</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="status_pengguna" value="tidak aktif"
                            class="w-5 h-5 accent-birugelapxl" required
                            {{ old('status_pengguna') == 'tidak aktif' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-700">Tidak Aktif</span>
                    </label>
                </div>
                @error('status_pengguna', 'tambah')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-between items-center pt-10 mt-4">
                <button type="button" onclick="closeModal('modalTambah', 'formTambahPengguna')"
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
