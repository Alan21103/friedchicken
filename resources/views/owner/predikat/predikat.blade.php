@extends('owner.layouts.layouts')

@section('content')
{{-- State Management Alpine.js --}}
<div x-data="{ 
    predicates: [], 
    search: '',
    openHapus: false, {{-- State untuk modal hapus --}}
    deleteId: null,   {{-- Menyimpan ID yang akan dihapus --}}
    
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

    // 1. Membuka modal konfirmasi kustom
    persiapanHapus(id) {
        this.deleteId = id;
        this.openHapus = true;
    },

    // 2. Eksekusi hapus setelah konfirmasi di klik
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
    <div class="mb-6 px-1 text-left">
        <h1 class="text-2xl font-bold text-gray-800">List Predikat</h1>
        <p class="text-sm text-gray-500 mt-0.5 font-medium">Tambah, ubah, atau hapus Predikat Menu</p>
    </div>

    {{-- Toolbar Filter --}}
    <div class="bg-[#ACB5BD] p-3 rounded-xl flex justify-between items-center mb-6 shadow-sm">
        <div class="relative w-80">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </span>
            <input type="text" x-model="search"
                class="block w-full pl-10 pr-3 py-2 border-none rounded-lg text-sm bg-white placeholder-gray-400 focus:ring-2 focus:ring-gray-300 outline-none transition shadow-sm" 
                placeholder="Cari ID, Nama, atau Kategori...">
        </div>
        
        <a href="{{ route('owner.predikat.create') }}" 
           class="bg-white text-gray-800 font-bold py-2 px-6 rounded-lg text-sm hover:bg-gray-50 transition flex items-center gap-2 shadow-sm border-none decoration-none">
            <i class="fa-solid fa-plus text-xs"></i>
            Tambah Predikat
        </a>
    </div>

    {{-- Table Section --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[11px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">PREDIKAT</th>
                        <th class="px-6 py-4">KATEGORI</th>
                        <th class="px-6 py-4">MENU</th>
                        <th class="px-6 py-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <template x-for="item in filteredPredicates" :key="item.id">
                        <tr class="hover:bg-gray-50/50 transition duration-150">
                            <td class="px-6 py-4 text-sm font-bold text-gray-700" x-text="'PR' + item.id"></td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium" x-text="item.nama"></td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium" x-text="item.kategori"></td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium" x-text="item.menus.length + ' Menu'"></td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a :href="'/owner/predikat/' + item.id + '/edit'" 
                                       class="px-6 py-1.5 bg-[#8E959D] text-white text-[11px] font-bold rounded-lg hover:bg-gray-600 transition shadow-sm text-center decoration-none">
                                        Ubah
                                    </a>
                                    {{-- Tombol Hapus Sekarang Membuka Modal --}}
                                    <button @click="persiapanHapus(item.id)" 
                                            class="px-6 py-1.5 bg-[#8E959D] text-white text-[11px] font-bold rounded-lg hover:bg-red-500 transition shadow-sm border-none active:scale-95 cursor-pointer">
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

    {{-- MODAL HAPUS PREDIKAT (Desain Disamakan dengan Kelola Menu) --}}
    <div x-show="openHapus" 
         class="fixed inset-0 z-[110] flex items-center justify-center p-4"
         x-transition.opacity x-cloak>
        
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="openHapus = false"></div>

        {{-- Content Modal --}}
        <div class="bg-gray-100 w-full max-w-sm rounded-[1.5rem] shadow-xl relative z-10 overflow-hidden px-8 py-10 text-center border-none">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Hapus Predikat</h3>
            <p class="text-gray-700 mb-8 font-medium">Yakin untuk menghapus Predikat?</p>
            
            <div class="flex justify-center gap-4">
                <button @click="openHapus = false" class="px-8 py-2.5 bg-[#8E959D] text-white rounded-lg text-sm font-bold hover:bg-gray-500 transition active:scale-95 shadow-sm border-none outline-none">
                    Batal
                </button>
                <button @click="confirmHapus()" class="px-8 py-2.5 bg-[#8E959D] text-white rounded-lg text-sm font-bold hover:bg-red-500 transition active:scale-95 shadow-sm border-none outline-none">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>
@endsection