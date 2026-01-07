<div x-show="showInputDetails" x-cloak
    class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    
    <div class="bg-white rounded-[40px] w-full max-w-lg overflow-hidden shadow-2xl relative p-10">
        <button @click="showInputDetails = false" class="absolute top-6 right-8 text-gray-400 text-2xl">✕</button>

        <div class="flex flex-col items-center text-center">
            <div class="w-24 h-24 bg-[#94A3B8] rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>

            <div class="space-y-1 mb-8">
                <h3 class="text-2xl font-bold text-gray-800" 
                    x-text="orderType === 'Dine In' ? 'Input Nomor Meja dan Nama Pelanggan' : 'Input Nama Pelanggan'">
                </h3>
                <p class="text-gray-500 font-medium">Pesanan akan dikirim ke dapur</p>
            </div>

            <div class="w-full space-y-6 text-left">
                <template x-if="orderType === 'Dine In'">
                    <div class="space-y-2">
                        <label class="font-bold text-[#2D3748] ml-1">Nomor Meja Pelanggan</label>
                        <div class="relative">
                            <input x-model="nomorMeja" type="number" placeholder="Masukan Nomor Meja" 
                                class="w-full bg-[#E5E5E5] border-none rounded-2xl p-5 font-medium placeholder-gray-500 focus:ring-2 focus:ring-gray-300 transition-all">
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 flex flex-col text-gray-600">
                                <svg class="w-4 h-4 cursor-pointer" @click="nomorMeja++" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                                <svg class="w-4 h-4 cursor-pointer" @click="if(nomorMeja > 0) nomorMeja--" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="space-y-2">
                    <label class="font-bold text-[#2D3748] ml-1">Nama Pelanggan</label>
                    <input x-model="namaPelanggan" type="text" placeholder="Masukan Nama Pelanggan" 
                        class="w-full bg-[#E5E5E5] border-none rounded-2xl p-5 font-medium placeholder-gray-500 focus:ring-2 focus:ring-gray-300 transition-all">
                </div>
            </div>

            <div class="flex gap-4 w-full mt-10">
                <button @click="backToNotification()" 
                    class="flex-1 flex items-center justify-center gap-2 p-5 bg-[#EEEEEE] rounded-2xl font-bold text-gray-700 hover:bg-gray-200 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                    Kembali
                </button>
                
                <button @click="finishOrder()" 
                    class="flex-1 flex items-center justify-center gap-2 p-5 bg-[#EEEEEE] rounded-2xl font-bold text-gray-700 hover:bg-black hover:text-white transition-all group">
                    <svg class="w-5 h-5 rotate-45 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Kirim Ke Dapur
                </button>
            </div>
        </div>
    </div>
</div>