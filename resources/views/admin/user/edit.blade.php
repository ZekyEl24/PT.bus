<div class="bg-white rounded-2xl overflow-hidden">
    <div class="py-6 border-b border-gray-100 text-center sticky top-0 bg-white z-10">
        <h3 class="text-lg font-bold text-gray-800">Edit Pengguna: {{ $user->username }}</h3>
        {{-- Tombol X di pojok kanan --}}
        <button type="button" onclick="handleCancelEditUser('{{ $user->id }}')"
            class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <form id="formEditUser_{{ $user->id }}" action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="p-8 space-y-6">
            <input type="hidden" name="user_id_for_edit" value="{{ $user->id }}">

            {{-- Input Username --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Username</label>
                <input type="text" name="username" placeholder="Masukkan Username" required
                    value="{{ old('username', $user->username) }}" oninput="checkChangesUser('{{ $user->id }}')"
                    class="w-full px-4 py-3 text-xs border border-dashed rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400
            @error('username', 'edit') border-red-500 @else border-gray-400 @enderror">
                @error('username', 'edit')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Email --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" placeholder="Masukkan Email" required
                    value="{{ old('email', $user->email) }}" oninput="checkChangesUser('{{ $user->id }}')"
                    class="w-full px-4 py-3 text-xs border border-dashed rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400
            @error('email', 'edit') border-red-500 @else border-gray-400 @enderror">
                @error('email', 'edit')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Sandi Baru --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Sandi Baru (Kosongkan jika tidak
                    diubah)</label>
                <div class="relative">
                    <input type="password" id="inputSandiEdit_{{ $user->id }}" name="password"
                        placeholder="Masukkan Sandi Baru" oninput="checkChangesUser('{{ $user->id }}')"
                        class="w-full px-4 py-3 text-xs border border-dashed rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400
                @error('password', 'edit') border-red-500 @else border-gray-400 @enderror">
                    <button type="button"
                        onclick="toggleSandi('inputSandiEdit_{{ $user->id }}', 'iconSandiEdit_{{ $user->id }}')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <i id="iconSandiEdit_{{ $user->id }}" class="fa-solid fa-eye-slash text-xs"></i>
                    </button>
                </div>
                @error('password', 'edit')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Role --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-3">Role</label>
                <div class="flex items-center gap-8">
                    @php $currentRole = old('role', $user->role); @endphp
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="role" value="admin" class="w-5 h-5 accent-birue" required
                            onchange="checkChangesUser('{{ $user->id }}')"
                            {{ $currentRole == 'admin' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-700">Admin</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="role" value="editor ub" class="w-5 h-5 accent-birue" required
                            onchange="checkChangesUser('{{ $user->id }}')"
                            {{ $currentRole == 'editor ub' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-700">Editor UB</span>
                    </label>
                </div>
            </div>

            {{-- Input Status --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-3">Status</label>
                <div class="flex items-center gap-8">
                    @php $currentStatus = old('status_pengguna', $user->status_pengguna); @endphp
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="status_pengguna" value="aktif" class="w-5 h-5 accent-birue"
                            required onchange="checkChangesUser('{{ $user->id }}')"
                            {{ $currentStatus == 'aktif' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-700">Aktif</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="status_pengguna" value="tidak aktif" class="w-5 h-5 accent-birue"
                            required onchange="checkChangesUser('{{ $user->id }}')"
                            {{ $currentStatus == 'tidak aktif' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-700">Tidak Aktif</span>
                    </label>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-between items-center pt-10 mt-4">
                <button type="button" onclick="handleCancelEditUser('{{ $user->id }}')"
                    class="px-12 py-3 border border-birua text-birua rounded-xl text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" id="btnSimpanUser_{{ $user->id }}" disabled
                    class="px-12 py-3 bg-gray-400 text-white rounded-xl text-xs font-bold transition cursor-not-allowed">
                    Simpan
                </button>
            </div>
        </div>
    </form>
</div>
