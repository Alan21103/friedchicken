@extends('owner.layouts.layouts')

@section('content')
{{-- State Management Alpine.js --}}
<div x-data="{ 
    openTambah: false, 
    openDetail: false,
    openHapus: false,
    isEdit: false,
    editIndex: null,
    deleteIndex: null,
    
    // SEARCH & FILTER STATE
    search: '',
    filterKategori: '',
    filterPredikat: '',
    
    // PAGINATION STATE
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

    // FUNGSI: Mencari predikat untuk menu tertentu
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
    <div class="mb-6 text-left px-1">
        <h2 class="text-2xl font-bold text-gray-900">List Menu</h2>
        <p class="text-gray-500 mt-0.5 text-sm">Tambah, ubah, atau hapus menu restoran</p>
    </div>

    {{-- Toolbar Filter --}}
    <div class="bg-[#ACB5BD] p-4 rounded-xl flex items-center justify-between mb-6 shadow-sm">
        <div class="flex items-center gap-2.5 flex-1">
            <div class="relative w-full max-w-[200px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" x-model="search" @input="currentPage = 1" placeholder="Cari Menu..." 
                    class="block w-full pl-10 pr-3 py-2 bg-white border-none rounded-lg text-sm focus:ring-2 focus:ring-gray-300 outline-none transition shadow-sm">
            </div>
            
            <div class="relative">
                <select x-model="filterKategori" @change="currentPage = 1" class="appearance-none bg-white pl-4 pr-9 py-2 rounded-lg border-none text-sm text-gray-700 focus:ring-2 focus:ring-gray-300 outline-none cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <template x-for="cat in categories" :key="cat.id">
                        <option :value="cat.nama" x-text="cat.nama"></option>
                    </template>
                </select>
                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
            </div>

            <div class="relative">
                <select x-model="filterPredikat" @change="currentPage = 1" class="appearance-none bg-white pl-4 pr-9 py-2 rounded-lg border-none text-sm text-gray-700 focus:ring-2 focus:ring-gray-300 outline-none cursor-pointer">
                    <option value="">Semua Predikat</option>
                    <template x-for="p in predicates" :key="p.id">
                        <option :value="p.nama" x-text="p.nama"></option>
                    </template>
                </select>
                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
            </div>
        </div>

        <button @click="resetForm(); openTambah = true" class="bg-white text-gray-800 font-bold py-2 px-5 rounded-lg hover:bg-gray-50 flex items-center gap-2 transition active:scale-95 text-sm shadow-sm border-none outline-none">
            <i class="fa-solid fa-plus text-xs"></i> 
            <span>Tambah Menu</span>
        </button>
    </div>

    {{-- Grid Menu (Tanpa Badge Apapun) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        <template x-for="(menu, index) in paginatedMenus" :key="index">
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 text-left flex flex-col h-full">
                <div class="h-44 bg-gray-100 relative group cursor-pointer" @click="lihatDetail(menu)">
                    <template x-if="menu.foto"><img :src="menu.foto" class="w-full h-full object-cover"></template>
                    <template x-if="!menu.foto"><div class="w-full h-full flex items-center justify-center text-gray-300"><i class="fa-regular fa-image text-4xl opacity-50"></i></div></template>
                </div>

                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-1.5">
                        <h3 class="text-base font-bold text-gray-900 tracking-tight" x-text="menu.nama"></h3>
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest" x-text="menu.kategori"></span>
                    </div>
                    <p class="text-gray-500 text-xs line-clamp-2 leading-relaxed flex-grow font-medium" x-text="menu.deskripsi || 'Tidak ada deskripsi tersedia.'"></p>
                    
                    <div class="mt-5 flex justify-between items-center border-t border-gray-50 pt-4">
                        <span class="text-base font-black text-gray-900" x-text="formatRupiah(menu.harga)"></span>
                        <div class="flex gap-1.5 text-gray-400">
                            <i @click.stop="editMenu(menu)" class="fa-solid fa-pen-to-square p-2 bg-gray-50 rounded-lg hover:text-blue-500 hover:bg-blue-50 transition active:scale-90 cursor-pointer"></i>
                            <i @click.stop="lihatDetail(menu)" class="fa-solid fa-circle-info p-2 bg-gray-50 rounded-lg hover:text-gray-700 hover:bg-gray-100 transition active:scale-90 cursor-pointer"></i>
                            <i @click.stop="hapusMenu(menu)" class="fa-solid fa-trash-can p-2 bg-gray-50 rounded-lg hover:text-red-500 hover:bg-red-50 transition active:scale-90 cursor-pointer"></i>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- MODAL DETAIL MENU (SEMUA BADGE MUNCUL DI SINI) --}}
    <div x-show="openDetail" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-transition.opacity x-cloak>
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="openDetail = false"></div>
        <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden px-10 py-10 text-left border-none outline-none">
            <button @click="openDetail = false" class="absolute top-8 right-10 text-gray-800 transition hover:opacity-50"><i class="fa-solid fa-xmark text-xl"></i></button>
            <div class="mb-6 text-left"><span class="bg-[#8E959D] text-white px-6 py-2 rounded-lg text-sm font-bold tracking-wide">Detail Menu</span></div>
            
            <div class="relative w-full h-64 bg-gray-100 rounded-[2rem] overflow-hidden mb-6 flex items-center justify-center border border-gray-50">
                <template x-if="selectedMenu.foto"><img :src="selectedMenu.foto" class="w-full h-full object-cover"></template>
                <template x-if="!selectedMenu.foto"><i class="fa-regular fa-image text-5xl text-gray-300 opacity-50"></i></template>
                
                {{-- Badge Tipe Saji di Modal Detail (Kiri Atas) --}}
                <div class="absolute top-4 left-4">
                    <span class="bg-[#8E959D] text-white px-3 py-1.5 rounded-lg text-[10px] font-bold flex items-center gap-1.5 shadow-md">
                        <i :class="selectedMenu.tipe_saji === 'Cepat' ? 'fa-solid fa-bolt' : 'fa-regular fa-clock'"></i>
                        <span x-text="selectedMenu.tipe_saji || 'Butuh Waktu'"></span>
                    </span>
                </div>

                {{-- Badge Predikat di Modal Detail (Kanan Atas) --}}
                <template x-if="getMenuPredicate(selectedMenu.nama)">
                    <div class="absolute top-4 right-4 animate-in fade-in zoom-in duration-300">
                        <span class="bg-[#8E959D] text-white px-5 py-2 rounded-lg text-[10px] font-extrabold uppercase tracking-widest shadow-md border border-white/20" 
                              x-text="getMenuPredicate(selectedMenu.nama)"></span>
                    </div>
                </template>
            </div>

            <div class="space-y-5 px-1">
                <div class="flex justify-between items-start">
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight" x-text="selectedMenu.nama"></h2>
                    <span class="bg-[#8E959D] text-white px-4 py-1.5 rounded-lg text-[10px] font-bold tracking-wider shadow-sm" x-text="'Kategori : ' + (selectedMenu.kategori || '-')"></span>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed font-medium" x-text="selectedMenu.deskripsi || 'Tidak ada deskripsi tersedia untuk menu ini.'"></p>
                <div class="pt-4 border-t border-gray-100 flex items-baseline gap-2">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-none">Harga :</span>
                    <h3 class="text-3xl font-black text-gray-900 leading-none" x-text="formatRupiah(selectedMenu.harga)"></h3>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH/EDIT MENU (FONT KEMBALI ASLI) --}}
    <div x-show="openTambah" class="fixed inset-0 z-[99] flex items-center justify-center p-4" x-transition.opacity x-cloak>
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="resetForm()"></div>
        <div class="bg-white w-full max-w-md rounded-[1.5rem] shadow-2xl relative z-10 overflow-hidden px-8 py-8">
            <button @click="resetForm()" class="absolute top-6 right-8 text-gray-800 transition hover:opacity-50"><i class="fa-solid fa-xmark text-xl"></i></button>
            <div class="mb-6 text-left"><span class="bg-[#8E959D] text-white px-6 py-2 rounded-lg text-sm font-bold tracking-wide shadow-sm"><span x-text="isEdit ? 'Ubah Menu' : 'Tambah Menu'"></span></span></div>
            <div class="space-y-5">
                {{-- Font label kembali ke original bold --}}
                <div class="text-left"><label class="block text-sm font-bold text-gray-800 mb-1.5">Nama Menu</label><input type="text" x-model="newMenu.nama" placeholder="Masukkan nama menu..." class="w-full border border-gray-400 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-gray-600 transition shadow-sm font-medium"></div>
                <div class="text-left"><label class="block text-sm font-bold text-gray-800 mb-1.5">Deskripsi</label><textarea x-model="newMenu.deskripsi" rows="4" placeholder="Masukkan deskripsi menu..." class="w-full border border-gray-400 rounded-lg px-4 py-2.5 text-sm outline-none resize-none focus:border-gray-600 transition shadow-sm font-medium"></textarea></div>
                <div class="grid grid-cols-2 gap-4 text-left">
                    <div><label class="block text-sm font-bold text-gray-800 mb-1.5">Harga</label><input type="text" :value="formatRupiah(newMenu.harga)" @input="handleHarga" placeholder="Rp.0" class="w-full border border-gray-400 rounded-lg px-4 py-2.5 text-sm outline-none font-bold"></div>
                    <div><label class="block text-sm font-bold text-gray-800 mb-1.5">Kategori</label><div class="relative"><select x-model="newMenu.kategori" class="w-full appearance-none bg-white border border-gray-400 rounded-lg px-4 py-2.5 text-sm outline-none font-medium"><option value="">Pilih Kategori</option><template x-for="cat in categories" :key="cat.id"><option :value="cat.nama" x-text="cat.nama"></option></template></select><i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i></div></div>
                </div>
                <div class="text-left"><label class="block text-sm font-bold text-gray-800 mb-2">Tipe Saji</label><div class="flex items-center gap-8"><label class="flex items-center gap-2.5 cursor-pointer"><input type="radio" x-model="newMenu.tipe_saji" value="Butuh Waktu" class="w-4 h-4 accent-gray-800"><span class="text-sm text-gray-700 font-medium">Butuh Waktu</span></label><label class="flex items-center gap-2.5 cursor-pointer"><input type="radio" x-model="newMenu.tipe_saji" value="Cepat" class="w-4 h-4 accent-gray-800"><span class="text-sm text-gray-700 font-medium">Cepat</span></label></div></div>
                
                {{-- Field Foto dengan Ikon & Instruksi (Semula) --}}
                <div class="text-left">
                    <label class="block text-sm font-bold text-gray-800 mb-1.5">Foto</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 flex flex-col items-center justify-center relative hover:bg-gray-50 transition">
                        <input type="file" @change="fileChosen" class="absolute inset-0 opacity-0 cursor-pointer">
                        <template x-if="newMenu.foto">
                            <img :src="newMenu.foto" class="h-20 w-32 object-cover rounded-xl shadow-md border-2 border-white">
                        </template>
                        <template x-if="!newMenu.foto">
                            <div class="text-center">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-300 mb-3 opacity-60"></i>
                                <p class="text-sm text-gray-600 font-medium leading-tight">Drag your file(s) or <span class="font-bold text-gray-800 underline">browse</span></p>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4"><button @click="resetForm()" class="px-8 py-3 bg-white border border-gray-200 text-gray-400 rounded-xl text-sm font-bold hover:bg-gray-50 transition shadow-sm active:scale-95 flex-1 text-xs">Batal</button><button @click="simpanMenu()" class="px-8 py-3 bg-[#8E959D] text-white rounded-xl text-sm font-bold hover:bg-gray-600 transition shadow-sm active:scale-95 flex-1 text-xs shadow-md text-center">Simpan</button></div>
            </div>
        </div>
    </div>

    {{-- MODAL HAPUS MENU --}}
    <div x-show="openHapus" class="fixed inset-0 z-[110] flex items-center justify-center p-4" x-transition.opacity x-cloak>
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="openHapus = false"></div>
        <div class="bg-gray-50 w-full max-w-sm rounded-[2rem] shadow-xl relative z-10 px-8 py-12 text-center text-left">
            <div class="w-16 h-16 bg-red-50 text-red-400 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fa-solid fa-trash-can text-2xl"></i></div>
            <h3 class="text-xl font-bold text-gray-900 mb-2 tracking-tight">Hapus Menu</h3>
            <p class="text-gray-500 mb-10 text-sm font-medium leading-relaxed px-4 text-center">Apakah Anda yakin ingin menghapus menu ini dari daftar restoran?</p>
            <div class="flex justify-center gap-4">
                <button @click="openHapus = false" class="px-8 py-3 bg-white border border-gray-200 text-gray-400 rounded-xl text-sm font-bold hover:bg-gray-50 transition shadow-sm active:scale-95 flex-1 text-xs">Batal</button>
                <button @click="confirmHapus()" class="px-8 py-3 bg-[#8E959D] text-white rounded-xl text-sm font-bold hover:bg-red-500 transition shadow-sm active:scale-95 flex-1 text-xs text-center">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection