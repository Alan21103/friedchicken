<div x-show="showSuccess" x-cloak
    class="fixed inset-0 z-[130] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    
    <div class="bg-white rounded-[40px] w-full max-w-lg overflow-hidden shadow-2xl relative p-8">
        <button @click="closeSuccess()" class="absolute top-6 right-8 text-gray-400 text-2xl">✕</button>

        <div class="flex flex-col items-center">
            <div class="w-20 h-20 bg-[#94A3B8] rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <div class="text-center mb-4">
                <h3 class="text-2xl font-bold text-gray-800">Pembayaran Berhasil</h3>
                <p class="text-gray-500 font-medium">Transaksi Berhasil</p>
            </div>

            <div class="text-center space-y-1 mb-6">
                <div class="text-xl font-black text-gray-800" x-text="orderCode">PSN-001</div>
                <div class="text-gray-600 font-bold" x-text="namaPelanggan || 'Pelanggan'"></div>
                
                <div class="mt-2 inline-block px-4 py-1.5 rounded-full bg-[#94A3B8] text-white text-sm font-bold">
                    <span x-text="orderType === 'Dine In' ? 'Dine In - Meja ' + nomorMeja : 'Take Away'"></span>
                </div>
            </div>

            <div class="w-full border-t border-dashed border-gray-300 pt-6 pb-4 space-y-3">
                <template x-for="item in cart" :key="item.id">
                    <div class="flex justify-between items-center font-bold text-gray-700">
                        <span x-text="item.nama"></span>
                        <span x-text="formatPrice(item.harga * item.qty)"></span>
                    </div>
                </template>
            </div>

            <div class="w-full border-t border-dashed border-gray-300 pt-4 space-y-2">
                <div class="flex justify-between text-gray-600 font-bold">
                    <span>Subtotal</span>
                    <span x-text="formatPrice(subtotal)"></span>
                </div>
                <div class="flex justify-between text-gray-600 font-bold">
                    <span>Pajak (10%)</span>
                    <span x-text="formatPrice(tax)"></span>
                </div>
                <div class="flex justify-between text-gray-600 font-bold">
                    <span>Biaya Layanan (5%)</span>
                    <span x-text="formatPrice(serviceFee)"></span>
                </div>
            </div>

            <div class="w-full pt-6 flex justify-between items-center text-gray-800">
                <span class="text-xl font-black">Total</span>
                <span class="text-xl font-black" x-text="formatPrice(total)"></span>
            </div>
            
            <div class="w-full flex justify-between text-gray-500 font-bold mt-1">
                <span>Metode Pembayaran</span>
                <span x-text="paymentMethod">Debit</span>
            </div>

            <div class="flex gap-4 w-full mt-8">
                <button @click="closeSuccess()" 
                    class="flex-1 flex items-center justify-center gap-2 p-5 bg-[#EEEEEE] rounded-2xl font-bold text-gray-700 hover:bg-gray-200 transition-all">
                    <span class="text-xl">✕</span> Tutup
                </button>
                
                <button @click="printReceipt()" 
                    class="flex-1 flex items-center justify-center gap-2 p-5 bg-[#EEEEEE] rounded-2xl font-bold text-gray-700 hover:bg-black hover:text-white transition-all group">
                    <svg class="w-5 h-5 text-gray-700 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Struk
                </button>
            </div>
        </div>
    </div>
</div>