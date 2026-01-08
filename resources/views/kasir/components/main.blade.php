<main class="flex-1 flex flex-col bg-[#EDEDED] min-w-0 overflow-hidden">

    <div class="p-6 pb-2">
        <div class="relative w-full">
            <input type="text" x-model="searchQuery" placeholder="Cari Menu Favorit..."
                class="w-full pl-14 pr-4 py-4 rounded-2xl border-none shadow-sm focus:ring-2 focus:ring-[#332B2B] outline-none text-lg bg-white text-[#332B2B] placeholder-[#332B2B]/30 transition-all">
            <svg class="w-6 h-6 absolute left-5 top-4 text-[#332B2B]/30" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <div class="px-6 py-4 flex gap-4 overflow-x-auto no-scrollbar flex-shrink-0">
        <template x-for="cat in categories" :key="cat">
            <button @click="activeCategory = cat"
                :class="activeCategory === cat ? 'bg-[#332B2B] text-[#E6D5B8] shadow-xl scale-105' : 'bg-white text-[#332B2B]/60 border border-[#332B2B]/5 hover:bg-white/80'"
                class="px-8 py-3 rounded-2xl font-bold whitespace-nowrap transition-all text-sm flex items-center gap-3">

                <template x-if="cat === 'Best Seller'">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4l-1.4 1.866a4 4 0 00-.8 2.4z"></path>
                    </svg>
                </template>
                <template x-if="cat === 'Makanan'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.703 2.703 0 00-3 0 2.703 2.703 0 01-3 0 2.703 2.703 0 00-3 0 2.704 2.704 0 01-1.5-.454M3 8V4a2 2 0 012-2h14a2 2 0 012 2v4M5 20h14a2 2 0 002-2V8H3v10a2 2 0 002 2z"></path>
                    </svg>
                </template>
                <template x-if="cat === 'Minuman'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </template>
                <template x-if="cat === 'Paket'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </template>
                <template x-if="cat === 'Camilan'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                    </svg>
                </template>

                <span x-text="cat"></span>
            </button>
        </template>
    </div>

    <div class="flex-1 overflow-y-auto p-6 custom-scrollbar relative">
        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <template x-for="product in filteredMenus" :key="product.id">
                <div x-html="renderCard(product)"></div>
            </template>
        </div>

        <div x-show="filteredMenus.length === 0" x-cloak
            class="absolute inset-0 flex flex-col items-center justify-center text-center bg-[#F5F1EE]">
            <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center mb-6 shadow-sm border border-[#332B2B]/5">
                <svg class="w-16 h-16 text-[#332B2B]/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-[#332B2B] mb-2">Menu tidak ditemukan</h3>
            <p class="text-[#332B2B]/40 text-sm mb-4">Coba cari kata kunci lain</p>
            <button @click="searchQuery = ''"
                class="px-6 py-2 bg-[#332B2B] text-[#E6D5B8] rounded-xl font-semibold hover:bg-[#433939] transition-all shadow-md active:scale-95">
                Hapus pencarian
            </button>
        </div>
    </div>
</main>