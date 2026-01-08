<div x-show="showWaitNotification" x-cloak
    class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-[#332B2B]/60 backdrop-blur-sm">
    
    <div class="bg-white rounded-[40px] w-full max-w-lg overflow-hidden shadow-2xl relative p-8 border border-[#332B2B]/5">
        <button @click="showWaitNotification = false" class="absolute top-6 right-8 text-[#332B2B]/30 hover:text-red-500 transition-colors text-2xl">✕</button>

        <div class="flex flex-col items-center text-center space-y-4">
            <div class="w-24 h-24 bg-[#F5F1EE] rounded-full flex items-center justify-center shadow-inner">
                <svg class="w-12 h-12 text-[#332B2B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <div class="space-y-1">
                <h3 class="text-xl font-black text-[#332B2B] uppercase tracking-tight">Status Persiapan Pesanan</h3>
                <p class="text-[#332B2B]/60 font-bold text-sm">ORDER ID: <span class="text-[#332B2B]" x-text="orderCode"></span></p>
            </div>

            <div class="w-full space-y-4 pt-4 text-left">
                <template x-if="timeConsumingItems.length > 0">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-amber-600 text-[10px] font-black uppercase tracking-[0.2em] ml-1">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                            <span>Butuh Waktu</span>
                        </div>
                        <template x-for="item in timeConsumingItems" :key="item.id">
                            <div class="flex items-center gap-3 bg-amber-50/50 p-3 rounded-2xl border border-amber-100">
                                <div class="w-12 h-12 bg-[#332B2B] rounded-xl overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    <template x-if="item.image">
                                        <img :src="item.image" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!item.image">
                                        <i class="fa-solid fa-utensils text-[#E6D5B8] text-xs"></i>
                                    </template>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <span class="font-bold text-[#332B2B] text-sm" x-text="item.nama"></span>
                                        <span class="bg-amber-100 text-amber-700 text-[9px] px-2 py-0.5 rounded-lg font-black uppercase">Waiting</span>
                                    </div>
                                    <span class="text-[#332B2B]/40 text-xs font-bold" x-text="'Jumlah: ' + item.qty"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="fastItems.length > 0">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-emerald-600 text-[10px] font-black uppercase tracking-[0.2em] ml-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>Cepat</span>
                        </div>
                        <template x-for="item in fastItems" :key="item.id">
                            <div class="flex items-center gap-3 bg-emerald-50/30 p-3 rounded-2xl border border-emerald-100">
                                <div class="w-12 h-12 bg-[#E6D5B8] rounded-xl overflow-hidden flex-shrink-0 flex items-center justify-center text-[#332B2B]">
                                    <template x-if="item.image">
                                        <img :src="item.image" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!item.image">
                                        <i class="fa-solid fa-bolt-lightning text-xs"></i>
                                    </template>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <span class="font-bold text-[#332B2B]/70 text-sm" x-text="item.nama"></span>
                                        <span class="bg-emerald-100 text-emerald-700 text-[9px] px-2 py-0.5 rounded-lg font-black uppercase">Fast</span>
                                    </div>
                                    <span class="text-[#332B2B]/30 text-xs font-bold" x-text="'Jumlah: ' + item.qty"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            <p class="font-bold pt-4 text-sm text-[#332B2B]">Apakah pelanggan akan menunggu di meja?</p>

            <div class="flex gap-4 w-full pt-2">
                <button @click="finishOrder()" 
                    class="flex-1 p-5 bg-[#F5F1EE] rounded-[24px] group hover:bg-red-500 transition-all duration-300 border border-[#332B2B]/5 shadow-sm">
                    <div class="flex flex-col items-center">
                        <span class="text-xl group-hover:text-white mb-1">✕</span>
                        <span class="font-black text-[10px] uppercase tracking-widest text-[#332B2B] group-hover:text-white">Tidak</span>
                        <span class="text-[9px] text-[#332B2B]/40 group-hover:text-white/70 uppercase font-bold">Ambil Langsung</span>
                    </div>
                </button>
                <button @click="goToInputDetails()" 
                    class="flex-1 p-5 bg-[#332B2B] rounded-[24px] group hover:bg-[#433939] transition-all duration-300 shadow-lg shadow-[#332B2B]/20">
                    <div class="flex flex-col items-center">
                        <span class="text-xl mb-1">🪑</span>
                        <span class="font-black text-[10px] uppercase tracking-widest text-[#E6D5B8]">Ya, Tunggu</span>
                        <span class="text-[9px] text-[#E6D5B8]/40 uppercase font-bold">Input No Meja</span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>