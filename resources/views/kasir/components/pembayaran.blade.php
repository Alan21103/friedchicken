<div x-show="showPayment" x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">

    <div class="bg-white rounded-[40px] w-full max-w-2xl overflow-hidden shadow-2xl" @click.away="showPayment = false">
        <div class="p-6 border-b flex justify-between items-center">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                <h3 class="text-xl font-bold">Pembayaran</h3>
            </div>
            <button @click="showPayment = false"
                class="text-gray-400 hover:text-red-500 transition-colors text-2xl">✕</button>
        </div>

        <div class="p-8 space-y-6 max-h-[85vh] overflow-y-auto">
            <div class="bg-[#F3F3F3] rounded-[30px] p-6 space-y-3 text-sm">
                <div class="flex justify-between font-bold text-[#828282]">
                    <span>Tipe Pesanan</span>
                    <span class="text-black" x-text="orderType"></span>
                </div>
                <div class="flex justify-between font-bold text-[#828282]">
                    <span>Subtotal (<span x-text="cart.length"></span> item)</span>
                    <span class="text-black" x-text="formatPrice(subtotal)"></span>
                </div>
                <div class="flex justify-between font-bold text-[#828282]">
                    <span>Pajak (10%)</span>
                    <span class="text-black" x-text="formatPrice(tax)"></span>
                </div>
                <div class="flex justify-between font-bold text-[#828282]">
                    <span>Service fee (5%)</span>
                    <span class="text-black" x-text="formatPrice(serviceFee)"></span>
                </div>
                <div class="pt-4 border-t border-gray-300 flex justify-between items-center mt-2">
                    <span class="text-2xl font-black">Total</span>
                    <span class="text-2xl font-black text-[#1A1A1A]" x-text="formatPrice(total)"></span>
                </div>
            </div>

            <div>
                <p class="font-bold mb-4">Metode Pembayaran</p>
                <div class="grid grid-cols-3 gap-4">
                    <button @click="paymentMethod = 'Tunai'"
                        :class="paymentMethod === 'Tunai' ? 'border-black bg-white ring-1 ring-black' : 'border-transparent bg-[#F3F3F3]'"
                        class="p-4 rounded-2xl border-2 flex flex-col items-center justify-center gap-2 transition-all group">

                        <svg class="w-10 h-10 text-black" viewBox="0 0 48 48" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="4" y="10" width="40" height="28" rx="4" stroke="currentColor" stroke-width="2.5" />
                            <circle cx="24" cy="24" r="6" stroke="currentColor" stroke-width="2.5" />
                            <path d="M38 16H40M8 16H10M38 32H40M8 32H10" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" />
                            <path d="M24 21V27" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
                            <path
                                d="M21 22.5C21 22.5 22 21.5 24 21.5C26 21.5 27 22.5 27 24C27 25.5 26 26.5 24 26.5C22 26.5 21 27.5 21 29"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" class="hidden" />
                            <text x="21" y="28" fill="currentColor"
                                style="font: bold 12px Arial; letter-spacing: -1px;">$</text>
                        </svg>

                        <span class="font-bold text-sm">Tunai</span>
                    </button>

                    <button @click="paymentMethod = 'QRIS'"
                        :class="paymentMethod === 'QRIS' ? 'border-black bg-white ring-1 ring-black' : 'border-transparent bg-[#F3F3F3]'"
                        class="p-4 rounded-2xl border-2 flex flex-col items-center justify-center gap-2 transition-all">
                        <svg class="w-10 h-10 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <rect x="3" y="3" width="6" height="6"></rect>
                            <rect x="15" y="3" width="6" height="6"></rect>
                            <rect x="3" y="15" width="6" height="6"></rect>
                            <rect x="15" y="15" width="2" height="2"></rect>
                            <rect x="19" y="15" width="2" height="2"></rect>
                            <rect x="15" y="19" width="2" height="2"></rect>
                            <rect x="19" y="19" width="2" height="2"></rect>
                        </svg>
                        <span class="font-bold text-sm">Qris</span>
                    </button>

                    <button @click="paymentMethod = 'Debit'"
                        :class="paymentMethod === 'Debit' ? 'border-black bg-white ring-1 ring-black' : 'border-transparent bg-[#F3F3F3]'"
                        class="p-4 rounded-2xl border-2 flex flex-col items-center justify-center gap-2 transition-all">
                        <svg class="w-10 h-10 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <path d="M2 10H22M6 15H10"></path>
                        </svg>
                        <span class="font-bold text-sm">Debit</span>
                    </button>
                </div>
            </div>

            <hr class="border-gray-100">

            <div x-show="paymentMethod === 'Tunai'" x-transition class="space-y-4">
                <p class="font-bold text-sm text-[#333]">Jumlah Uang Diterima</p>
                <input type="number" x-model.number="cashReceived"
                    class="w-full p-5 bg-[#E5E5E5] rounded-2xl text-2xl font-black focus:outline-none placeholder-gray-400"
                    placeholder="Rp 0">

                <div class="flex flex-wrap gap-2">
                    <template x-for="nominal in nominalOptions" :key="nominal">
                        <button @click="cashReceived = nominal"
                            class="px-5 py-2 bg-[#E5E5E5] rounded-full text-xs font-bold hover:bg-black hover:text-white transition-all"
                            x-text="formatPrice(nominal)">
                        </button>
                    </template>
                </div>

                <div class="bg-[#E5E5E5] p-5 rounded-2xl flex justify-between items-center">
                    <span class="text-lg font-bold text-[#828282]">Kembalian</span>
                    <span class="text-2xl font-black" x-text="formatPrice(change)"></span>
                </div>
            </div>

            <div x-show="paymentMethod === 'QRIS'" x-transition
                class="flex flex-col items-center justify-center p-8 bg-[#E5E5E5] rounded-[32px] space-y-4">
                <svg class="w-16 h-16 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                    <path d="M14 14h3v3h-3zM17 17h3v3h-3zM14 20h3v-3M20 14h-3v3"></path>
                </svg>
                <p class="text-xl font-bold text-center">Scan Qris untuk Melanjutkan Pembayaran</p>
            </div>

            <div x-show="paymentMethod === 'Debit'" x-transition
                class="flex flex-col items-center justify-center p-8 bg-[#E5E5E5] rounded-[32px] space-y-4">
                <svg class="w-16 h-16 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5">
                    <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                    <path d="M7 15h.01M11 15h2"></path>
                    <rect x="16" y="8" width="2" height="2" fill="currentColor"></rect>
                </svg>
                <p class="text-xl font-bold text-center">Insert Kartu untuk Melanjutkan</p>
            </div>

            <div class="flex gap-4 pt-4">
                <button @click="showPayment = false"
                    class="flex-1 py-4 bg-[#EDEDED] text-[#333] rounded-2xl font-bold hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button @click="confirmPayment()"
                    :disabled="paymentMethod === 'Tunai' && (cashReceived < total || cashReceived === 0)"
                    class="flex-1 py-4 bg-[#1A1A1A] text-white rounded-2xl font-bold hover:bg-black transition-all disabled:opacity-30">
                    Konfirmasi Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>