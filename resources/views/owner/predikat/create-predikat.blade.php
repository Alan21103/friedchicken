@extends('owner.layouts.layouts')

@section('title', content: 'Tambah Predikat')

@section('content')
{{-- SEMUA CUSTOM CSS DISATUKAN DI SINI --}}
<style>
    /* 1. Menghilangkan spinner bawaan browser pada input number */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }

    /* 2. Styling scrollbar agar minimalis & premium */
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #E6D5B8;
        border-radius: 20px;
    }
</style>

<div class="max-w-7xl mx-auto" 
     x-data="{ 
        categories: [], 
        allMenus: [], 
        selectedMenus: [], 
        newPredicate: {
            nama: '',
            kategori: '',
        },

        // State untuk kontrol dropdown kustom
        catDropdownOpen: false,
        menuDropdownOpen: false,

        init() {
            // Ambil data Kategori dari Local Storage
            const savedCats = localStorage.getItem('my_categories');
            this.categories = savedCats ? JSON.parse(savedCats) : [];

            // Ambil data Menu dari Local Storage
            const savedMenus = localStorage.getItem('my_menus');
            this.allMenus = savedMenus ? JSON.parse(savedMenus) : [];
        },

        // Logika filter menu berdasarkan kategori yang dipilih
        get filteredMenus() {
            if (!this.newPredicate.kategori) return [];
            const selectedCat = this.newPredicate.kategori.toLowerCase().trim();
            return this.allMenus.filter(m => {
                const menuCat = (m.kategori || '').toLowerCase().trim();
                return menuCat === selectedCat;
            });
        },

        selectCategory(catName) {
            this.newPredicate.kategori = catName;
            this.selectedMenus = [];
            this.catDropdownOpen = false;
        },

        addMenu(menuName) {
            if (menuName && !this.selectedMenus.includes(menuName)) {
                this.selectedMenus.push(menuName);
            }
            this.menuDropdownOpen = false;
        },

        removeMenu(index) {
            this.selectedMenus.splice(index, 1);
        },

        simpan() {
            if(!this.newPredicate.nama || !this.newPredicate.kategori) {
                return alert('Nama Predikat dan Kategori wajib diisi!');
            }
            if(this.selectedMenus.length === 0) {
                return alert('Pilih minimal satu menu!');
            }

            const savedPredicates = localStorage.getItem('my_predicates');
            let predicates = savedPredicates ? JSON.parse(savedPredicates) : [];
            const newId = (predicates.length + 1).toString().padStart(3, '0');

            predicates.push({
                id: newId,
                nama: this.newPredicate.nama,
                kategori: this.newPredicate.kategori,
                menus: this.selectedMenus
            });

            localStorage.setItem('my_predicates', JSON.stringify(predicates));
            window.location.href = '{{ route('owner.predikat.index') }}';
        }
     }" x-init="init()" x-cloak>
    
    {{-- Breadcrumb --}}
    <nav class="flex text-[10px] text-[#4A3F3F]/40 mb-3 gap-2 items-center px-1 uppercase tracking-widest font-bold">
        <a href="{{ route('owner.predikat.index') }}" class="hover:text-[#332B2B] transition">Kelola Predikat</a>
        <span class="opacity-30">/</span>
        <span class="text-[#332B2B]">Tambah Predikat</span>
    </nav>

    {{-- Header --}}
    <div class="flex justify-between items-end mb-10 px-1">
        <div class="text-left">
            <h1 class="text-3xl font-black text-[#332B2B] tracking-tight">Tambah Predikat</h1>
            <p class="text-sm text-[#4A3F3F]/60 mt-1 font-medium">Buat label khusus untuk kelompok menu pilihan Anda</p>
        </div>
        <button @click="simpan()" 
            class="flex items-center gap-3 bg-[#332B2B] text-[#E6D5B8] px-8 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#4A3F3F] transition shadow-lg shadow-[#332B2B]/20 active:scale-95 border-none cursor-pointer">
            <i class="fa-regular fa-floppy-disk text-sm"></i>
            <span>Simpan Data</span>
        </button>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-[3rem] shadow-sm border border-[#E6D5B8]/30 p-14 relative overflow-hidden">
        {{-- Dekorasi Aksen --}}
        <div class="absolute top-0 right-0 w-32 h-32 bg-[#E6D5B8]/10 rounded-full -mr-16 -mt-16"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-12 text-left relative z-10">
            
            {{-- Nama Predikat --}}
            <div class="flex flex-col gap-3">
                <label class="text-[10px] font-black text-[#332B2B] uppercase tracking-[0.2em] ml-1">Nama Predikat</label>
                <input type="text" x-model="newPredicate.nama" placeholder="Misal: Rekomendasi Owner" 
                    class="w-full px-6 py-4 rounded-2xl border border-[#E6D5B8] focus:ring-4 focus:ring-[#332B2B]/5 focus:border-[#332B2B] outline-none transition text-[#332B2B] font-bold placeholder-[#4A3F3F]/30 text-sm">
            </div>

            {{-- Custom Dropdown Kategori Dasar --}}
            <div class="flex flex-col gap-3">
                <label class="text-[10px] font-black text-[#332B2B] uppercase tracking-[0.2em] ml-1">Pilih Kategori Dasar</label>
                <div class="relative">
                    <button @click="catDropdownOpen = !catDropdownOpen" @click.away="catDropdownOpen = false"
                        class="w-full px-6 py-4 rounded-2xl border border-[#E6D5B8] flex justify-between items-center bg-white hover:border-[#332B2B] transition group shadow-sm">
                        <span class="text-sm font-bold" :class="newPredicate.kategori ? 'text-[#332B2B]' : 'text-[#4A3F3F]/30'" x-text="newPredicate.kategori || 'Pilih Kategori'"></span>
                        <i class="fa-solid fa-chevron-down text-[#332B2B]/30 text-[10px] transition-transform duration-300" :class="catDropdownOpen ? 'rotate-180' : ''"></i>
                    </button>

                    {{-- Options List Kategori --}}
                    <div x-show="catDropdownOpen" x-transition 
                        class="absolute z-50 w-full mt-2 bg-white border border-[#E6D5B8] rounded-2xl shadow-xl py-2 max-h-[200px] overflow-y-auto custom-scrollbar">
                        <template x-for="cat in categories" :key="cat.id">
                            <button @click="selectCategory(cat.nama)" 
                                class="w-full text-left px-6 py-3 text-sm font-bold text-[#332B2B] hover:bg-[#332B2B] hover:text-[#E6D5B8] transition-colors">
                                <span x-text="cat.nama"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Custom Dropdown Pilih Menu (Bisa Scroll) --}}
            <div class="flex flex-col gap-3 md:col-span-2">
                <label class="text-[10px] font-black text-[#332B2B] uppercase tracking-[0.2em] ml-1">Pilih Menu yang Termasuk</label>
                <div class="relative">
                    <button @click="if(newPredicate.kategori) menuDropdownOpen = !menuDropdownOpen" @click.away="menuDropdownOpen = false"
                        :disabled="!newPredicate.kategori"
                        class="w-full px-6 py-4 rounded-2xl border border-[#E6D5B8] flex justify-between items-center transition bg-white disabled:bg-[#FDFCFB] disabled:cursor-not-allowed shadow-sm">
                        <span class="text-sm font-bold text-[#4A3F3F]/30" x-text="!newPredicate.kategori ? 'Tentukan kategori terlebih dahulu...' : 'Cari menu untuk ditambahkan' "></span>
                        <i class="fa-solid fa-plus text-[#332B2B]/30 text-xs"></i>
                    </button>

                    {{-- Options List Menu --}}
                    <div x-show="menuDropdownOpen" x-transition 
                        class="absolute z-50 w-full mt-2 bg-white border border-[#E6D5B8] rounded-2xl shadow-xl py-2 max-h-[250px] overflow-y-auto custom-scrollbar">
                        <template x-for="menu in filteredMenus" :key="menu.nama">
                            <button @click="addMenu(menu.nama)" 
                                :disabled="selectedMenus.includes(menu.nama)"
                                class="w-full text-left px-6 py-3 text-sm font-bold text-[#332B2B] hover:bg-[#332B2B] hover:text-[#E6D5B8] transition-colors disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-[#332B2B]">
                                <div class="flex justify-between items-center">
                                    <span x-text="menu.nama"></span>
                                    <i x-show="selectedMenus.includes(menu.nama)" class="fa-solid fa-check text-[10px]"></i>
                                </div>
                            </button>
                        </template>
                        <template x-if="filteredMenus.length === 0">
                            <div class="px-6 py-4 text-center text-xs text-[#4A3F3F]/30 font-bold uppercase tracking-widest">
                                Tidak ada menu tersedia
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Tags Menu: List yang terpilih --}}
        <div class="mt-14 pt-10 border-t border-[#E6D5B8]/20 text-left">
            <label class="text-[10px] font-black text-[#4A3F3F]/40 uppercase tracking-[0.2em] mb-6 block">Menu Terpilih (<span x-text="selectedMenus.length"></span>)</label>
            
            <div class="flex flex-wrap gap-4 min-h-[60px]">
                <template x-for="(menuName, index) in selectedMenus" :key="index">
                    <div class="flex items-center gap-4 border border-[#E6D5B8] rounded-2xl px-5 py-3 bg-[#FDFCFB] group animate-in fade-in zoom-in duration-300 hover:border-[#332B2B] transition-colors shadow-sm">
                        <span class="text-xs font-bold text-[#332B2B]" x-text="menuName"></span>
                        <button type="button" @click="removeMenu(index)" 
                            class="text-[#4A3F3F]/40 hover:text-red-500 transition border-none bg-transparent cursor-pointer">
                            <i class="fa-solid fa-circle-xmark text-sm"></i>
                        </button>
                    </div>
                </template>
                
                <template x-if="selectedMenus.length === 0">
                    <div class="w-full py-8 border-2 border-dashed border-[#E6D5B8]/30 rounded-3xl flex items-center justify-center">
                        <p class="text-[#4A3F3F]/30 text-xs font-bold uppercase tracking-widest italic">Belum ada menu yang dikaitkan</p>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
@endsection