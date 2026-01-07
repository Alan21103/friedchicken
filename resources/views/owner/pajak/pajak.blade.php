@extends('owner.layouts.layouts')

@section('title', 'Kelola Pajak & Service Fee')

@section('content')
<div x-data="{ 
    pajak: 10, 
    serviceFee: 5, 
    subtotal: 100000, {{-- Nilai awal 100rb agar simulasi langsung terlihat --}}
    showToast: false,

    // Fungsi untuk menambah atau mengurangi nilai
    changeValue(field, amount) {
        let current = parseFloat(this[field]) || 0;
        let newValue = current + amount;
        // Batasi nilai antara 0 sampai 100
        this[field] = Math.max(0, Math.min(100, newValue));
    },

    // Load data dari LocalStorage saat halaman dibuka
    init() {
        const savedPajak = localStorage.getItem('proto_pajak');
        const savedService = localStorage.getItem('proto_service_fee');
        
        if (savedPajak !== null) this.pajak = parseFloat(savedPajak);
        if (savedService !== null) this.serviceFee = parseFloat(savedService);
    },

    // Simpan data ke LocalStorage
    saveToLocal() {
        localStorage.setItem('proto_pajak', this.pajak);
        localStorage.setItem('proto_service_fee', this.serviceFee);
        
        // Tampilkan toast notification
        this.showToast = true;
        setTimeout(() => this.showToast = false, 3000);
    },

    formatRupiah(val) {
        if (isNaN(val)) val = 0;
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(val));
    }
}">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-700">Pajak & Service Fee</h2>
        <p class="text-base text-gray-500 mt-1">Atur persentase pajak dan service fee restoran</p>
    </div>

    <div x-show="showToast" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         class="fixed top-24 right-8 bg-slate-800 text-white px-6 py-3 rounded-xl shadow-xl z-50 flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-emerald-400"></i>
        <span class="text-sm font-medium">Pengaturan berhasil disimpan!</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        
        <div class="bg-white p-10 rounded-[2rem] shadow-sm border border-gray-100">
            <div class="flex items-start gap-4 mb-8">
                <div class="text-gray-600 mt-1">
                    <i class="fa-solid fa-percent text-2xl font-bold"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-700 text-xl">Pengaturan Persentase</h3>
                    <p class="text-sm text-gray-400 mt-1">Masukkan persentase pajak dan service fee yang akan diterapkan</p>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm text-gray-500 mb-2">Pajak (PPN)</label>
                    <div class="relative flex items-center">
                        <input type="number" x-model.number="pajak" 
                            class="w-full px-4 py-2 bg-white border border-gray-400 rounded-lg outline-none focus:border-slate-500 transition pr-14">
                        
                        <div class="absolute right-3 flex items-center gap-2">
                            <div class="flex flex-col text-[10px] text-gray-500">
                                <button @click="changeValue('pajak', 1)" class="hover:text-slate-800 transition leading-none">
                                    <i class="fa-solid fa-chevron-up"></i>
                                </button>
                                <button @click="changeValue('pajak', -1)" class="hover:text-slate-800 transition leading-none mt-1">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                            </div>
                            <span class="text-gray-500 text-sm font-medium">%</span>
                        </div>
                    </div>
                    <p class="mt-2 text-[13px] text-gray-400 font-regular italic">Persentase pajak yang ditambahkan ke setiap transaksi</p>
                </div>

                <div>
                    <label class="block text-sm text-gray-500 mb-2">Service Fee (%)</label>
                    <div class="relative flex items-center">
                        <input type="number" x-model.number="serviceFee" 
                            class="w-full px-4 py-2 bg-white border border-gray-400 rounded-lg outline-none focus:border-slate-500 transition pr-14">
                        
                        <div class="absolute right-3 flex items-center gap-2">
                            <div class="flex flex-col text-[10px] text-gray-500">
                                <button @click="changeValue('serviceFee', 1)" class="hover:text-slate-800 transition leading-none">
                                    <i class="fa-solid fa-chevron-up"></i>
                                </button>
                                <button @click="changeValue('serviceFee', -1)" class="hover:text-slate-800 transition leading-none mt-1">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                            </div>
                            <span class="text-gray-500 text-sm font-medium">%</span>
                        </div>
                    </div>
                    <p class="mt-2 text-[13px] text-gray-400 font-regular italic">Persentase biaya layanan yang ditambahkan ke setiap transaksi</p>
                </div>

                <div class="flex justify-end pt-6">
                    <button @click="saveToLocal" 
                            class="bg-[#8E97A2] hover:bg-slate-500 text-white px-16 py-3 rounded-lg font-medium flex items-center justify-center gap-2 transition shadow-sm text-base min-w-[180px]">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Save</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white p-10 rounded-[2rem] shadow-sm border border-gray-100">
            <div class="flex items-start gap-4 mb-8">
                <div class="text-gray-600 mt-1">
                    <i class="fa-solid fa-circle-info text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-700 text-xl">Contoh Perhitungan</h3>
                    <p class="text-sm text-gray-400 mt-1 text-balance">Simulasi penerapan pajak dan service fee</p>
                </div>
            </div>

            <div class="border border-gray-400 rounded-2xl p-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="text-base font-medium">Subtotal</span>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-400 font-medium">Rp</span>
                            <input type="number" x-model.number="subtotal" 
                                class="w-28 text-right bg-transparent border-b border-gray-300 outline-none focus:border-slate-500 font-bold text-gray-800" placeholder="0">
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="text-base font-medium">Pajak (<span x-text="pajak || 0"></span>%)</span>
                        <span class="font-bold text-gray-800" x-text="formatRupiah((subtotal || 0) * ((pajak || 0)/100))"></span>
                    </div>

                    <div class="flex justify-between items-center text-gray-600 pb-2">
                        <span class="text-base font-medium">Service Fee (<span x-text="serviceFee || 0"></span>%)</span>
                        <span class="font-bold text-gray-800" x-text="formatRupiah((subtotal || 0) * ((serviceFee || 0)/100))"></span>
                    </div>

                    <div class="border-t border-gray-400"></div>

                    <div class="flex justify-between items-center pt-1">
                        <span class="font-bold text-gray-700 text-xl uppercase">Total</span>
                        <span class="font-bold text-gray-800 text-xl" 
                              x-text="formatRupiah( (parseFloat(subtotal) || 0) + ((subtotal || 0) * ((pajak || 0)/100)) + ((subtotal || 0) * ((serviceFee || 0)/100)) )">
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection