<div x-show="showPayment" x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-[#332B2B]/60 backdrop-blur-sm">

    <div class="bg-white rounded-[40px] w-full max-w-2xl overflow-hidden shadow-2xl border border-[#332B2B]/5" @click.away="showPayment = false">
        
        <div class="p-6 bg-[#332B2B] flex justify-between items-center shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#E6D5B8] rounded-xl flex items-center justify-center text-[#332B2B]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-black text-[#E6D5B8] uppercase tracking-wider">Pembayaran</h3>
                    <p class="text-[10px] text-[#E6D5B8]/50 font-bold uppercase tracking-[0.2em] leading-none mt-1">Selesaikan Transaksi</p>
                </div>
            </div>
            <button @click="showPayment = false" class="bg-white/10 hover:bg-red-500 text-[#E6D5B8] hover:text-white transition-all w-10 h-10 rounded-full flex items-center justify-center font-bold">✕</button>
        </div>

        <div class="p-8 space-y-6 max-h-[85vh] overflow-y-auto bg-white">
            <div class="bg-[#F5F1EE] rounded-[30px] p-6 space-y-3 text-sm border border-[#332B2B]/5 shadow-inner">
                <div class="flex justify-between font-bold text-[#332B2B]/50">
                    <span class="uppercase tracking-widest text-[10px]">Tipe Pesanan</span>
                    <span class="text-[#332B2B] font-black" x-text="orderType"></span>
                </div>
                <div class="flex justify-between font-bold text-[#332B2B]/50">
                    <span class="uppercase tracking-widest text-[10px]">Pajak (10%)</span>
                    <span class="text-[#332B2B]" x-text="formatPrice(tax || 0)"></span>
                </div>
                <div class="flex justify-between font-bold text-[#332B2B]/50">
                    <span class="uppercase tracking-widest text-[10px]">Service Fee (5%)</span>
                    <span class="text-[#332B2B]" x-text="formatPrice(serviceFee || 0)"></span>
                </div>
                <div class="pt-4 border-t border-[#332B2B]/10 flex justify-between items-center mt-2">
                    <span class="text-2xl font-black text-[#332B2B] tracking-tighter uppercase">Total Tagihan</span>
                    <span class="text-3xl font-black text-[#332B2B] tracking-tighter" x-text="formatPrice(total)"></span>
                </div>
            </div>

            <div>
                <p class="font-black mb-4 text-[#332B2B] uppercase text-[10px] tracking-[0.2em] ml-2">Pilih Metode Bayar</p>
                <div class="grid grid-cols-3 gap-4">
                    <button @click="paymentMethod = 'Tunai'" :class="paymentMethod === 'Tunai' ? 'border-[#332B2B] bg-[#332B2B] text-[#E6D5B8] shadow-lg scale-[1.02]' : 'border-transparent bg-[#F5F1EE] text-[#332B2B]/40'" class="p-5 rounded-[24px] border-2 flex flex-col items-center justify-center gap-3 transition-all duration-300">
                        <i class="fa-solid fa-money-bill-wave text-2xl"></i>
                        <span class="font-black text-[11px] uppercase tracking-widest">Tunai</span>
                    </button>
                    <button @click="paymentMethod = 'QRIS'" :class="paymentMethod === 'QRIS' ? 'border-[#332B2B] bg-[#332B2B] text-[#E6D5B8] shadow-lg scale-[1.02]' : 'border-transparent bg-[#F5F1EE] text-[#332B2B]/40'" class="p-5 rounded-[24px] border-2 flex flex-col items-center justify-center gap-3 transition-all duration-300">
                        <i class="fa-solid fa-qrcode text-2xl"></i>
                        <span class="font-black text-[11px] uppercase tracking-widest">QRIS</span>
                    </button>
                    <button @click="paymentMethod = 'Debit'" :class="paymentMethod === 'Debit' ? 'border-[#332B2B] bg-[#332B2B] text-[#E6D5B8] shadow-lg scale-[1.02]' : 'border-transparent bg-[#F5F1EE] text-[#332B2B]/40'" class="p-5 rounded-[24px] border-2 flex flex-col items-center justify-center gap-3 transition-all duration-300">
                        <i class="fa-solid fa-credit-card text-2xl"></i>
                        <span class="font-black text-[11px] uppercase tracking-widest">Debit</span>
                    </button>
                </div>
            </div>

            <div x-show="paymentMethod === 'Tunai'" x-transition class="space-y-4 pt-2">
                <p class="font-black text-[10px] text-[#332B2B]/40 uppercase tracking-[0.2em] ml-2">Uang Diterima (Cash Received)</p>
                <div class="relative group">
                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-[#332B2B]/20 font-black text-xl">Rp</span>
                    <input type="number" x-model.number="cashReceived" class="w-full p-6 pl-14 bg-[#F5F1EE] rounded-[24px] text-3xl font-black text-[#332B2B] focus:outline-none focus:ring-4 focus:ring-[#332B2B]/5 transition-all" placeholder="0">
                </div>
                <div class="flex flex-wrap gap-2 px-1">
                    <template x-for="nominal in nominalOptions" :key="nominal">
                        <button @click="cashReceived = nominal" class="px-5 py-2.5 bg-[#F5F1EE] text-[#332B2B] border border-[#332B2B]/5 rounded-xl text-[11px] font-black hover:bg-[#332B2B] hover:text-[#E6D5B8] transition-all transform active:scale-95" x-text="formatPrice(nominal)"></button>
                    </template>
                </div>
                <div class="bg-[#332B2B] p-6 rounded-[24px] flex justify-between items-center shadow-xl">
                    <div class="flex flex-col">
                        <span class="text-[9px] font-black text-[#E6D5B8]/40 uppercase tracking-[0.3em]">Uang Kembalian</span>
                        <span class="text-3xl font-black text-[#E6D5B8] tracking-tighter" x-text="formatPrice(change)"></span>
                    </div>
                    <i class="fa-solid fa-coins text-[#E6D5B8]/20 text-2xl"></i>
                </div>
            </div>

            <div x-show="paymentMethod === 'QRIS'" x-transition class="pt-2 text-center">
                <div class="bg-[#F5F1EE] p-8 rounded-[30px] border-2 border-dashed border-[#332B2B]/20 flex flex-col items-center gap-4">
                    <div class="bg-white p-4 rounded-2xl shadow-sm">
                        <i class="fa-solid fa-qrcode text-7xl text-[#332B2B]"></i>
                    </div>
                    <div>
                        <p class="font-black text-[#332B2B] text-lg uppercase tracking-tight">Scan QRIS untuk Melanjutkan</p>
                        <p class="text-[11px] text-[#332B2B]/50 font-bold uppercase tracking-widest mt-1">Pastikan nominal sesuai di layar pelanggan</p>
                    </div>
                </div>
            </div>

            <div x-show="paymentMethod === 'Debit'" x-transition class="pt-2 text-center">
                <div class="bg-[#F5F1EE] p-8 rounded-[30px] border-2 border-dashed border-[#332B2B]/20 flex flex-col items-center gap-4">
                    <div class="w-20 h-20 bg-white rounded-2xl shadow-sm flex items-center justify-center">
                        <i class="fa-solid fa-credit-card text-4xl text-[#332B2B]"></i>
                    </div>
                    <div>
                        <p class="font-black text-[#332B2B] text-lg uppercase tracking-tight">Insert Kartu untuk Melanjutkan</p>
                        <p class="text-[11px] text-[#332B2B]/50 font-bold uppercase tracking-widest mt-1">Gunakan Mesin EDC yang tersedia</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-6">
                <button @click="showPayment = false" class="flex-1 py-5 bg-[#F5F1EE] text-[#332B2B]/40 rounded-[20px] font-black hover:bg-[#332B2B]/5 transition-all uppercase tracking-widest text-[11px]">
                    Batal
                </button>
                <button @click="confirmPayment()" :disabled="paymentMethod === 'Tunai' && (cashReceived < total || cashReceived === 0)" class="flex-1 py-5 bg-[#332B2B] text-[#E6D5B8] rounded-[20px] font-black hover:bg-[#433939] transition-all disabled:opacity-20 disabled:grayscale uppercase tracking-widest text-[11px] shadow-2xl shadow-[#332B2B]/30">
                    Konfirmasi Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>