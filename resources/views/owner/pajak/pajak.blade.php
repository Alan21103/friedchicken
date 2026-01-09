@extends('owner.layouts.layouts')

@section('title', 'Kelola Pajak & Service Fee')

@section('content')
<div x-data="{ 
    pajak: 10, 
    serviceFee: 5, 
    subtotal: 100000, 
    showToast: false,

    changeValue(field, amount) {
        let current = parseFloat(this[field]) || 0;
        let newValue = current + amount;
        this[field] = Math.max(0, Math.min(100, newValue));
    },

    init() {
        const savedPajak = localStorage.getItem('proto_pajak');
        const savedService = localStorage.getItem('proto_service_fee');
        
        if (savedPajak !== null) this.pajak = parseFloat(savedPajak);
        if (savedService !== null) this.serviceFee = parseFloat(savedService);
    },

    saveToLocal() {
        localStorage.setItem('proto_pajak', this.pajak);
        localStorage.setItem('proto_service_fee', this.serviceFee);
        
        this.showToast = true;
        setTimeout(() => this.showToast = false, 3000);
    },

    formatRupiah(val) {
        if (isNaN(val)) val = 0;
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(val));
    }
}" x-init="init()" x-cloak>

    {{-- Header: Tipografi Premium --}}
    <div class="mb-10 text-left px-1">
        <h2 class="text-3xl font-black text-[#332B2B] tracking-tight">Pajak & Service Fee</h2>
        <p class="text-[#4A3F3F]/60 mt-1.5 text-base font-medium">Atur persentase biaya tambahan untuk setiap transaksi restoran</p>
    </div>

    {{-- Toast Notification: Kalem & Elegan --}}
    <div x-show="showToast" 
         class="fixed top-24 right-8 bg-[#332B2B] text-[#E6D5B8] px-8 py-4 rounded-2xl shadow-2xl z-50 flex items-center gap-4 border border-[#E6D5B8]/20"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-8"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-200">
        <div class="w-6 h-6 bg-[#E6D5B8] rounded-full flex items-center justify-center text-[#332B2B]">
            <i class="fa-solid fa-check text-[10px]"></i>
        </div>
        <span class="text-sm font-bold tracking-wide">Pengaturan Berhasil Diperbarui</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
        
        {{-- Card Pengaturan --}}
        <div class="bg-white p-12 rounded-[3rem] shadow-sm border border-[#E6D5B8]/30 relative overflow-hidden">
            <div class="flex items-start gap-5 mb-10">
                <div class="w-12 h-12 bg-[#E6D5B8]/30 rounded-2xl flex items-center justify-center text-[#332B2B]">
                    <i class="fa-solid fa-percent text-xl"></i>
                </div>
                <div>
                    <h3 class="font-black text-[#332B2B] text-xl tracking-tight">Pengaturan Persentase</h3>
                    <p class="text-sm text-[#4A3F3F]/50 mt-1 font-medium">Masukkan persentase pajak dan service fee yang akan diterapkan</p>
                </div>
            </div>

            <div class="space-y-8">
                {{-- Input Pajak --}}
                <div class="group">
                    <label class="block text-[10px] font-black text-[#332B2B] uppercase tracking-[0.2em] mb-3 ml-1">Pajak Pertambahan Nilai (PPN)</label>
                    <div class="relative flex items-center">
                        <input type="number" x-model.number="pajak" 
                            class="w-full px-6 py-4 bg-[#FDFCFB] border border-[#E6D5B8] rounded-2xl outline-none focus:border-[#332B2B] focus:ring-4 focus:ring-[#332B2B]/5 transition-all font-bold text-[#332B2B] pr-20">
                        
                        <div class="absolute right-4 flex items-center gap-3 border-l border-[#E6D5B8] pl-4">
                            <div class="flex flex-col gap-1">
                                <button @click="changeValue('pajak', 1)" class="text-[#4A3F3F]/40 hover:text-[#332B2B] transition-colors">
                                    <i class="fa-solid fa-chevron-up text-[10px]"></i>
                                </button>
                                <button @click="changeValue('pajak', -1)" class="text-[#4A3F3F]/40 hover:text-[#332B2B] transition-colors">
                                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                </button>
                            </div>
                            <span class="text-[#332B2B] font-black text-sm">%</span>
                        </div>
                    </div>
                </div>

                {{-- Input Service Fee --}}
                <div class="group">
                    <label class="block text-[10px] font-black text-[#332B2B] uppercase tracking-[0.2em] mb-3 ml-1">Service Fee (Biaya Layanan)</label>
                    <div class="relative flex items-center">
                        <input type="number" x-model.number="serviceFee" 
                            class="w-full px-6 py-4 bg-[#FDFCFB] border border-[#E6D5B8] rounded-2xl outline-none focus:border-[#332B2B] focus:ring-4 focus:ring-[#332B2B]/5 transition-all font-bold text-[#332B2B] pr-20">
                        
                        <div class="absolute right-4 flex items-center gap-3 border-l border-[#E6D5B8] pl-4">
                            <div class="flex flex-col gap-1">
                                <button @click="changeValue('serviceFee', 1)" class="text-[#4A3F3F]/40 hover:text-[#332B2B] transition-colors">
                                    <i class="fa-solid fa-chevron-up text-[10px]"></i>
                                </button>
                                <button @click="changeValue('serviceFee', -1)" class="text-[#4A3F3F]/40 hover:text-[#332B2B] transition-colors">
                                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                </button>
                            </div>
                            <span class="text-[#332B2B] font-black text-sm">%</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button @click="saveToLocal" 
                            class="bg-[#332B2B] text-[#E6D5B8] px-12 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#4A3F3F] transition shadow-lg shadow-[#332B2B]/20 active:scale-95 flex items-center gap-3">
                        <i class="fa-solid fa-floppy-disk text-sm"></i>
                        <span>Simpan Pengaturan</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Card Simulasi: Minimalis & Kalem --}}
        <div class="bg-[#FDFCFB] p-12 rounded-[3rem] border border-[#E6D5B8]/30 shadow-sm">
            <div class="flex items-start gap-5 mb-10">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#332B2B] shadow-sm">
                    <i class="fa-solid fa-calculator text-xl"></i>
                </div>
                <div>
                    <h3 class="font-black text-[#332B2B] text-xl tracking-tight">Simulasi Billing</h3>
                    <p class="text-sm text-[#4A3F3F]/50 mt-1 font-medium">Contoh penerapan pada pesanan pelanggan</p>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-[#E6D5B8]/20">
                <div class="space-y-5">
                    <div class="flex justify-between items-center group">
                        <span class="text-xs font-black text-[#4A3F3F]/40 uppercase tracking-widest">Subtotal Pesanan</span>
                        <div class="flex items-center gap-3 bg-[#FDFCFB] px-4 py-2 rounded-xl border border-transparent group-hover:border-[#E6D5B8] transition-all">
                            <span class="text-[#332B2B] font-bold text-xs">Rp</span>
                            <input type="number" x-model.number="subtotal" 
                                class="w-24 text-right bg-transparent border-none outline-none font-black text-[#332B2B] text-sm" placeholder="0">
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center text-[#4A3F3F]">
                        <span class="text-sm font-bold">Pajak (<span x-text="pajak || 0" class="text-[#332B2B]"></span>%)</span>
                        <span class="font-bold text-[#332B2B]" x-text="formatRupiah((subtotal || 0) * ((pajak || 0)/100))"></span>
                    </div>

                    <div class="flex justify-between items-center text-[#4A3F3F] pb-4">
                        <span class="text-sm font-bold">Biaya Layanan (<span x-text="serviceFee || 0" class="text-[#332B2B]"></span>%)</span>
                        <span class="font-bold text-[#332B2B]" x-text="formatRupiah((subtotal || 0) * ((serviceFee || 0)/100))"></span>
                    </div>

                    <div class="border-t border-dashed border-[#E6D5B8] pt-6 flex justify-between items-center">
                        <span class="font-black text-[#332B2B] text-sm uppercase tracking-[0.2em]">Total Tagihan</span>
                        <div class="text-right">
                            <span class="block text-[10px] text-[#4A3F3F]/40 font-black uppercase tracking-widest mb-1 text-right">Grand Total</span>
                            <span class="font-black text-[#332B2B] text-2xl tracking-tight" 
                                  x-text="formatRupiah( (parseFloat(subtotal) || 0) + ((subtotal || 0) * ((pajak || 0)/100)) + ((subtotal || 0) * ((serviceFee || 0)/100)) )">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex items-center gap-3 px-4 py-3 bg-[#E6D5B8]/20 rounded-2xl">
                <i class="fa-solid fa-circle-info text-[#332B2B] text-xs"></i>
                <p class="text-[11px] text-[#4A3F3F] font-medium leading-relaxed">
                    Nilai ini adalah simulasi. Persentase yang disimpan akan otomatis diterapkan pada modul Kasir dan Laporan Keuntungan.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection