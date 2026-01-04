@extends('owner.layouts.layouts')

@section('content')
{{-- State Management Alpine.js --}}
<div x-data="{ 
    openTambah: false, 
    openHapus: false, // State untuk modal hapus kustom
    isEdit: false,
    search: '',
    deleteId: null, // Menyimpan ID kategori yang akan dihapus
    
    // PAGINATION STATE
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

    // 1. Membuka modal konfirmasi hapus kustom
    hapusKategori(id) {
        this.deleteId = id;
        this.openHapus = true;
    },

    // 2. Fungsi eksekusi hapus setelah dikonfirmasi
    confirmHapus() {
        if (this.deleteId !== null) {
            this.categories = this.categories.filter(c => c.id !== this.deleteId);
            this.saveToStorage();
            this.openHapus = false;
            this.deleteId = null;
            
            // Penyesuaian halaman jika data di halaman aktif habis
            if (this.paginatedCategories.length === 0 && this.currentPage > 1) {
                this.currentPage--;
            }
        }
    }
}" x-init="init()" x-cloak>

    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">List Kategori</h2>
        <p class="text-gray-500 mt-0.5 text-sm">Tambah, ubah, atau hapus Kategori Menu</p>
    </div>

    {{-- Toolbar Filter --}}
    <div class="bg-[#ACB5BD] p-4 rounded-xl flex items-center justify-between mb-6 shadow-sm">
        <div class="relative w-full max-w-[280px]">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </div>
            <input 
                type="text" 
                x-model="search"
                @input="currentPage = 1"
                placeholder="Cari Kategori..." 
                class="block w-full pl-10 pr-3 py-2 bg-white border-none rounded-lg text-sm focus:ring-2 focus:ring-gray-300 outline-none placeholder:text-gray-400 transition"
            >
        </div>

        <button @click="resetForm(); openTambah = true" class="bg-white text-gray-800 font-bold py-2 px-5 rounded-lg hover:bg-gray-50 flex items-center gap-2 transition active:scale-95 text-xs shadow-sm border-none">
            <i class="fa-solid fa-plus text-[10px]"></i> 
            <span>Tambah Kategori</span>
        </button>
    </div>

    {{-- Grid Kategori --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-if="filteredCategories.length === 0">
            <div class="col-span-full py-24 border-2 border-dashed border-gray-300 rounded-[2rem] flex flex-col items-center justify-center opacity-60">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-shapes text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-gray-500 font-bold">Data Tidak Ditemukan</h3>
                <p class="text-gray-400 text-xs mt-1">Belum ada kategori atau hasil pencarian tidak cocok.</p>
            </div>
        </template>

        <template x-for="cat in paginatedCategories" :key="cat.id">
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 relative group hover:shadow-md transition-all duration-300">
                <div class="absolute top-5 right-6">
                    <span class="bg-[#8E959D] text-white text-[9px] px-3 py-1 rounded-full font-bold uppercase tracking-tighter" x-text="'ID #' + cat.id"></span>
                </div>

                <div class="space-y-4 mb-8 mt-4 text-left">
                    <div class="flex items-start gap-1">
                        <span class="text-sm font-bold text-gray-800 whitespace-nowrap">Nama Kategori :</span>
                        <span class="text-sm text-gray-500 font-medium" x-text="cat.nama"></span>
                    </div>
                    <div class="flex items-start gap-1">
                        <span class="text-sm font-bold text-gray-800 whitespace-nowrap">Deskripsi :</span>
                        <span class="text-sm text-gray-500 font-medium" x-text="cat.deskripsi"></span>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <button @click="editKategori(cat)" class="bg-[#8E959D] text-white px-5 py-2 rounded-lg text-[11px] font-bold flex items-center gap-2 hover:bg-gray-500 transition active:scale-95 shadow-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Ubah</span>
                    </button>
                    {{-- TOMBOL HAPUS SEKARANG MEMBUKA MODAL KUSTOM --}}
                    <button @click="hapusKategori(cat.id)"
                            class="bg-[#8E959D] text-white px-5 py-2 rounded-lg text-[11px] font-bold flex items-center gap-2 hover:bg-red-500 transition active:scale-95 shadow-sm">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Hapus</span>
                    </button>
                </div>
            </div>
        </template>
    </div>

    {{-- Pagination UI --}}
    <div class="mt-12 flex justify-between items-center" x-show="filteredCategories.length > 0">
        <p class="text-xs text-gray-400 font-medium tracking-tight" 
           x-text="'Showing ' + (((currentPage-1)*itemsPerPage)+1) + '-' + Math.min(currentPage*itemsPerPage, filteredCategories.length) + ' of ' + filteredCategories.length + ' result'">
        </p>

        <div class="flex items-center gap-1.5">
            <button @click="if(currentPage > 1) currentPage--" 
                class="w-8 h-8 flex items-center justify-center bg-white rounded-md border border-gray-200 text-gray-400 hover:bg-gray-50 transition"
                :disabled="currentPage === 1">
                <i class="fa-solid fa-chevron-left text-[10px]"></i>
            </button>

            <template x-for="p in totalPages" :key="p">
                <button @click="currentPage = p" 
                    class="w-8 h-8 flex items-center justify-center rounded-md font-bold text-xs transition"
                    :class="currentPage === p ? 'bg-gray-900 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50'"
                    x-text="p">
                </button>
            </template>

            <button @click="if(currentPage < totalPages) currentPage++" 
                class="w-8 h-8 flex items-center justify-center bg-white rounded-md border border-gray-200 text-gray-400 hover:bg-gray-50 transition"
                :disabled="currentPage === totalPages">
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </button>
        </div>
    </div>

    {{-- MODAL TAMBAH/UBAH KATEGORI --}}
    <div x-show="openTambah" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-transition.opacity x-cloak>
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="resetForm()"></div>
        <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl relative z-10 p-8">
            <button @click="resetForm()" class="absolute top-6 right-8 text-gray-800 hover:opacity-50 transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <div class="mb-6 text-left">
                <span class="bg-[#8E959D] text-white px-5 py-2 rounded-lg text-xs font-bold uppercase tracking-wide">
                    <span x-text="isEdit ? 'Ubah Kategori' : 'Tambah Kategori'"></span>
                </span>
            </div>

            <div class="space-y-5">
                <div class="text-left">
                    <label class="block text-xs font-bold text-gray-800 mb-1.5 uppercase">Nama Kategori</label>
                    <input type="text" x-model="newCategory.nama" placeholder="Masukkan nama kategori..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:border-gray-500 outline-none transition">
                </div>
                <div class="text-left">
                    <label class="block text-xs font-bold text-gray-800 mb-1.5 uppercase">Deskripsi</label>
                    <textarea x-model="newCategory.deskripsi" rows="3" placeholder="Masukkan deskripsi..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:border-gray-500 outline-none resize-none transition"></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button @click="resetForm()" class="px-8 py-2.5 bg-[#ADB5BD] text-white rounded-lg text-xs font-bold shadow-sm active:scale-95 transition">Batal</button>
                    <button @click="simpanKategori()" class="px-8 py-2.5 bg-[#8E959D] text-white rounded-lg text-xs font-bold shadow-sm active:scale-95 transition">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL HAPUS KATEGORI (Kustom sesuai gambar referensi) --}}
    <div x-show="openHapus" 
         class="fixed inset-0 z-[110] flex items-center justify-center p-4"
         x-transition.opacity x-cloak>
        
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="openHapus = false"></div>

        <div class="bg-gray-100 w-full max-w-sm rounded-[1.5rem] shadow-xl relative z-10 overflow-hidden px-8 py-10 text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Hapus Kategori</h3>
            <p class="text-gray-700 mb-8 font-medium">Yakin untuk menghapus Kategori?</p>
            
            <div class="flex justify-center gap-4">
                <button @click="openHapus = false" class="px-8 py-2.5 bg-[#8E959D] text-white rounded-lg text-sm font-bold hover:bg-gray-500 transition active:scale-95 shadow-sm">
                    Batal
                </button>
                <button @click="confirmHapus()" class="px-8 py-2.5 bg-[#8E959D] text-white rounded-lg text-sm font-bold hover:bg-red-500 transition active:scale-95 shadow-sm">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>
@endsection