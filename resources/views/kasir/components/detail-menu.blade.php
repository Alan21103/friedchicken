<div x-show="showDetail" 
     x-transition.opacity.duration.300ms
     class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" x-cloak>
    
    <div @click.away="showDetail = false" 
         class="bg-white rounded-[28px] w-full max-w-lg overflow-hidden shadow-2xl relative">
        
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-800">Detail Menu</h2>
            </div>
            <button @click="showDetail = false" class="p-1.5 hover:bg-gray-100 rounded-full transition-colors">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex flex-col">
            <div class="relative h-56 bg-gray-50 mx-6 mt-4 rounded-[20px] overflow-hidden">
                <img :src="selectedProduct?.image" class="w-full h-full object-cover">
                
                <div class="absolute top-3 left-3 flex gap-2">
                    <span class="px-3 py-1.5 bg-slate-500/80 backdrop-blur-md text-white rounded-full text-[10px] font-bold flex items-center gap-1.5">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" /></svg>
                        Cepat
                    </span>
                </div>
                
                <template x-if="selectedProduct?.bestSeller">
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1.5 bg-[#4F5B69] text-white rounded-full text-[10px] font-bold flex items-center gap-1.5">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4l-1.4 1.866a4 4 0 00-.8 2.4z" /></svg>
                            Best Seller
                        </span>
                    </div>
                </template>
            </div>

            <div class="px-6 py-5">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-xl font-bold text-gray-900" x-text="selectedProduct?.nama"></h3>
                    <span class="px-2.5 py-1 bg-gray-100 text-gray-500 rounded-lg text-[10px] font-bold uppercase tracking-wider" x-text="selectedProduct?.kategori"></span>
                </div>
                
                <p class="text-gray-500 text-sm leading-relaxed mb-5 line-clamp-2" x-text="selectedProduct?.deskripsi"></p>
                
                <div class="flex items-baseline gap-2 mb-6">
                    <div class="text-2xl font-black text-gray-900" x-text="formatPrice(selectedProduct?.harga)"></div>
                    <div class="text-gray-400 font-medium text-xs">/ Stok: <span x-text="selectedProduct?.stok"></span></div>
                </div>

                <div class="flex gap-3">
                    <div class="flex items-center bg-gray-100 rounded-xl p-1 w-32">
                        <button @click="updateDetailQty(-1)" class="w-9 h-9 flex items-center justify-center bg-white rounded-lg shadow-sm hover:bg-gray-50 text-lg font-bold text-gray-800">-</button>
                        <span class="flex-1 text-center font-bold text-gray-800" x-text="detailQty"></span>
                        <button @click="updateDetailQty(1)" class="w-9 h-9 flex items-center justify-center bg-white rounded-lg shadow-sm hover:bg-gray-50 text-lg font-bold text-gray-800">+</button>
                    </div>

                    <button @click="addToCartFromDetail()" 
                            class="flex-1 bg-[#4F5B69] hover:bg-[#3d4752] text-white py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-all active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah <span x-text="formatPrice(selectedProduct?.harga * detailQty)"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>