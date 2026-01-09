@extends('owner.layouts.layouts')

@section('title', 'Kelola Predikat')

@section('content')
{{-- State Management Alpine.js --}}
<div x-data="{ 
    predicates: [], 
    search: '',
    openHapus: false,
    deleteId: null,
    
    init() {
        const saved = localStorage.getItem('my_predicates');
        this.predicates = saved ? JSON.parse(saved) : [];
    },

    get filteredPredicates() {
        if (this.search === '') return this.predicates;
        const keyword = this.search.toLowerCase();
        return this.predicates.filter(p => 
            p.nama.toLowerCase().includes(keyword) || 
            p.kategori.toLowerCase().includes(keyword) ||
            ('PR' + p.id).toLowerCase().includes(keyword)
        );
    },

    persiapanHapus(id) {
        this.deleteId = id;
        this.openHapus = true;
    },

    confirmHapus() {
        if (this.deleteId !== null) {
            this.predicates = this.predicates.filter(p => p.id !== this.deleteId);
            localStorage.setItem('my_predicates', JSON.stringify(this.predicates));
            this.openHapus = false;
            this.deleteId = null;
        }
    }
}" x-init="init()" x-cloak>
    
    {{-- Header --}}
    <div class="mb-8 px-1 text-left">
        <h1 class="text-2xl font-bold text-[#332B2B]">List Predikat</h1>
        <p class="text-sm text-[#4A3F3F]/60 mt-0.5 font-medium">Tambah, ubah, atau hapus Predikat Menu</p>
    </div>

    {{-- Toolbar Filter: Menggunakan warna Cream (#E6D5B8) --}}
    <div class="bg-[#E6D5B8] p-4 rounded-2xl flex justify-between items-center mb-8 shadow-sm">
        <div class="relative w-80">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#332B2B]/40">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </span>
            <input type="text" x-model="search"
                class="block w-full pl-11 pr-4 py-2.5 border-none rounded-xl text-sm bg-white/80 placeholder-[#4A3F3F]/40 focus:ring-2 focus:ring-[#332B2B]/20 outline-none transition font-medium" 
                placeholder="Cari ID, Nama, atau Kategori...">
        </div>
        
        <a href="{{ route('owner.predikat.create') }}" 
           class="bg-[#332B2B] text-[#E6D5B8] font-bold py-2.5 px-6 rounded-xl text-xs uppercase tracking-widest hover:bg-[#4A3F3F] transition flex items-center gap-2 shadow-md decoration-none">
            <i class="fa-solid fa-plus text-[10px]"></i>
            Tambah Predikat
        </a>
    </div>

    {{-- Table Section: Minimalis & Elegant --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-[#E6D5B8]/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black text-[#4A3F3F]/40 uppercase tracking-[0.2em] border-b border-[#E6D5B8]/20">
                        <th class="px-8 py-5">ID</th>
                        <th class="px-8 py-5">PREDIKAT</th>
                        <th class="px-8 py-5">KATEGORI</th>
                        <th class="px-8 py-5">JUMLAH MENU</th>
                        <th class="px-8 py-5 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E6D5B8]/10">
                    <template x-if="filteredPredicates.length === 0">
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <p class="text-[#4A3F3F]/30 text-xs font-bold uppercase tracking-widest">Tidak ada data predikat ditemukan</p>
                            </td>
                        </tr>
                    </template>

                    <template x-for="item in filteredPredicates" :key="item.id">
                        <tr class="hover:bg-[#FDFCFB] transition-colors duration-200">
                            <td class="px-8 py-5 text-sm font-black text-[#332B2B]" x-text="'PR' + item.id"></td>
                            <td class="px-8 py-5 text-sm">
                                <span class="bg-[#E6D5B8]/30 text-[#332B2B] px-3 py-1 rounded-lg font-bold text-xs border border-[#E6D5B8]/50" x-text="item.nama"></span>
                            </td>
                            <td class="px-8 py-5 text-sm text-[#4A3F3F] font-semibold" x-text="item.kategori"></td>
                            <td class="px-8 py-5 text-sm text-[#4A3F3F]/60 font-medium" x-text="item.menus.length + ' Produk'"></td>
                            <td class="px-8 py-5">
                                <div class="flex justify-center gap-3">
                                    <a :href="'/owner/predikat/' + item.id + '/edit'" 
                                       class="px-5 py-2 bg-[#E6D5B8]/40 text-[#332B2B] text-[11px] font-bold rounded-xl hover:bg-[#332B2B] hover:text-[#E6D5B8] transition shadow-sm text-center decoration-none">
                                        Ubah
                                    </a>
                                    <button @click="persiapanHapus(item.id)" 
                                            class="px-5 py-2 bg-red-50 text-red-400 text-[11px] font-bold rounded-xl hover:bg-red-500 hover:text-white transition shadow-sm border-none active:scale-95 cursor-pointer">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL HAPUS PREDIKAT --}}
    <div x-show="openHapus" 
         class="fixed inset-0 z-[110] flex items-center justify-center p-4"
         x-transition.opacity x-cloak>
        
        {{-- Backdrop dengan Blur --}}
        <div class="absolute inset-0 bg-[#332B2B]/60 backdrop-blur-sm" @click="openHapus = false"></div>

        {{-- Content Modal --}}
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden px-8 py-12 text-center border-none">
            <div class="w-20 h-20 bg-red-50 text-red-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                <i class="fa-solid fa-trash-can text-3xl"></i>
            </div>
            <h3 class="text-xl font-black text-[#332B2B] mb-2 tracking-tight">Hapus Predikat?</h3>
            <p class="text-[#4A3F3F]/60 mb-10 text-sm font-medium leading-relaxed px-4">Tindakan ini akan menghapus label predikat dari menu-menu terkait.</p>
            
            <div class="flex justify-center gap-3">
                <button @click="openHapus = false" class="flex-1 py-3.5 bg-white border border-[#E6D5B8] text-[#4A3F3F] rounded-xl text-[11px] font-black uppercase tracking-widest transition hover:bg-[#FDFCFB]">
                    Batal
                </button>
                <button @click="confirmHapus()" class="flex-1 py-3.5 bg-red-500 text-white rounded-xl text-[11px] font-black uppercase tracking-widest transition shadow-lg shadow-red-200">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>
@endsection