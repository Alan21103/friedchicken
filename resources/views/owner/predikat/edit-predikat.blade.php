@extends('owner.layouts.layouts')

@section('content')
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

        init() {
            // 1. Load data pendukung
            const savedCats = localStorage.getItem('my_categories');
            this.categories = savedCats ? JSON.parse(savedCats) : [];

            const savedMenus = localStorage.getItem('my_menus');
            this.allMenus = savedMenus ? JSON.parse(savedMenus) : [];

            // 2. Load data predikat yang akan diedit
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
            return this.allMenus.filter(menu => menu.kategori === this.editPredicate.kategori);
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

        update() {
            if(!this.editPredicate.nama || !this.editPredicate.kategori) {
                return alert('Nama Predikat dan Kategori wajib diisi!');
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
     }">
    
    <nav class="flex text-[11px] text-gray-400 mb-2 gap-2 items-center px-1">
        <a href="{{ route('owner.predikat.index') }}" class="hover:text-gray-600 transition">Kelola Predikat</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-500 font-medium">Edit Predikat</span>
    </nav>

    <div class="flex justify-between items-start mb-8 px-1">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Predikat</h1>
            <p class="text-sm text-gray-500 mt-1">Ubah informasi predikat <span class="font-bold" x-text="'PR' + idPredikat"></span></p>
        </div>
        <button @click="update()" class="flex items-center gap-2 bg-[#8B95A1] text-white px-7 py-2.5 rounded-lg font-bold hover:bg-slate-500 transition shadow-sm active:scale-95 border-none">
            <i class="fa-regular fa-floppy-disk text-lg"></i>
            <span>Simpan Perubahan</span>
        </button>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-14 gap-y-10">
            
            <div class="flex flex-col gap-3">
                <label class="font-bold text-gray-700 text-[14px] ml-1">Nama Predikat</label>
                <input type="text" x-model="editPredicate.nama"
                    class="w-full px-5 py-3.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-slate-100 focus:border-slate-400 outline-none transition text-gray-600 shadow-sm text-sm">
            </div>

            <div class="flex flex-col gap-3">
                <label class="font-bold text-gray-700 text-[14px] ml-1">Kategori</label>
                <div class="relative">
                    <select x-model="editPredicate.kategori" @change="selectedMenus = []"
                            class="w-full px-5 py-3.5 rounded-xl border border-gray-200 appearance-none focus:ring-2 focus:ring-slate-100 focus:border-slate-400 outline-none transition text-gray-600 bg-white shadow-sm cursor-pointer text-sm">
                        <template x-for="cat in categories" :key="cat.id">
                            <option :value="cat.nama" x-text="cat.nama" :selected="cat.nama === editPredicate.kategori"></option>
                        </template>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
                </div>
            </div>

            <div class="flex flex-col gap-3 md:col-span-2">
                <label class="font-bold text-gray-700 text-[14px] ml-1">Pilih Menu</label>
                <div class="relative">
                    <select @change="addMenu($event)" 
                            class="w-full px-5 py-3.5 rounded-xl border border-gray-200 appearance-none focus:ring-2 focus:ring-slate-100 focus:border-slate-400 outline-none transition text-gray-600 bg-white shadow-sm cursor-pointer text-sm">
                        <option value="" selected>Tambah Menu Lainnya...</option>
                        <template x-for="menu in filteredMenus" :key="menu.id">
                            <option :value="menu.nama" x-text="menu.nama"></option>
                        </template>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
                </div>
            </div>
        </div>

        <div class="mt-12 pt-10 border-t border-gray-50 flex flex-wrap gap-4">
            <template x-for="(menuName, index) in selectedMenus" :key="index">
                <div class="flex items-center gap-6 border border-gray-200 rounded-2xl px-6 py-3.5 bg-white shadow-sm group">
                    <span class="text-sm font-semibold text-gray-700" x-text="menuName"></span>
                    <button type="button" @click="removeMenu(index)" class="text-gray-400 hover:text-red-500 transition">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection