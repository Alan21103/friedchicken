@extends('owner.layouts.layouts')

@section('title', 'Kelola Menu')

@section('content')
{{-- Custom CSS untuk Scrollbar dan Input Number --}}
<style>
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #E6D5B8; border-radius: 10px; }
</style>

<div x-data="{ 
    openTambah: false, 
    openDetail: false,
    openHapus: false,
    isEdit: false,
    editIndex: null,
    deleteIndex: null,
    
    search: '',
    filterKategori: '',
    filterPredikat: '',
    
    currentPage: 1,
    itemsPerPage: 9,
    
    menus: [], 
    categories: [], 
    predicates: [], 
    selectedMenu: {},
    newMenu: { 
        nama: '', 
        deskripsi: '', 
        harga: '', 
        kategori: '', 
        tipe_saji: '', 
        foto: null 
    },

    init() {
        const savedCats = localStorage.getItem('my_categories');
        this.categories = savedCats ? JSON.parse(savedCats) : [];

        const savedMenus = localStorage.getItem('my_menus');
        this.menus = savedMenus ? JSON.parse(savedMenus) : [];

        const savedPreds = localStorage.getItem('my_predicates');
        this.predicates = savedPreds ? JSON.parse(savedPreds) : [];
    },

    getMenuPredicate(menuName) {
        if (!menuName) return null;
        const found = this.predicates.find(p => p.menus.includes(menuName));
        return found ? found.nama : null;
    },

    saveMenusToStorage() {
        localStorage.setItem('my_menus', JSON.stringify(this.menus));
    },

    get filteredMenus() {
        return this.menus.filter(m => {
            const matchSearch = this.search === '' || m.nama.toLowerCase().includes(this.search.toLowerCase());
            const matchKategori = this.filterKategori === '' || m.kategori === this.filterKategori;
            const currentPred = this.getMenuPredicate(m.nama);
            const matchPredikat = this.filterPredikat === '' || currentPred === this.filterPredikat;
            return matchSearch && matchKategori && matchPredikat;
        });
    },

    get paginatedMenus() {
        let start = (this.currentPage - 1) * this.itemsPerPage;
        let end = start + this.itemsPerPage;
        return this.filteredMenus.slice(start, end);
    },

    get totalPages() {
        return Math.ceil(this.filteredMenus.length / this.itemsPerPage) || 1;
    },

    formatRupiah(angka) {
        if (!angka) return '';
        return 'Rp' + Number(angka).toLocaleString('id-ID');
    },

    handleHarga(e) {
        let val = e.target.value.replace(/[^0-9]/g, '');
        this.newMenu.harga = val;
    },

    fileChosen(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => { this.newMenu.foto = e.target.result; };
        reader.readAsDataURL(file);
    },

    editMenu(menu) {
        this.isEdit = true;
        this.editIndex = this.menus.indexOf(menu);
        this.newMenu = { ...menu }; 
        this.openTambah = true;
    },

    simpanMenu() {
        if(!this.newMenu.nama || !this.newMenu.harga || !this.newMenu.tipe_saji) {
            return alert('Nama, Harga, dan Tipe Saji wajib diisi!');
        }
        if(this.isEdit) {
            this.menus[this.editIndex] = { ...this.newMenu };
        } else {
            this.menus.push({ ...this.newMenu });
        }
        this.saveMenusToStorage();
        this.resetForm();
    },

    resetForm() {
        this.newMenu = { nama: '', deskripsi: '', harga: '', kategori: '', tipe_saji: '', foto: null };
        this.isEdit = false;
        this.editIndex = null;
        this.openTambah = false;
    },

    lihatDetail(menu) {
        this.selectedMenu = menu;
        this.openDetail = true;
    },

    hapusMenu(menu) {
        this.deleteIndex = this.menus.indexOf(menu);
        this.openHapus = true;
    },

    confirmHapus() {
        if (this.deleteIndex !== null) {
            this.menus.splice(this.deleteIndex, 1);
            this.saveMenusToStorage();
            this.openHapus = false;
            this.deleteIndex = null;
            if (this.paginatedMenus.length === 0 && this.currentPage > 1) this.currentPage--;
        }
    }
}" x-init="init()" x-cloak>

    {{-- Header --}}
    <div class="mb-8 text-left px-1">
        <h2 class="text-2xl font-bold text-[#332B2B]">List Menu</h2>
        <p class="text-[#4A3F3F]/60 mt-0.5 text-sm font-medium">Tambah, ubah, atau hapus menu restoran</p>
    </div>

    {{-- Toolbar Filter --}}
    <div class="bg-[#E6D5B8] p-4 rounded-2xl flex flex-wrap items-center justify-between mb-8 shadow-sm gap-4">
        <div class="flex flex-wrap items-center gap-3 flex-1">
            <div class="relative w-full max-w-[220px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#332B2B]/40">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" x-model="search" @input="currentPage = 1" placeholder="Cari Menu..." 
                    class="block w-full pl-10 pr-3 py-2.5 bg-white/80 border-none rounded-xl text-sm focus:ring-2 focus:ring-[#332B2B]/20 outline-none transition placeholder-[#4A3F3F]/40 font-medium">
            </div>
            
            {{-- Custom Dropdown Kategori --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                    class="bg-white/80 min-w-[160px] flex items-center justify-between pl-4 pr-3 py-2.5 rounded-xl text-sm text-[#332B2B] font-bold focus:ring-2 focus:ring-[#332B2B]/20 outline-none transition">
                    <span x-text="filterKategori === '' ? 'Semua Kategori' : filterKategori"></span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-[#332B2B]/30 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" @click.away="open = false" x-transition 
                    class="absolute z-50 mt-2 w-full bg-white rounded-2xl shadow-xl border border-[#E6D5B8] py-2 max-h-60 overflow-y-auto custom-scrollbar">
                    <button @click="filterKategori = ''; open = false; currentPage = 1" class="w-full text-left px-4 py-2 text-sm hover:bg-[#E6D5B8]/30 transition" :class="filterKategori === '' ? 'text-[#332B2B] font-black bg-[#E6D5B8]/20' : 'text-[#4A3F3F]'">Semua Kategori</button>
                    <template x-for="cat in categories" :key="cat.id">
                        <button @click="filterKategori = cat.nama; open = false; currentPage = 1" 
                            class="w-full text-left px-4 py-2 text-sm hover:bg-[#E6D5B8]/30 transition"
                            :class="filterKategori === cat.nama ? 'text-[#332B2B] font-black bg-[#E6D5B8]/20' : 'text-[#4A3F3F]'"
                            x-text="cat.nama"></button>
                    </template>
                </div>
            </div>

            {{-- Custom Dropdown Predikat --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                    class="bg-white/80 min-w-[160px] flex items-center justify-between pl-4 pr-3 py-2.5 rounded-xl text-sm text-[#332B2B] font-bold focus:ring-2 focus:ring-[#332B2B]/20 outline-none transition">
                    <span x-text="filterPredikat === '' ? 'Semua Predikat' : filterPredikat"></span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-[#332B2B]/30 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" @click.away="open = false" x-transition 
                    class="absolute z-50 mt-2 w-full bg-white rounded-2xl shadow-xl border border-[#E6D5B8] py-2 max-h-60 overflow-y-auto custom-scrollbar">
                    <button @click="filterPredikat = ''; open = false; currentPage = 1" class="w-full text-left px-4 py-2 text-sm hover:bg-[#E6D5B8]/30 transition" :class="filterPredikat === '' ? 'text-[#332B2B] font-black bg-[#E6D5B8]/20' : 'text-[#4A3F3F]'">Semua Predikat</button>
                    <template x-for="p in predicates" :key="p.id">
                        <button @click="filterPredikat = p.nama; open = false; currentPage = 1" 
                            class="w-full text-left px-4 py-2 text-sm hover:bg-[#E6D5B8]/30 transition"
                            :class="filterPredikat === p.nama ? 'text-[#332B2B] font-black bg-[#E6D5B8]/20' : 'text-[#4A3F3F]'"
                            x-text="p.nama"></button>
                    </template>
                </div>
            </div>
        </div>

        <button @click="resetForm(); openTambah = true" 
            class="bg-[#332B2B] text-[#E6D5B8] font-bold py-2.5 px-6 rounded-xl hover:bg-[#4A3F3F] flex items-center gap-2 transition active:scale-95 text-sm shadow-md">
            <i class="fa-solid fa-plus text-xs"></i> 
            <span>Tambah Menu</span>
        </button>
    </div>

    {{-- Grid Menu --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <template x-for="(menu, index) in paginatedMenus" :key="index">
            <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl hover:translate-y-[-4px] transition-all duration-300 border border-[#E6D5B8]/30 text-left flex flex-col h-full group">
                <div class="h-48 bg-[#FDFCFB] relative overflow-hidden cursor-pointer" @click="lihatDetail(menu)">
                    <template x-if="menu.foto">
                        <img :src="menu.foto" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </template>
                    <template x-if="!menu.foto">
                        <div class="w-full h-full flex items-center justify-center text-[#E6D5B8]">
                            <i class="fa-regular fa-image text-5xl opacity-40"></i>
                        </div>
                    </template>
                    {{-- Badge Predikat Melayang di Kartu (Opsional) --}}
                    <template x-if="getMenuPredicate(menu.nama)">
                        <div class="absolute top-4 right-4">
                            <span class="bg-[#E6D5B8] text-[#332B2B] px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest shadow-sm" x-text="getMenuPredicate(menu.nama)"></span>
                        </div>
                    </template>
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-base font-bold text-[#332B2B] tracking-tight" x-text="menu.nama"></h3>
                        <span class="text-[9px] font-black text-[#E6D5B8] bg-[#332B2B] px-2.5 py-1 rounded-lg uppercase tracking-widest" x-text="menu.kategori"></span>
                    </div>
                    <p class="text-[#4A3F3F]/70 text-xs line-clamp-2 leading-relaxed flex-grow font-medium" x-text="menu.deskripsi || 'Tidak ada deskripsi tersedia.'"></p>
                    
                    <div class="mt-6 flex justify-between items-center border-t border-[#E6D5B8]/20 pt-5">
                        <span class="text-lg font-black text-[#332B2B]" x-text="formatRupiah(menu.harga)"></span>
                        <div class="flex gap-2">
                            <button @click.stop="editMenu(menu)" class="p-2.5 bg-[#E6D5B8]/20 text-[#4A3F3F] rounded-xl hover:bg-[#332B2B] hover:text-white transition active:scale-90">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </button>
                            <button @click.stop="lihatDetail(menu)" class="p-2.5 bg-[#E6D5B8]/20 text-[#4A3F3F] rounded-xl hover:bg-[#4A3F3F] hover:text-white transition active:scale-90">
                                <i class="fa-solid fa-circle-info text-xs"></i>
                            </button>
                            <button @click.stop="hapusMenu(menu)" class="p-2.5 bg-red-50 text-red-400 rounded-xl hover:bg-red-500 hover:text-white transition active:scale-90">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- MODAL DETAIL MENU --}}
    <div x-show="openDetail" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-transition.opacity x-cloak>
        <div class="absolute inset-0 bg-[#332B2B]/60 backdrop-blur-sm" @click="openDetail = false"></div>
        <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden px-10 py-10 text-left border border-[#E6D5B8]/30">
            <button @click="openDetail = false" class="absolute top-8 right-10 text-[#332B2B] hover:opacity-50 transition"><i class="fa-solid fa-xmark text-xl"></i></button>
            <div class="mb-6"><span class="bg-[#332B2B] text-[#E6D5B8] px-6 py-2 rounded-xl text-xs font-bold tracking-widest uppercase shadow-md">Detail Menu</span></div>
            
            <div class="relative w-full h-64 bg-[#FDFCFB] rounded-[2rem] overflow-hidden mb-6 flex items-center justify-center border border-[#E6D5B8]/30">
                <template x-if="selectedMenu.foto"><img :src="selectedMenu.foto" class="w-full h-full object-cover"></template>
                <template x-if="!selectedMenu.foto"><i class="fa-regular fa-image text-5xl text-[#E6D5B8] opacity-50"></i></template>
                
                <div class="absolute top-4 left-4">
                    <span class="bg-white/90 backdrop-blur text-[#332B2B] px-3.5 py-2 rounded-xl text-[10px] font-bold flex items-center gap-2 shadow-sm border border-[#E6D5B8]/50">
                        <i :class="selectedMenu.tipe_saji === 'Cepat' ? 'fa-solid fa-bolt' : 'fa-regular fa-clock'"></i>
                        <span x-text="selectedMenu.tipe_saji || 'Standar'"></span>
                    </span>
                </div>

                <template x-if="getMenuPredicate(selectedMenu.nama)">
                    <div class="absolute top-4 right-4">
                        <span class="bg-[#E6D5B8] text-[#332B2B] px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-sm border border-white" 
                              x-text="getMenuPredicate(selectedMenu.nama)"></span>
                    </div>
                </template>
            </div>

            <div class="space-y-6 px-1">
                <div class="flex justify-between items-start">
                    <h2 class="text-3xl font-black text-[#332B2B] tracking-tight" x-text="selectedMenu.nama"></h2>
                    <span class="bg-[#E6D5B8]/30 text-[#4A3F3F] px-4 py-1.5 rounded-lg text-[10px] font-bold tracking-wider border border-[#E6D5B8]/50" x-text="'Kategori : ' + (selectedMenu.kategori || '-')"></span>
                </div>
                <p class="text-[#4A3F3F] text-sm leading-relaxed font-medium opacity-80" x-text="selectedMenu.deskripsi || 'Tidak ada deskripsi tersedia untuk menu ini.'"></p>
                <div class="pt-6 border-t border-[#E6D5B8]/20 flex items-baseline gap-3">
                    <span class="text-xs font-bold text-[#4A3F3F]/40 uppercase tracking-widest">Harga :</span>
                    <h3 class="text-3xl font-black text-[#332B2B]" x-text="formatRupiah(selectedMenu.harga)"></h3>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH/EDIT MENU --}}
    <div x-show="openTambah" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-transition.opacity x-cloak>
        <div class="absolute inset-0 bg-[#332B2B]/60 backdrop-blur-sm" @click="resetForm()"></div>
        <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden px-8 py-10 border border-[#E6D5B8]/30">
            <button @click="resetForm()" class="absolute top-8 right-8 text-[#332B2B] hover:opacity-50 transition"><i class="fa-solid fa-xmark text-xl"></i></button>
            <div class="mb-8 text-left"><span class="bg-[#332B2B] text-[#E6D5B8] px-6 py-2.5 rounded-xl text-xs font-bold tracking-widest uppercase shadow-md"><span x-text="isEdit ? 'Ubah Menu' : 'Tambah Menu'"></span></span></div>
            
            <div class="space-y-5">
                <div class="text-left">
                    <label class="block text-xs font-black text-[#332B2B] uppercase tracking-widest mb-2 ml-1">Nama Menu</label>
                    <input type="text" x-model="newMenu.nama" placeholder="Contoh: Ayam Geprek" class="w-full border border-[#E6D5B8] rounded-xl px-5 py-3 text-sm outline-none focus:border-[#332B2B] focus:ring-4 focus:ring-[#332B2B]/5 transition font-medium">
                </div>
                <div class="text-left">
                    <label class="block text-xs font-black text-[#332B2B] uppercase tracking-widest mb-2 ml-1">Deskripsi</label>
                    <textarea x-model="newMenu.deskripsi" rows="3" placeholder="Deskripsi..." class="w-full border border-[#E6D5B8] rounded-xl px-5 py-3 text-sm outline-none resize-none focus:border-[#332B2B] focus:ring-4 focus:ring-[#332B2B]/5 transition font-medium"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4 text-left">
                    <div>
                        <label class="block text-xs font-black text-[#332B2B] uppercase tracking-widest mb-2 ml-1">Harga</label>
                        <input type="text" :value="formatRupiah(newMenu.harga)" @input="handleHarga" placeholder="Rp 0" class="w-full border border-[#E6D5B8] rounded-xl px-5 py-3 text-sm outline-none font-bold focus:border-[#332B2B]">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-[#332B2B] uppercase tracking-widest mb-2 ml-1">Kategori</label>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" type="button" class="w-full flex items-center justify-between border border-[#E6D5B8] bg-white rounded-xl px-4 py-3 text-sm outline-none font-bold focus:border-[#332B2B] transition">
                                <span x-text="newMenu.kategori === '' ? 'Pilih...' : newMenu.kategori"></span>
                                <i class="fa-solid fa-chevron-down text-[10px] text-[#332B2B]/30" :class="open ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute z-[60] mt-1 w-full bg-white rounded-xl shadow-xl border border-[#E6D5B8] py-2 max-h-40 overflow-y-auto custom-scrollbar">
                                <template x-for="cat in categories" :key="cat.id">
                                    <button @click="newMenu.kategori = cat.nama; open = false" class="w-full text-left px-4 py-2 text-sm hover:bg-[#E6D5B8]/30 transition" :class="newMenu.kategori === cat.nama ? 'text-[#332B2B] font-black bg-[#E6D5B8]/20' : 'text-[#4A3F3F]'" x-text="cat.nama"></button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-left">
                    <label class="block text-xs font-black text-[#332B2B] uppercase tracking-widest mb-3 ml-1">Tipe Penyajian</label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" x-model="newMenu.tipe_saji" value="Butuh Waktu" class="w-4 h-4 accent-[#332B2B]"><span class="text-sm text-[#4A3F3F] font-bold">Standar</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" x-model="newMenu.tipe_saji" value="Cepat" class="w-4 h-4 accent-[#332B2B]"><span class="text-sm text-[#4A3F3F] font-bold">Kilat</span>
                        </label>
                    </div>
                </div>
                <div class="text-left">
                    <label class="block text-xs font-black text-[#332B2B] uppercase tracking-widest mb-2 ml-1">Foto Produk</label>
                    <div class="border-2 border-dashed border-[#E6D5B8] rounded-[1.5rem] p-6 flex flex-col items-center justify-center relative hover:bg-[#E6D5B8]/10 transition-colors">
                        <input type="file" @change="fileChosen" class="absolute inset-0 opacity-0 cursor-pointer">
                        <template x-if="newMenu.foto"><img :src="newMenu.foto" class="h-24 w-40 object-cover rounded-xl shadow-md border-4 border-white"></template>
                        <template x-if="!newMenu.foto"><div class="text-center"><i class="fa-solid fa-cloud-arrow-up text-3xl text-[#E6D5B8] mb-2"></i><p class="text-[11px] text-[#4A3F3F] font-bold">Klik/seret foto</p></div></template>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-6">
                    <button @click="resetForm()" class="px-8 py-3 bg-white border border-[#E6D5B8] text-[#4A3F3F] rounded-xl text-xs font-black uppercase tracking-widest hover:bg-[#FDFCFB] transition flex-1">Batal</button>
                    <button @click="simpanMenu()" class="px-8 py-3 bg-[#332B2B] text-[#E6D5B8] rounded-xl text-xs font-black uppercase tracking-widest hover:bg-[#4A3F3F] transition shadow-lg flex-1">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL HAPUS --}}
    <div x-show="openHapus" class="fixed inset-0 z-[110] flex items-center justify-center p-4" x-transition.opacity x-cloak>
        <div class="absolute inset-0 bg-[#332B2B]/60 backdrop-blur-sm" @click="openHapus = false"></div>
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl relative z-10 px-8 py-12 text-center border border-[#E6D5B8]/30">
            <div class="w-20 h-20 bg-red-50 text-red-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner"><i class="fa-solid fa-trash-can text-3xl"></i></div>
            <h3 class="text-xl font-black text-[#332B2B] mb-2 tracking-tight">Hapus Produk?</h3>
            <p class="text-[#4A3F3F]/60 mb-10 text-sm font-medium leading-relaxed px-4">Menu ini akan dihapus permanen dari daftar restoran Anda.</p>
            <div class="flex justify-center gap-3">
                <button @click="openHapus = false" class="px-8 py-3.5 bg-white border border-[#E6D5B8] text-[#4A3F3F] rounded-xl text-xs font-black uppercase tracking-widest hover:bg-[#FDFCFB] transition flex-1">Batal</button>
                <button @click="confirmHapus()" class="px-8 py-3.5 bg-red-500 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-600 transition shadow-lg shadow-red-200 flex-1">Hapus</button>
            </div>
        </div>
    </div>

    {{-- Pagination (Opsional UI) --}}
    <div class="mt-12 flex justify-center" x-show="totalPages > 1">
        <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-2xl border border-[#E6D5B8]/30 shadow-sm">
            <button @click="if(currentPage > 1) currentPage--" :disabled="currentPage === 1" class="p-2 text-[#332B2B] disabled:opacity-30"><i class="fa-solid fa-chevron-left text-xs"></i></button>
            <template x-for="p in totalPages" :key="p">
                <button @click="currentPage = p" class="w-8 h-8 rounded-lg text-xs font-black transition" :class="currentPage === p ? 'bg-[#332B2B] text-[#E6D5B8]' : 'text-[#4A3F3F] hover:bg-[#E6D5B8]/20'" x-text="p"></button>
            </template>
            <button @click="if(currentPage < totalPages) currentPage++" :disabled="currentPage === totalPages" class="p-2 text-[#332B2B] disabled:opacity-30"><i class="fa-solid fa-chevron-right text-xs"></i></button>
        </div>
    </div>
</div>
@endsection