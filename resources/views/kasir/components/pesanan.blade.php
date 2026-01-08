<div
    class="w-[380px] bg-[#FDFCFB] border-l flex flex-col shadow-2xl flex-shrink-0 h-screen rounded-l-2xl overflow-hidden">
    <div class="p-6 bg-[#332B2B] flex-shrink-0 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-[#E6D5B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                <h2 class="text-xl font-bold text-white tracking-tight">Pesanan</h2>
            </div>

            <div class="bg-[#E6D5B8] text-[#332B2B] text-[12px] w-7 h-7 rounded-full flex items-center justify-center font-bold shadow-md"
                x-show="cart.length > 0" x-cloak x-text="cart.length">
            </div>
        </div>

        <div class="bg-black/20 p-1.5 rounded-xl flex gap-1">
            <button @click="orderType = 'Dine In'"
                :class="orderType === 'Dine In' ? 'bg-[#4A3F3F] text-white shadow-sm' : 'text-white/40'"
                class="flex-1 py-2 rounded-lg font-bold text-xs transition-all flex items-center justify-center gap-2">
                Dine in
            </button>
            <button @click="orderType = 'Take Away'"
                :class="orderType === 'Take Away' ? 'bg-[#4A3F3F] text-white shadow-sm' : 'text-white/40'"
                class="flex-1 py-2 rounded-lg font-bold text-xs transition-all flex items-center justify-center gap-2">
                Take away
            </button>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-4 space-y-4 custom-scrollbar bg-[#F5F1EE]">
        <template x-for="item in cart" :key="item.id">
            <div
                class="bg-white rounded-[24px] p-4 relative flex gap-4 items-center shadow-md border border-[#332B2B]/5 hover:border-[#E6D5B8]/50 transition-colors">
                <button @click="updateQty(item.id, -item.qty)"
                    class="absolute top-3 right-3 text-[#332B2B] opacity-20 hover:opacity-100 transition-opacity">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <div
                    class="w-20 h-20 bg-[#F5F1EE] rounded-[18px] flex-shrink-0 flex items-center justify-center overflow-hidden border border-[#332B2B]/5">
                    <template x-if="item.image">
                        <img :src="item.image" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!item.image">
                        <svg class="w-8 h-8 text-[#332B2B]/10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </template>
                </div>

                <div class="flex-1">
                    <h5 class="font-bold text-[15px] text-[#332B2B] leading-tight mb-1" x-text="item.nama"></h5>

                    <div class="flex items-center bg-[#F5F1EE] rounded-full w-fit mb-2 border border-[#332B2B]/5">
                        <button @click="updateQty(item.id, -1)"
                            class="w-7 h-7 flex items-center justify-center font-bold text-[#332B2B] hover:text-[#E6D5B8] transition-colors">-</button>
                        <span class="text-xs font-bold px-2 min-w-[24px] text-center text-[#332B2B]"
                            x-text="item.qty"></span>
                        <button @click="updateQty(item.id, 1)"
                            class="w-7 h-7 flex items-center justify-center font-bold text-[#332B2B] hover:text-[#E6D5B8] transition-colors">+</button>
                    </div>

                    <p class="text-[#332B2B] font-extrabold text-sm" x-text="formatPrice(item.harga * item.qty)"></p>
                </div>

                <div class="absolute bottom-4 right-4 flex items-center gap-1.5 px-2.5 py-1 rounded-full shadow-sm border"
                    :class="item.kategori === 'Makanan' || item.kategori === 'Paket' 
            ? 'bg-amber-50 text-amber-600 border-amber-200' 
            : 'bg-emerald-50 text-emerald-600 border-emerald-200'">

                    <span class="w-1.5 h-1.5 rounded-full"
                        :class="item.kategori === 'Makanan' || item.kategori === 'Paket' ? 'bg-amber-500' : 'bg-emerald-500'">
                    </span>

                    <span class="text-[9px] font-bold uppercase tracking-wider"
                        x-text="item.kategori === 'Makanan' || item.kategori === 'Paket' ? 'Butuh Waktu' : 'Cepat'">
                    </span>
                </div>
            </div>
        </template>
    </div>

    <div class="p-6 pb-12 bg-white border-t border-[#332B2B]/5 space-y-3 flex-shrink-0">
        <div class="flex justify-between text-xs font-semibold text-[#332B2B]/50">
            <span>Subtotal</span>
            <span class="text-[#332B2B]" x-text="formatPrice(subtotal)"></span>
        </div>
        <div class="flex justify-between text-xs font-semibold text-[#332B2B]/50">
            <span>Pajak Resto (<span x-text="taxRate"></span>%)</span>
            <span class="text-[#332B2B]" x-text="formatPrice(taxAmount)"></span>
        </div>
        <div class="flex justify-between text-xs font-semibold text-[#332B2B]/50">
            <span>Service fee (<span x-text="serviceRate"></span>%)</span>
            <span class="text-[#332B2B]" x-text="formatPrice(serviceAmount)"></span>
        </div>

        <div class="pt-6 mt-4 border-t-2 border-dashed border-[#F5F1EE] pb-10">
            <div class="flex justify-between items-center mb-6">
                <span class="text-lg font-medium text-[#332B2B]/60 tracking-tight">Total Tagihan</span>
                <span class="text-2xl font-black text-[#332B2B]" x-text="formatPrice(total)"></span>
            </div>

            <button @click="showPayment = true" :disabled="cart.length === 0"
                class="w-full bg-[#332B2B] text-[#E6D5B8] py-4 rounded-2xl font-bold text-sm shadow-[0_10px_20px_-10px_rgba(51,43,43,0.5)] hover:bg-[#433939] disabled:opacity-30 transition-all active:scale-95 text-center uppercase tracking-widest">
                Konfirmasi Pembayaran
            </button>
        </div>
    </div>
</div>