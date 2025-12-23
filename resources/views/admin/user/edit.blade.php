{{-- File: resources/views/user/edit.blade.php --}}
<div class="bg-white rounded-2xl overflow-hidden">
    <div class="py-6 border-b border-gray-200 text-center">
        <h3 class="text-lg font-bold text-gray-800">Edit Pengguna: {{ $user->username }}</h3>
    </div>


    <form id="formEdit{{ $user->id }}" action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="p-8 space-y-6">
            {{-- HIDDEN INPUT WAJIB UNTUK ERROR HANDLER DI INDEX --}}
            <input type="hidden" name="user_id_for_edit" value="{{ $user->id }}">

            {{-- Input Username --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Username</label>
                <input type="text" name="username" placeholder="Masukkan Username" required
                    value="{{ old('username', $user->username) }}"
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
                    value="{{ old('email', $user->email) }}"
                    class="w-full px-4 py-3 text-xs border border-dashed rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400
            @error('email', 'edit') border-red-500 @else border-gray-400 @enderror">
                @error('email', 'edit')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Sandi Baru (Opsional) --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Sandi Baru (Kosongkan jika tidak
                    diubah)</label>
                <div class="relative">
                    {{-- ID input sandi harus dinamis: inputSandiEdit_[id] --}}
                    <input type="password" id="inputSandiEdit_{{ $user->id }}" name="password"
                        placeholder="Masukkan Sandi Baru"
                        class="w-full px-4 py-3 text-xs border border-dashed rounded-lg focus:outline-none focus:ring-1 focus:ring-birua transition placeholder:text-gray-400
                @error('password', 'edit') border-red-500 @else border-gray-400 @enderror">
                    {{-- ID icon sandi harus dinamis: iconSandiEdit_[id] --}}
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

            {{-- Input Role (Radio) --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-3">Role</label>
                <div class="flex items-center gap-8">
                    @php $currentRole = old('role', $user->role); @endphp

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="role" value="admin" class="w-5 h-5 accent-birue" required
                            {{ $currentRole == 'admin' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-700">Admin</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="role" value="editor ub" class="w-5 h-5 accent-birue" required
                            {{ $currentRole == 'editor ub' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-700">Editor UB</span>
                    </label>
                </div>
                @error('role', 'edit')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Status (Radio) --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-3">Status</label>
                <div class="flex items-center gap-8">
                    @php $currentStatus = old('status_pengguna', $user->status_pengguna); @endphp

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="status_pengguna" value="aktif" class="w-5 h-5 accent-birue"
                            required {{ $currentStatus == 'aktif' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-700">Aktif</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="status_pengguna" value="tidak aktif" class="w-5 h-5 accent-birue"
                            required {{ $currentStatus == 'tidak aktif' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-700">Tidak Aktif</span>
                    </label>
                </div>
                @error('status_pengguna', 'edit')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi (Footer) --}}
            <div class="flex gap-4 pt-6">
                {{-- Panggil closeModal dengan ID modal dan ID form yang sesuai --}}
                <button type="button"
                    onclick="openDiscardConfirmation('Pengguna', 'modalEdit_{{ $user->id }}', 'formEditPengguna_{{ $user->id }}')"
                    class="flex-1 py-3 border border-birua text-birua rounded-xl text-xs font-bold hover:bg-gray-50 transition shadow-sm">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 py-3 bg-birua text-white rounded-xl text-xs font-bold hover:bg-biruc transition shadow-lg shadow-blue-100">
                    Perbarui
                </button>
            </div>
        </div>
    </form>
