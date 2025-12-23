{{-- ================================================================= --}}
{{-- MODAL KONFIRMASI PEMBATALAN (ID DIBERI NAMA 'editConfirmation') --}}
{{-- layout.partials.edit_confirmation --}}
{{-- ================================================================= --}}

<div id="editConfirmation"
    class="fixed inset-0 hidden items-center justify-center bg-black/60 backdrop-blur-sm px-4 z-[9999]">

    <div
        class="bg-linear-to-t from-[#252323] to-birue rounded-[15px] shadow-2xl w-[80%] max-w-2xs transform transition-all scale-95 opacity-0 duration-300 relative text-center text-white"
        id="editConfirmationContent" {{-- <--- ID KONTEN DIPERBAIKI di sini! --}} style="border: 1px solid #4a5568;">

        <div class="p-8 space-y-2">
            {{-- Icon Warning Kuning --}}
            <div class="flex justify-center mb-3">
                <svg class="text-kuning" xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                    viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M21 13.1c-.1 0-.3.1-.4.2l-1 1l2.1 2.1l1-1c.2-.2.2-.6 0-.8l-1.3-1.3c-.1-.1-.2-.2-.4-.2m-1.9 1.8l-6.1 6V23h2.1l6.1-6.1zM12.5 7v5.2l4 2.4l-1 1L11 13V7zM11 21.9c-5.1-.5-9-4.8-9-9.9C2 6.5 6.5 2 12 2c5.3 0 9.6 4.1 10 9.3c-.3-.1-.6-.2-1-.2s-.7.1-1 .2C19.6 7.2 16.2 4 12 4c-4.4 0-8 3.6-8 8c0 4.1 3.1 7.5 7.1 7.9l-.1.2z" />
                </svg>
                </div>

            <h3 class="text-xl font-bold text-kuning mb-5">Batalkan Perubahan?</h3>

            <p class="text-xs text-gray-300">
                Semua perubahan data <strong id="discardContextText" class="text-white"></strong> tidak akan tersimpan. Apakah Anda yakin?
                </p>
            </div>

        <div class="p-8 pt-2 flex justify-between gap-4">
            {{-- Tombol 'Tidak' (Lanjutkan Edit) --}}
            <button type="button" onclick="closeModal('editConfirmation')"
                class="flex-1 py-2 px-4 bg-red-600 text-white rounded-[10px] text-xs font-bold hover:bg-red-700 transition shadow-lg">
                Tidak
                </button>

            {{-- Tombol 'Ya' (Konfirmasi Pembatalan) --}}
            <button type="button" id="confirmEditButton" {{-- <--- ID tombol tetap sesuai permintaan Anda --}}
                class="flex-1 py-2 px-4 bg-yellow-500 text-black rounded-[10px] text-xs font-bold hover:bg-yellow-600 transition shadow-lg">
                Ya
                </button>
            </div>
        </div>
</div>
