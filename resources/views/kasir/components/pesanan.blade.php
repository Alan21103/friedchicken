<div class="w-[380px] bg-[#E5E5E5] border-l flex flex-col shadow-2xl flex-shrink-0 h-screen"
    x-data="{ 
        cart: [], // Data ini biasanya diisi dari pilihan menu
        taxRate: 0,
        serviceRate: 0,
        orderType: 'Dine In',
        showPayment: false,

        // Inisialisasi: Ambil data dari Owner (LocalStorage)
        init() {
            this.taxRate = parseFloat(localStorage.getItem('proto_pajak')) || 0;
            this.serviceRate = parseFloat(localStorage.getItem('proto_service_fee')) || 0;

            // Listener agar sinkron otomatis jika Owner mengubah data di tab sebelah
            window.addEventListener('storage', () => {
                this.taxRate = parseFloat(localStorage.getItem('proto_pajak')) || 0;
                this.serviceRate = parseFloat(localStorage.getItem('proto_service_fee')) || 0;
            });
        },

        // Logika Perhitungan Dinamis
        get subtotal() {
            return this.cart.reduce((sum, item) => sum + (item.harga * item.qty), 0);
        },
        get taxAmount() {
            return this.subtotal * (this.taxRate / 100);
        },
        get serviceAmount() {
            return this.subtotal * (this.serviceRate / 100);
        },
        get total() {
            return this.subtotal + this.taxAmount + this.serviceAmount;
        },

        // Helper Fungsi
        updateQty(id, change) {
            const item = this.cart.find(i => i.id === id);
            if (item) {
                item.qty += change;
                if (item.qty <= 0) {
                    this.cart = this.cart.filter(i => i.id !== id);
                }
            }
        },
        formatPrice(val) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(val));
        }
    }">

    <div class="p-6 bg-[#F3F3F3]/80 backdrop-blur-md flex-shrink-0">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                <h2 class="text-xl font-bold text-[#1A1A1A]">Pesanan</h2>
            </div>

            <div class="bg-[#737D8C] text-white text-[12px] w-7 h-7 rounded-full flex items-center justify-center font-bold shadow-sm"
                x-show="cart.length > 0" x-cloak x-text="cart.length">
            </div>
        </div>

        <div class="bg-[#737D8C]/20 p-1.5 rounded-xl flex gap-1">
            <button @click="orderType = 'Dine In'"
                :class="orderType === 'Dine In' ? 'bg-white text-[#1A1A1A] shadow-sm' : 'text-[#4D4D4D]'"
                class="flex-1 py-2 rounded-lg font-bold text-xs transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2 2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                Dine in
            </button>
            <button @click="orderType = 'Take Away'"
                :class="orderType === 'Take Away' ? 'bg-[#3E4756] text-white shadow-sm' : 'text-[#4D4D4D]'"
                class="flex-1 py-2 rounded-lg font-bold text-xs transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                    </path>
                </svg>
                Take away
            </button>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-4 space-y-4 custom-scrollbar bg-[#E5E5E5]">
        <template x-for="item in cart" :key="item.id">
            <div class="bg-[#D4D4D4] rounded-[24px] p-4 relative flex gap-4 items-start shadow-sm border border-black/5">
                <button @click="updateQty(item.id, -item.qty)"
                    class="absolute top-3 right-3 text-[#1A1A1A] opacity-60 hover:opacity-100 transition-opacity">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <div class="w-24 h-16 bg-[#737D8C] rounded-xl flex-shrink-0 flex items-center justify-center overflow-hidden">
                    <img :src="item.image" :alt="item.nama" class="w-full h-full object-cover">
                </div>

                <div class="flex-1 pt-1">
                    <h5 class="font-bold text-sm text-[#1A1A1A] mb-1" x-text="item.nama"></h5>
                    <div class="flex items-center bg-[#737D8C]/30 rounded-lg w-fit mb-2">
                        <button @click="updateQty(item.id, -1)" class="px-2 py-0.5 font-bold text-gray-700 hover:text-black">-</button>
                        <span class="text-xs font-bold px-2 border-x border-black/10 text-gray-800" x-text="item.qty"></span>
                        <button @click="updateQty(item.id, 1)" class="px-2 py-0.5 font-bold text-gray-700 hover:text-black">+</button>
                    </div>
                    <p class="text-[#1A1A1A] font-bold text-xs" x-text="formatPrice(item.harga * item.qty)"></p>
                </div>

                <div class="absolute bottom-4 right-4 bg-[#A6A6A6] px-2 py-1 rounded-full flex items-center gap-1">
                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-[8px] font-bold" x-text="item.kategori === 'Minuman' || item.kategori === 'Camilan' ? 'Cepat' : 'Butuh Waktu'"></span>
                </div>
            </div>
        </template>

        <template x-if="cart.length === 0">
            <div class="h-full flex flex-col items-center justify-center text-center opacity-30 py-20">
                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <p class="text-xs font-medium">Keranjang masih kosong</p>
            </div>
        </template>
    </div>

    <div class="p-6 pb-12 bg-[#F3F3F3] border-t border-black/5 space-y-3 flex-shrink-0">
        <div class="flex justify-between text-xs font-bold text-[#4D4D4D]">
            <span>Subtotal</span>
            <span x-text="formatPrice(subtotal)"></span>
        </div>
        <div class="flex justify-between text-xs font-bold text-[#4D4D4D]">
            <span>Pajak (<span x-text="taxRate"></span>%)</span>
            <span x-text="formatPrice(taxAmount)"></span>
        </div>
        <div class="flex justify-between text-xs font-bold text-[#4D4D4D]">
            <span>Service fee (<span x-text="serviceRate"></span>%)</span>
            <span x-text="formatPrice(serviceAmount)"></span>
        </div>

        <div class="pt-6 mt-4 border-t border-black/10 pb-10">
            <div class="flex justify-between items-center mb-6">
                <span class="text-2xl font-bold text-[#1A1A1A]">Total</span>
                <span class="text-2xl font-bold text-[#1A1A1A]" x-text="formatPrice(total)"></span>
            </div>

            <button @click="showPayment = true" :disabled="cart.length === 0"
                class="w-full bg-[#D4D4D4] text-[#1A1A1A] py-4 rounded-full font-bold text-sm shadow-sm hover:bg-[#C4C4C4] disabled:opacity-50 transition-all active:scale-95">
                Bayar Sekarang
            </button>
        </div>
    </div>
</div>