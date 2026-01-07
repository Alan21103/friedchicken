<div x-show="showWaitNotification" x-cloak
    class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    
    <div class="bg-white rounded-[40px] w-full max-w-lg overflow-hidden shadow-2xl relative p-8">
        <button @click="showWaitNotification = false" class="absolute top-6 right-8 text-gray-400 text-2xl">✕</button>

        <div class="flex flex-col items-center text-center space-y-4">
            <div class="w-24 h-24 bg-[#E5E5E5] rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-[#4F5B69]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <div class="space-y-1">
                <h3 class="text-xl font-bold">Pesanan Membutuhkan waktu</h3>
                <p class="text-gray-600 font-bold">Kode Pesanan: <span x-text="orderCode"></span></p>
            </div>

            <div class="w-full space-y-4 pt-4 text-left">
                <template x-if="timeConsumingItems.length > 0">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-[#828282] text-sm font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Butuh Waktu</span>
                        </div>
                        <template x-for="item in timeConsumingItems" :key="item.id">
                            <div class="flex items-center gap-3 bg-[#F3F3F3] p-3 rounded-2xl border border-gray-200">
                                <div class="w-12 h-12 bg-gray-300 rounded-lg flex items-center justify-center text-white text-[10px]">IMG</div>
                                <div class="flex-1 font-bold">
                                    <span x-text="item.nama"></span>
                                    <span class="text-gray-400 ml-1" x-text="'x' + item.qty"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="fastItems.length > 0">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-[#828282] text-sm font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"></path></svg>
                            <span>Cepat</span>
                        </div>
                        <template x-for="item in fastItems" :key="item.id">
                            <div class="flex items-center gap-3 bg-[#F3F3F3] p-3 rounded-2xl border border-gray-200">
                                <div class="w-12 h-12 bg-gray-300 rounded-lg flex items-center justify-center text-white text-[10px]">IMG</div>
                                <div class="flex-1 font-bold">
                                    <span x-text="item.nama"></span>
                                    <span class="text-gray-400 ml-1" x-text="'x' + item.qty"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            <p class="font-bold pt-4 text-sm">Apakah pelanggan akan menunggu di meja?</p>

            <div class="flex gap-4 w-full pt-2">
                <button @click="finishOrder()" 
                    class="flex-1 p-4 bg-[#F3F3F3] rounded-2xl group hover:bg-black transition-all">
                    <div class="flex flex-col items-center">
                        <span class="text-xl group-hover:text-white">✕</span>
                        <span class="font-bold text-xs group-hover:text-white">Tidak</span>
                        <span class="text-[10px] text-gray-400 group-hover:text-gray-300">Ambil Langsung</span>
                    </div>
                </button>
                <button @click="goToInputDetails() /* logic input no meja */" 
                    class="flex-1 p-4 bg-[#F3F3F3] rounded-2xl group hover:bg-black transition-all">
                    <div class="flex flex-col items-center">
                        <span class="text-xl group-hover:text-white">🪑</span>
                        <span class="font-bold text-xs group-hover:text-white">Ya, Tunggu</span>
                        <span class="text-[10px] text-gray-400 group-hover:text-gray-300">Input No Meja</span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>