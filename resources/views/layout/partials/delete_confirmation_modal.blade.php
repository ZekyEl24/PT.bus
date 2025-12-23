{{-- ================================================================= --}}
{{-- MODAL KONFIRMASI HAPUS UNIVERSAL --}}
{{-- ================================================================= --}}

<div id="deleteConfirmationModal"
    class="fixed inset-0 hidden items-center justify-center bg-black/60 backdrop-blur-sm px-4 z-[9999]">

    <div class="bg-linear-to-t  from-[#252323] to-birue rounded-[15px] shadow-2xl w-[80%] max-w-2xs transform transition-all scale-95 opacity-0 duration-300 relative text-center text-white"
         id="deleteConfirmationModalContent"
         style="border: 1px solid #4a5568;"> {{-- Warna latar gelap sesuai gambar --}}

        <div class="p-8 space-y-2">
            {{-- Icon Warning Kuning --}}
            <div class="flex justify-center">
                <svg class="text-kuning" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="currentColor" d="M12 7.25a.75.75 0 0 1 .75.75v5a.75.75 0 0 1-1.5 0V8a.75.75 0 0 1 .75-.75M12 17a1 1 0 1 0 0-2a1 1 0 0 0 0 2"/><path fill="currentColor" fill-rule="evenodd" d="M8.294 4.476C9.366 3.115 10.502 2.25 12 2.25s2.634.865 3.706 2.226c1.054 1.34 2.17 3.32 3.6 5.855l.436.772c1.181 2.095 2.115 3.75 2.605 5.077c.5 1.358.62 2.59-.138 3.677c-.735 1.055-1.962 1.486-3.51 1.69c-1.541.203-3.615.203-6.274.203h-.85c-2.66 0-4.733 0-6.274-.203c-1.548-.204-2.775-.635-3.51-1.69c-.758-1.087-.639-2.32-.138-3.677c.49-1.328 1.424-2.982 2.605-5.077l.436-.772c1.429-2.535 2.546-4.516 3.6-5.855m1.179.928C8.499 6.641 7.437 8.52 5.965 11.13l-.364.645c-1.226 2.174-2.097 3.724-2.54 4.925c-.438 1.186-.378 1.814-.04 2.3c.361.516 1.038.87 2.476 1.06c1.432.188 3.406.19 6.14.19h.727c2.733 0 4.707-.002 6.14-.19c1.437-.19 2.114-.544 2.474-1.06c.339-.486.4-1.114-.038-2.3c-.444-1.201-1.315-2.751-2.541-4.925l-.364-.645c-1.472-2.61-2.534-4.489-3.508-5.726C13.562 4.18 12.813 3.75 12 3.75s-1.562.429-2.527 1.654" clip-rule="evenodd"/></svg>
            </div>

            <h3 class="text-xl font-bold text-kuning mb-5">Konfirmasi</h3>

            <p class="text-xs text-gray-300">
                Apakah kamu yakin untuk menghapus data ini? Data yang dihapus tidak dapat dikembalikan lagi.
            </p>
        </div>

        <div class="p-8 pt-2 flex justify-between gap-4">
            {{-- Tombol 'Tidak' (Merah) --}}
            <button type="button" onclick="closeModal('deleteConfirmationModal')"
                class="flex-1 py-2 px-4 bg-red-600 text-white rounded-[10px] text-xs font-bold hover:bg-red-700 transition shadow-lg">
                Tidak
            </button>

            {{-- Tombol 'Ya' (Kuning) --}}
            {{-- Tombol ini akan memicu form hapus --}}
            <button type="button" id="confirmDeleteButton"
                class="flex-1 py-2 px-4 bg-yellow-500 text-black rounded-[10px] text-xs font-bold hover:bg-yellow-600 transition shadow-lg">
                Ya
            </button>
        </div>
    </div>
</div>

{{-- Form tersembunyi untuk menjalankan aksi DELETE --}}
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
