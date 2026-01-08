<div x-show="showSuccess" x-cloak
    class="fixed inset-0 z-[130] flex items-center justify-center p-4 bg-[#332B2B]/60 backdrop-blur-sm">
    
    <div id="receipt-content" class="bg-white rounded-[40px] w-full max-w-lg overflow-hidden shadow-2xl relative p-8 border border-[#332B2B]/5">
        
        <button @click="closeSuccess()" class="ignore-download absolute top-6 right-8 text-[#332B2B]/30 hover:text-red-500 transition-all text-2xl">✕</button>

        <div class="flex flex-col items-center">
            <div class="w-20 h-20 bg-emerald-500 rounded-full flex items-center justify-center mb-4 shadow-lg shadow-emerald-200">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <div class="text-center mb-4">
                <h3 class="text-2xl font-black text-[#332B2B] uppercase tracking-tight">Pembayaran Berhasil</h3>
                <p class="text-[#332B2B]/40 font-bold text-xs uppercase tracking-[0.2em]">Transaksi telah selesai</p>
            </div>

            <div class="text-center space-y-1 mb-6">
                <div class="text-xl font-black text-[#332B2B] tracking-tighter" x-text="orderCode">PSN-001</div>
                <div class="text-[#332B2B]/60 font-black uppercase text-sm" x-text="namaPelanggan || 'Pelanggan'"></div>
                
                <div class="mt-2 inline-block px-4 py-1.5 rounded-full bg-[#F5F1EE] text-[#332B2B] text-[10px] font-black uppercase tracking-widest border border-[#332B2B]/5">
                    <span x-text="orderType === 'Dine In' ? 'Dine In • Meja ' + nomorMeja : 'Take Away • Pickup'"></span>
                </div>
            </div>

            <div class="w-full border-t border-dashed border-[#332B2B]/10 pt-6 pb-4 space-y-3">
                <template x-for="item in cart" :key="item.id">
                    <div class="flex justify-between items-center font-bold text-[#332B2B]/80 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] bg-[#F5F1EE] px-2 py-0.5 rounded text-[#332B2B]" x-text="item.qty + 'x'"></span>
                            <span x-text="item.nama"></span>
                        </div>
                        <span class="font-black" x-text="formatPrice(item.harga * item.qty)"></span>
                    </div>
                </template>
            </div>

            <div class="w-full border-t border-dashed border-[#332B2B]/10 pt-4 space-y-2">
                <div class="flex justify-between text-[#332B2B]/50 font-bold text-xs uppercase tracking-tighter">
                    <span>Subtotal</span>
                    <span x-text="formatPrice(subtotal)"></span>
                </div>
                <div class="flex justify-between text-[#332B2B]/50 font-bold text-xs uppercase tracking-tighter">
                    <span>Pajak (10%)</span>
                    <span x-text="formatPrice(tax)"></span>
                </div>
                <div class="flex justify-between text-[#332B2B]/50 font-bold text-xs uppercase tracking-tighter">
                    <span>Biaya Layanan (5%)</span>
                    <span x-text="formatPrice(serviceFee)"></span>
                </div>
            </div>

            <div class="w-full pt-6 flex justify-between items-center text-[#332B2B]">
                <span class="text-xl font-black uppercase tracking-tighter">Total</span>
                <span class="text-2xl font-black tracking-tighter" x-text="formatPrice(total)"></span>
            </div>
            
            <div class="w-full flex justify-between text-[#332B2B]/40 font-black text-[10px] uppercase tracking-[0.2em] mt-1">
                <span>Metode Pembayaran</span>
                <span class="text-[#332B2B]" x-text="paymentMethod">Debit</span>
            </div>

            <div class="flex gap-4 w-full mt-8 ignore-download">
                <button @click="closeSuccess()" 
                    class="ignore-download flex-1 flex items-center justify-center gap-2 p-5 bg-[#F5F1EE] rounded-[24px] font-black text-[#332B2B]/40 hover:bg-[#332B2B]/5 transition-all uppercase tracking-widest text-[11px]">
                    ✕ Tutup
                </button>
                
                <button @click="printReceipt()" 
                    class="ignore-download flex-1 flex items-center justify-center gap-2 p-5 bg-[#332B2B] rounded-[24px] font-black text-[#E6D5B8] hover:bg-[#433939] transition-all group shadow-xl shadow-[#332B2B]/20 uppercase tracking-widest text-[11px]">
                    <svg class="w-4 h-4 text-[#E6D5B8] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Struk
                </button>
            </div>
        </div>
    </div>
</div>