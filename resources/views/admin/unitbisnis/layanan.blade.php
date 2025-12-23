<div id="modalLayanan"
     class="fixed inset-0 z-60 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-all duration-300">

    <div id="modalContentLayanan"
         class="bg-white rounded-2xl shadow-2xl w-[90%] max-w-md transform scale-95 opacity-0 transition-all duration-300 p-6 relative">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-base font-bold text-gray-800">Layanan</h3>
            <button onclick="closeLayananModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <div id="listLayanan" class="space-y-3 max-h-[60vh] overflow-y-auto pr-2 scrollbar-hide">
            </div>
    </div>
</div>
