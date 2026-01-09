@extends('owner.layouts.layouts')

@section('title', 'Kelola Kategori')

@section('content')
{{-- State Management Alpine.js --}}
<div x-data="{ 
    openTambah: false, 
    openHapus: false,
    isEdit: false,
    search: '',
    deleteId: null,
    
    currentPage: 1,
    itemsPerPage: 6,

    categories: [], 
    newCategory: {
        id: '',
        nama: '',
        deskripsi: ''
    },

    init() {
        const saved = localStorage.getItem('my_categories');
        this.categories = saved ? JSON.parse(saved) : [];
    },

    saveToStorage() {
        localStorage.setItem('my_categories', JSON.stringify(this.categories));
    },

    get filteredCategories() {
        if (this.search === '') return this.categories;
        return this.categories.filter(c => 
            c.nama.toLowerCase().includes(this.search.toLowerCase())
        );
    },

    get paginatedCategories() {
        let start = (this.currentPage - 1) * this.itemsPerPage;
        let end = start + this.itemsPerPage;
        return this.filteredCategories.slice(start, end);
    },

    get totalPages() {
        return Math.ceil(this.filteredCategories.length / this.itemsPerPage) || 1;
    },

    editKategori(cat) {
        this.isEdit = true;
        this.newCategory = { ...cat };
        this.openTambah = true;
    },

    simpanKategori() {
        if(!this.newCategory.nama) return alert('Nama kategori wajib diisi!');
        
        if (this.isEdit) {
            const index = this.categories.findIndex(c => c.id === this.newCategory.id);
            if (index !== -1) {
                this.categories[index] = { ...this.newCategory };
            }
        } else {
            const newId = (this.categories.length + 1).toString().padStart(3, '0');
            this.categories.push({
                id: newId,
                nama: this.newCategory.nama,
                deskripsi: this.newCategory.deskripsi || '-'
            });
            this.currentPage = this.totalPages;
        }
        
        this.saveToStorage();
        this.resetForm();
    },

    resetForm() {
        this.newCategory = { id: '', nama: '', deskripsi: '' };
        this.isEdit = false;
        this.openTambah = false;
    },

    hapusKategori(id) {
        this.deleteId = id;
        this.openHapus = true;
    },

    confirmHapus() {
        if (this.deleteId !== null) {
            this.categories = this.categories.filter(c => c.id !== this.deleteId);
            this.saveToStorage();
            this.openHapus = false;
            this.deleteId = null;
            
            if (this.paginatedCategories.length === 0 && this.currentPage > 1) {
                this.currentPage--;
            }
        }
    }
}" x-init="init()" x-cloak>

    {{-- Header --}}
    <div class="mb-8 text-left px-1">
        <h2 class="text-2xl font-bold text-[#332B2B]">List Kategori</h2>
        <p class="text-[#4A3F3F]/60 mt-0.5 text-sm font-medium">Tambah, ubah, atau hapus Kategori Menu</p>
    </div>

    {{-- Toolbar Filter: Warna Cream (#E6D5B8) --}}
    <div class="bg-[#E6D5B8] p-4 rounded-2xl flex items-center justify-between mb-8 shadow-sm">
        <div class="relative w-full max-w-[320px]">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#332B2B]/40">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </div>
            <input 
                type="text" 
                x-model="search"
                @input="currentPage = 1"
                placeholder="Cari nama kategori..." 
                class="block w-full pl-10 pr-3 py-2.5 bg-white/80 border-none rounded-xl text-sm focus:ring-2 focus:ring-[#332B2B]/20 outline-none placeholder-[#4A3F3F]/40 font-medium transition"
            >
        </div>

        <button @click="resetForm(); openTambah = true" 
            class="bg-[#332B2B] text-[#E6D5B8] font-bold py-2.5 px-6 rounded-xl hover:bg-[#4A3F3F] flex items-center gap-2 transition active:scale-95 text-sm shadow-md">
            <i class="fa-solid fa-plus text-xs"></i> 
            <span>Tambah Kategori</span>
        </button>
    </div>

    {{-- Grid Kategori --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-if="filteredCategories.length === 0">
            <div class="col-span-full py-24 border-2 border-dashed border-[#E6D5B8] rounded-[3rem] flex flex-col items-center justify-center opacity-60">
                <div class="w-20 h-20 bg-[#E6D5B8]/30 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-shapes text-3xl text-[#332B2B]/30"></i>
                </div>
                <h3 class="text-[#332B2B] font-bold">Data Tidak Ditemukan</h3>
                <p class="text-[#4A3F3F] text-xs mt-1">Belum ada kategori yang ditambahkan.</p>
            </div>
        </template>

        <template x-for="cat in paginatedCategories" :key="cat.id">
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-[#E6D5B8]/30 relative group hover:shadow-xl hover:translate-y-[-4px] transition-all duration-300">
                <div class="absolute top-6 right-8">
                    <span class="bg-[#332B2B] text-[#E6D5B8] text-[9px] px-3.5 py-1.5 rounded-lg font-black uppercase tracking-widest shadow-sm" x-text="'ID #' + cat.id"></span>
                </div>

                <div class="space-y-5 mb-10 mt-4 text-left">
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-black text-[#E6D5B8] uppercase tracking-[0.2em]">Nama Kategori</span>
                        <span class="text-lg font-bold text-[#332B2B] leading-tight" x-text="cat.nama"></span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-black text-[#E6D5B8] uppercase tracking-[0.2em]">Deskripsi</span>
                        <span class="text-xs text-[#4A3F3F] font-medium leading-relaxed opacity-80" x-text="cat.deskripsi"></span>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <button @click="editKategori(cat)" class="flex-1 bg-[#E6D5B8]/20 text-[#332B2B] px-5 py-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 hover:bg-[#332B2B] hover:text-[#E6D5B8] transition active:scale-95 shadow-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Ubah</span>
                    </button>
                    <button @click="hapusKategori(cat.id)"
                            class="flex-1 bg-red-50 text-red-400 px-5 py-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 hover:bg-red-500 hover:text-white transition active:scale-95 shadow-sm">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Hapus</span>
                    </button>
                </div>
            </div>
        </template>
    </div>

    {{-- Pagination UI --}}
    <div class="mt-12 flex justify-between items-center" x-show="filteredCategories.length > 0">
        <p class="text-xs text-[#4A3F3F]/40 font-bold uppercase tracking-widest" 
           x-text="'Menampilkan ' + (((currentPage-1)*itemsPerPage)+1) + '-' + Math.min(currentPage*itemsPerPage, filteredCategories.length) + ' dari ' + filteredCategories.length">
        </p>

        <div class="flex items-center gap-2">
            <button @click="if(currentPage > 1) currentPage--" 
                class="w-10 h-10 flex items-center justify-center bg-white rounded-xl border border-[#E6D5B8]/50 text-[#332B2B] hover:bg-[#E6D5B8]/20 transition disabled:opacity-30 shadow-sm"
                :disabled="currentPage === 1">
                <i class="fa-solid fa-chevron-left text-[10px]"></i>
            </button>

            <template x-for="p in totalPages" :key="p">
                <button @click="currentPage = p" 
                    class="w-10 h-10 flex items-center justify-center rounded-xl font-black text-xs transition shadow-sm"
                    :class="currentPage === p ? 'bg-[#332B2B] text-[#E6D5B8]' : 'bg-white border border-[#E6D5B8]/50 text-[#4A3F3F] hover:bg-[#E6D5B8]/20'"
                    x-text="p">
                </button>
            </template>

            <button @click="if(currentPage < totalPages) currentPage++" 
                class="w-10 h-10 flex items-center justify-center bg-white rounded-xl border border-[#E6D5B8]/50 text-[#332B2B] hover:bg-[#E6D5B8]/20 transition disabled:opacity-30 shadow-sm"
                :disabled="currentPage === totalPages">
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </button>
        </div>
    </div>

    {{-- MODAL TAMBAH/UBAH --}}
    <div x-show="openTambah" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-transition.opacity x-cloak>
        <div class="absolute inset-0 bg-[#332B2B]/60 backdrop-blur-sm" @click="resetForm()"></div>
        <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl relative z-10 p-10 overflow-hidden">
            <button @click="resetForm()" class="absolute top-8 right-10 text-[#332B2B] hover:opacity-50 transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <div class="mb-8 text-left">
                <span class="bg-[#332B2B] text-[#E6D5B8] px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] shadow-md">
                    <span x-text="isEdit ? 'Ubah Kategori' : 'Tambah Kategori'"></span>
                </span>
            </div>

            <div class="space-y-6">
                <div class="text-left">
                    <label class="block text-[10px] font-black text-[#332B2B] uppercase tracking-[0.2em] mb-2 ml-1">Nama Kategori</label>
                    <input type="text" x-model="newCategory.nama" placeholder="Contoh: Makanan Berat"
                        class="w-full border border-[#E6D5B8] rounded-xl px-5 py-3.5 text-sm focus:border-[#332B2B] focus:ring-4 focus:ring-[#332B2B]/5 outline-none transition font-medium">
                </div>
                <div class="text-left">
                    <label class="block text-[10px] font-black text-[#332B2B] uppercase tracking-[0.2em] mb-2 ml-1">Deskripsi Singkat</label>
                    <textarea x-model="newCategory.deskripsi" rows="4" placeholder="Jelaskan kelompok menu ini..."
                        class="w-full border border-[#E6D5B8] rounded-xl px-5 py-3.5 text-sm focus:border-[#332B2B] focus:ring-4 focus:ring-[#332B2B]/5 outline-none resize-none transition font-medium"></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-6">
                    <button @click="resetForm()" class="flex-1 py-3.5 bg-white border border-[#E6D5B8] text-[#4A3F3F] rounded-xl text-[11px] font-black uppercase tracking-widest transition hover:bg-[#FDFCFB]">Batal</button>
                    <button @click="simpanKategori()" class="flex-1 py-3.5 bg-[#332B2B] text-[#E6D5B8] rounded-xl text-[11px] font-black uppercase tracking-widest transition shadow-lg hover:bg-[#4A3F3F]">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL HAPUS --}}
    <div x-show="openHapus" class="fixed inset-0 z-[110] flex items-center justify-center p-4" x-transition.opacity x-cloak>
        <div class="absolute inset-0 bg-[#332B2B]/60 backdrop-blur-sm" @click="openHapus = false"></div>
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl relative z-10 px-8 py-12 text-center">
            <div class="w-20 h-20 bg-red-50 text-red-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                <i class="fa-solid fa-trash-can text-3xl"></i>
            </div>
            <h3 class="text-xl font-black text-[#332B2B] mb-2 tracking-tight">Hapus Kategori?</h3>
            <p class="text-[#4A3F3F]/60 mb-10 text-sm font-medium leading-relaxed px-4 text-center">Menghapus kategori ini dapat mempengaruhi menu yang terkait.</p>
            
            <div class="flex justify-center gap-3">
                <button @click="openHapus = false" class="flex-1 py-3.5 bg-white border border-[#E6D5B8] text-[#4A3F3F] rounded-xl text-[11px] font-black uppercase tracking-widest transition hover:bg-[#FDFCFB]">Batal</button>
                <button @click="confirmHapus()" class="flex-1 py-3.5 bg-red-500 text-white rounded-xl text-[11px] font-black uppercase tracking-widest transition shadow-lg shadow-red-200">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection