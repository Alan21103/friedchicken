<div x-show="showInputDetails" x-cloak
    class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-[#332B2B]/60 backdrop-blur-sm">
    
    <div class="bg-white rounded-[40px] w-full max-w-lg overflow-hidden shadow-2xl relative p-10 border border-[#332B2B]/5">
        <button @click="showInputDetails = false" class="absolute top-6 right-8 text-[#332B2B]/30 hover:text-red-500 transition-all text-2xl">✕</button>

        <div class="flex flex-col items-center text-center">
            <div class="w-24 h-24 bg-[#F5F1EE] rounded-full flex items-center justify-center mb-6 shadow-inner">
                <svg class="w-12 h-12 text-[#332B2B]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>

            <div class="space-y-1 mb-8">
                <h3 class="text-2xl font-black text-[#332B2B] uppercase tracking-tight" 
                    x-text="orderType === 'Dine In' ? 'Detail Meja & Pelanggan' : 'Data Pelanggan'">
                </h3>
                <p class="text-[#332B2B]/40 font-black text-[10px] uppercase tracking-[0.2em]">Pesanan akan diteruskan ke dapur</p>
            </div>

            <div class="w-full space-y-6 text-left">
                <template x-if="orderType === 'Dine In'">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-[#332B2B]/40 uppercase tracking-widest ml-2">Nomor Meja Pelanggan</label>
                        <div class="relative group">
                            <input x-model="nomorMeja" type="number" placeholder="00" 
                                class="w-full bg-[#F5F1EE] border-none rounded-[24px] p-6 text-2xl font-black text-[#332B2B] placeholder-[#332B2B]/20 focus:ring-4 focus:ring-[#332B2B]/5 transition-all">
                            
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 flex flex-col text-[#332B2B]/30 gap-1">
                                <button @click="nomorMeja++" class="hover:text-[#332B2B] transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                                </button>
                                <button @click="if(nomorMeja > 0) nomorMeja--" class="hover:text-[#332B2B] transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-[#332B2B]/40 uppercase tracking-widest ml-2">Nama Pelanggan</label>
                    <input x-model="namaPelanggan" type="text" placeholder="Masukkan nama..." 
                        class="w-full bg-[#F5F1EE] border-none rounded-[24px] p-6 font-bold text-[#332B2B] placeholder-[#332B2B]/20 focus:ring-4 focus:ring-[#332B2B]/5 transition-all">
                </div>
            </div>

            <div class="flex gap-4 w-full mt-10">
                <button @click="backToNotification()" 
                    class="flex-1 flex items-center justify-center gap-2 p-5 bg-[#F5F1EE] rounded-[24px] font-black text-[#332B2B]/40 hover:bg-[#332B2B]/5 transition-all uppercase tracking-widest text-[11px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                    Kembali
                </button>
                
                <button @click="finishOrder()" 
                    class="flex-1 flex items-center justify-center gap-2 p-5 bg-[#332B2B] rounded-[24px] font-black text-[#E6D5B8] hover:bg-[#433939] transition-all group shadow-xl shadow-[#332B2B]/20 uppercase tracking-widest text-[11px]">
                    <svg class="w-4 h-4 rotate-45 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Kirim Ke Dapur
                </button>
            </div>
        </div>
    </div>
</div>