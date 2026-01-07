@extends('owner.layouts.layouts')

@section('content')
<div class="max-w-7xl mx-auto" 
     x-data="{ 
        categories: [], 
        allMenus: [], 
        selectedMenus: [], 
        newPredicate: {
            nama: '',
            kategori: '',
        },

        init() {
            // Ambil data Kategori dari Local Storage
            const savedCats = localStorage.getItem('my_categories');
            this.categories = savedCats ? JSON.parse(savedCats) : [];

            // Ambil data Menu dari Local Storage (Key: my_menus)
            const savedMenus = localStorage.getItem('my_menus');
            this.allMenus = savedMenus ? JSON.parse(savedMenus) : [];
        },

        // LOGIKA FILTER: Memastikan menu muncul meskipun ada perbedaan huruf besar/kecil
        get filteredMenus() {
            if (!this.newPredicate.kategori) return [];
            
            const selectedCat = this.newPredicate.kategori.toLowerCase().trim();
            return this.allMenus.filter(m => {
                const menuCat = (m.kategori || '').toLowerCase().trim();
                return menuCat === selectedCat;
            });
        },

        addMenu(event) {
            const menuName = event.target.value;
            if (menuName && !this.selectedMenus.includes(menuName)) {
                this.selectedMenus.push(menuName);
            }
            event.target.value = ''; 
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
    
    <nav class="flex text-[11px] text-gray-400 mb-2 gap-2 items-center px-1">
        <a href="{{ route('owner.predikat.index') }}" class="hover:text-gray-600 transition tracking-wide">Kelola Predikat</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-500 font-medium tracking-wide">Tambah Predikat</span>
    </nav>

    <div class="flex justify-between items-start mb-8 px-1">
        <div class="text-left">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Predikat</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi informasi Predikat dibawah ini</p>
        </div>
        <button @click="simpan()" class="flex items-center gap-2 bg-[#8B95A1] text-white px-7 py-2.5 rounded-lg font-bold hover:bg-slate-500 transition shadow-sm active:scale-95 border-none cursor-pointer">
            <i class="fa-regular fa-floppy-disk text-lg"></i>
            <span>Simpan</span>
        </button>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-14 gap-y-10 text-left">
            
            <div class="flex flex-col gap-3">
                <label class="font-bold text-gray-700 text-[14px] ml-1">Nama Predikat</label>
                <input type="text" x-model="newPredicate.nama" placeholder="Contoh: Best Seller" 
                    class="w-full px-5 py-3.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-slate-100 focus:border-slate-400 outline-none transition text-gray-600 shadow-sm text-sm font-medium">
            </div>

            <div class="flex flex-col gap-3">
                <label class="font-bold text-gray-700 text-[14px] ml-1">Kategori</label>
                <div class="relative">
                    <select x-model="newPredicate.kategori" @change="selectedMenus = []"
                            class="w-full px-5 py-3.5 rounded-xl border border-gray-200 appearance-none focus:ring-2 focus:ring-slate-100 focus:border-slate-400 outline-none transition text-gray-600 bg-white shadow-sm cursor-pointer text-sm font-medium">
                        <option value="">Pilih Kategori</option>
                        <template x-for="cat in categories" :key="cat.id">
                            <option :value="cat.nama" x-text="cat.nama"></option>
                        </template>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
                </div>
            </div>

            <div class="flex flex-col gap-3 md:col-span-2">
                <label class="font-bold text-gray-700 text-[14px] ml-1">Menu</label>
                <div class="relative shadow-sm rounded-xl">
                    <select @change="addMenu($event)" 
                            :disabled="!newPredicate.kategori"
                            class="w-full px-5 py-3.5 rounded-xl border border-gray-200 appearance-none focus:ring-2 focus:ring-slate-100 focus:border-slate-400 outline-none transition text-gray-600 bg-white cursor-pointer text-sm font-medium disabled:bg-gray-50">
                        
                        <option value="" x-text="!newPredicate.kategori ? 'Pilih Kategori Terlebih Dahulu' : 'Pilih Menu'"></option>
                        
                        <template x-for="menu in filteredMenus" :key="menu.id || menu.nama">
                            <option :value="menu.nama" x-text="menu.nama"></option>
                        </template>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
                </div>
            </div>
        </div>

        <div class="mt-12 pt-10 border-t border-gray-50 flex flex-wrap gap-4 text-left">
            <template x-for="(menuName, index) in selectedMenus" :key="index">
                <div class="flex items-center gap-6 border border-gray-200 rounded-2xl px-6 py-3.5 bg-white shadow-sm animate-in fade-in zoom-in duration-300">
                    <span class="text-sm font-semibold text-gray-700" x-text="menuName"></span>
                    <button type="button" @click="removeMenu(index)" class="text-gray-400 hover:text-red-500 transition border-none bg-transparent cursor-pointer">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>
            </template>
            
            <template x-if="selectedMenus.length === 0">
                <div class="py-4">
                    <p class="text-gray-400 text-sm italic font-medium tracking-wide">Belum ada menu yang dipilih...</p>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection