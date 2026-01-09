@extends('owner.layouts.layouts')

@section('title', content: 'Edit Predikat')

@section('content')
{{-- SEMUA CUSTOM CSS DISATUKAN DI SINI --}}
<style>
    /* 1. Menghilangkan spinner bawaan browser pada input number */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }

    /* 2. Styling scrollbar agar minimalis & kalem */
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #E6D5B8;
        border-radius: 10px;
    }
</style>

<div class="max-w-7xl mx-auto" 
     x-data="{ 
        idPredikat: '{{ $id }}',
        categories: [], 
        allMenus: [], 
        selectedMenus: [], 
        editPredicate: {
            nama: '',
            kategori: '',
        },

        // State Dropdown
        catOpen: false,
        menuOpen: false,

        init() {
            const savedCats = localStorage.getItem('my_categories');
            this.categories = savedCats ? JSON.parse(savedCats) : [];

            const savedMenus = localStorage.getItem('my_menus');
            this.allMenus = savedMenus ? JSON.parse(savedMenus) : [];

            const savedPreds = localStorage.getItem('my_predicates');
            if (savedPreds) {
                const predicates = JSON.parse(savedPreds);
                const found = predicates.find(p => p.id === this.idPredikat);
                if (found) {
                    this.editPredicate.nama = found.nama;
                    this.editPredicate.kategori = found.kategori;
                    this.selectedMenus = [...found.menus];
                }
            }
        },

        get filteredMenus() {
            if (!this.editPredicate.kategori) return [];
            const selectedCat = this.editPredicate.kategori.toLowerCase().trim();
            return this.allMenus.filter(menu => {
                const menuCat = (menu.kategori || '').toLowerCase().trim();
                return menuCat === selectedCat;
            });
        },

        selectCategory(catName) {
            this.editPredicate.kategori = catName;
            this.selectedMenus = [];
            this.catOpen = false;
        },

        addMenu(menuName) {
            if (menuName && !this.selectedMenus.includes(menuName)) {
                this.selectedMenus.push(menuName);
            }
            this.menuOpen = false;
        },

        removeMenu(index) {
            this.selectedMenus.splice(index, 1);
        },

        update() {
            if(!this.editPredicate.nama || !this.editPredicate.kategori) {
                return alert('Nama Predikat dan Kategori wajib diisi!');
            }
            if(this.selectedMenus.length === 0) {
                return alert('Pilih minimal satu menu!');
            }

            const savedPredicates = localStorage.getItem('my_predicates');
            let predicates = savedPredicates ? JSON.parse(savedPredicates) : [];
            
            const index = predicates.findIndex(p => p.id === this.idPredikat);
            if (index !== -1) {
                predicates[index] = {
                    id: this.idPredikat,
                    nama: this.editPredicate.nama,
                    kategori: this.editPredicate.kategori,
                    menus: this.selectedMenus
                };

                localStorage.setItem('my_predicates', JSON.stringify(predicates));
                alert('Predikat berhasil diperbarui!');
                window.location.href = '{{ route('owner.predikat.index') }}';
            }
        }
     }" x-init="init()" x-cloak>
    
    {{-- Breadcrumb --}}
    <nav class="flex text-[10px] text-[#4A3F3F]/40 mb-3 gap-2 items-center px-1 uppercase tracking-widest font-bold">
        <a href="{{ route('owner.predikat.index') }}" class="hover:text-[#332B2B] transition">Kelola Predikat</a>
        <span class="opacity-30">/</span>
        <span class="text-[#332B2B]">Edit Predikat</span>
    </nav>

    {{-- Header --}}
    <div class="flex justify-between items-end mb-10 px-1">
        <div class="text-left">
            <h1 class="text-3xl font-black text-[#332B2B] tracking-tight">Edit Predikat</h1>
            <p class="text-sm text-[#4A3F3F]/60 mt-1 font-medium">Ubah informasi label untuk predikat <span class="font-bold text-[#332B2B]" x-text="'PR' + idPredikat"></span></p>
        </div>
        <button @click="update()" 
            class="flex items-center gap-3 bg-[#332B2B] text-[#E6D5B8] px-8 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#4A3F3F] transition shadow-lg shadow-[#332B2B]/20 active:scale-95 border-none cursor-pointer">
            <i class="fa-regular fa-floppy-disk text-sm"></i>
            <span>Simpan Perubahan</span>
        </button>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-[3rem] shadow-sm border border-[#E6D5B8]/30 p-14 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-[#E6D5B8]/10 rounded-full -mr-16 -mt-16"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-12 text-left relative z-10">
            
            {{-- Input Nama --}}
            <div class="flex flex-col gap-3">
                <label class="text-[10px] font-black text-[#332B2B] uppercase tracking-[0.2em] ml-1">Nama Predikat</label>
                <input type="text" x-model="editPredicate.nama"
                    class="w-full px-6 py-4 rounded-2xl border border-[#E6D5B8] focus:ring-4 focus:ring-[#332B2B]/5 focus:border-[#332B2B] outline-none transition text-[#332B2B] font-bold text-sm shadow-sm">
            </div>

            {{-- Dropdown Kategori Dasar --}}
            <div class="flex flex-col gap-3 relative">
                <label class="text-[10px] font-black text-[#332B2B] uppercase tracking-[0.2em] ml-1">Kategori Dasar</label>
                <button @click="catOpen = !catOpen" @click.away="catOpen = false"
                    class="w-full px-6 py-4 rounded-2xl border border-[#E6D5B8] bg-white flex justify-between items-center text-[#332B2B] font-bold text-sm">
                    <span x-text="editPredicate.kategori || 'Pilih Kategori'"></span>
                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="catOpen ? 'rotate-180' : ''"></i>
                </button>
                
                <div x-show="catOpen" x-transition 
                    class="absolute z-50 w-full mt-[85px] bg-white border border-[#E6D5B8] rounded-2xl shadow-xl overflow-hidden py-2 max-h-48 overflow-y-auto custom-scrollbar">
                    <template x-for="cat in categories" :key="cat.id">
                        <button @click="selectCategory(cat.nama)" 
                            class="w-full text-left px-6 py-3 text-sm font-bold text-[#332B2B] hover:bg-[#332B2B] hover:text-[#E6D5B8] transition">
                            <span x-text="cat.nama"></span>
                        </button>
                    </template>
                </div>
            </div>

            {{-- Dropdown Pilihan Menu (Bisa Scroll) --}}
            <div class="flex flex-col gap-3 md:col-span-2 relative">
                <label class="text-[10px] font-black text-[#332B2B] uppercase tracking-[0.2em] ml-1">Tambah Menu ke Predikat</label>
                <button @click="if(editPredicate.kategori) menuOpen = !menuOpen" @click.away="menuOpen = false"
                    :class="!editPredicate.kategori ? 'bg-[#FDFCFB] cursor-not-allowed opacity-50' : 'bg-white cursor-pointer'"
                    class="w-full px-6 py-4 rounded-2xl border border-[#E6D5B8] flex justify-between items-center text-[#332B2B] font-bold text-sm shadow-sm">
                    <span x-text="!editPredicate.kategori ? 'Tentukan kategori terlebih dahulu...' : 'Pilih menu untuk ditambahkan'"></span>
                    <i class="fa-solid fa-plus text-[#332B2B]/30 text-xs"></i>
                </button>

                <div x-show="menuOpen" x-transition 
                    class="absolute z-50 w-full mt-[85px] bg-white border border-[#E6D5B8] rounded-2xl shadow-xl overflow-hidden py-2 max-h-60 overflow-y-auto custom-scrollbar">
                    <template x-for="menu in filteredMenus" :key="menu.nama">
                        <button @click="addMenu(menu.nama)" 
                            :disabled="selectedMenus.includes(menu.nama)"
                            :class="selectedMenus.includes(menu.nama) ? 'opacity-30 cursor-not-allowed' : 'hover:bg-[#332B2B] hover:text-[#E6D5B8]'"
                            class="w-full text-left px-6 py-3 text-sm font-bold text-[#332B2B] transition flex justify-between items-center">
                            <span x-text="menu.nama"></span>
                            <i x-show="selectedMenus.includes(menu.nama)" class="fa-solid fa-check text-[10px]"></i>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        {{-- Section Badge Menu Terpilih --}}
        <div class="mt-14 pt-10 border-t border-[#E6D5B8]/20 text-left">
            <label class="text-[10px] font-black text-[#4A3F3F]/40 uppercase tracking-[0.2em] mb-6 block">Menu Terpilih (<span x-text="selectedMenus.length"></span>)</label>
            
            <div class="flex flex-wrap gap-4 min-h-[60px]">
                <template x-for="(menuName, index) in selectedMenus" :key="index">
                    <div class="flex items-center gap-4 border border-[#E6D5B8] rounded-2xl px-5 py-3 bg-[#FDFCFB] group animate-in fade-in zoom-in duration-300 hover:border-[#332B2B] transition-colors shadow-sm">
                        <span class="text-xs font-bold text-[#332B2B]" x-text="menuName"></span>
                        <button type="button" @click="removeMenu(index)" class="text-[#4A3F3F]/40 hover:text-red-500 transition border-none bg-transparent cursor-pointer">
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