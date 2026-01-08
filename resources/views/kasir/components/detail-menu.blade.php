<div x-show="showDetail" 
     x-transition.opacity.duration.300ms
     class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-[#332B2B]/60 backdrop-blur-sm" x-cloak>
    
    <div @click.away="showDetail = false" 
         class="bg-white rounded-[28px] w-full max-w-lg overflow-hidden shadow-2xl relative border border-[#332B2B]/5">
        
        <div class="px-6 py-4 border-b border-[#F5F1EE] flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-[#F5F1EE] rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#332B2B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-[#332B2B] uppercase tracking-tight">Detail Menu</h2>
            </div>
            <button @click="showDetail = false" class="p-1.5 hover:bg-[#F5F1EE] rounded-full transition-colors text-[#332B2B]/40 hover:text-[#332B2B]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex flex-col">
            <div class="relative h-56 bg-[#F5F1EE] mx-6 mt-4 rounded-[20px] overflow-hidden">
                <img :src="selectedProduct?.image" class="w-full h-full object-cover">
                
                <div class="absolute top-3 left-3">
                    <span class="px-3 py-1.5 backdrop-blur-md rounded-full text-[10px] font-bold flex items-center gap-1.5 shadow-sm border border-white/20"
                          :class="selectedProduct?.kategori === 'Minuman' || selectedProduct?.kategori === 'Camilan' 
                                  ? 'bg-emerald-500/90 text-white' 
                                  : 'bg-amber-500/90 text-white'">
                        
                        <template x-if="selectedProduct?.kategori === 'Minuman' || selectedProduct?.kategori === 'Camilan'">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" /></svg>
                        </template>
                        <template x-if="selectedProduct?.kategori !== 'Minuman' && selectedProduct?.kategori !== 'Camilan'">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </template>

                        <span x-text="selectedProduct?.kategori === 'Minuman' || selectedProduct?.kategori === 'Camilan' ? 'Cepat' : 'Butuh Waktu'"></span>
                    </span>
                </div>
                
                <template x-if="selectedProduct?.bestSeller">
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1.5 bg-[#E6D5B8] text-[#332B2B] rounded-full text-[10px] font-bold flex items-center gap-1.5 shadow-sm border border-white/20">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                            Best Seller
                        </span>
                    </div>
                </template>
            </div>

            <div class="px-6 py-5">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-xl font-bold text-[#332B2B] uppercase tracking-tight" x-text="selectedProduct?.nama"></h3>
                    <span class="px-2.5 py-1 bg-[#F5F1EE] text-[#332B2B]/60 rounded-lg text-[10px] font-bold uppercase tracking-wider" x-text="selectedProduct?.kategori"></span>
                </div>
                
                <p class="text-[#332B2B]/50 text-sm leading-relaxed mb-5 line-clamp-2" x-text="selectedProduct?.deskripsi"></p>
                
                <div class="flex items-baseline gap-2 mb-6 pt-4 border-t border-[#F5F1EE]">
                    <div class="text-2xl font-black text-[#332B2B]" x-text="formatPrice(selectedProduct?.harga)"></div>
                    <div class="text-[#332B2B]/40 font-bold text-xs uppercase tracking-widest">/ Stok: <span x-text="selectedProduct?.stok"></span></div>
                </div>

                <div class="flex gap-3">
                    <div class="flex items-center bg-[#F5F1EE] rounded-xl p-1 w-32 border border-[#332B2B]/5">
                        <button @click="updateDetailQty(-1)" class="w-9 h-9 flex items-center justify-center bg-white rounded-lg shadow-sm hover:bg-gray-50 text-lg font-bold text-[#332B2B] transition-all active:scale-90">-</button>
                        <span class="flex-1 text-center font-bold text-[#332B2B]" x-text="detailQty"></span>
                        <button @click="updateDetailQty(1)" class="w-9 h-9 flex items-center justify-center bg-white rounded-lg shadow-sm hover:bg-gray-50 text-lg font-bold text-[#332B2B] transition-all active:scale-90">+</button>
                    </div>

                    <button @click="addToCartFromDetail()" 
                            class="flex-1 bg-[#332B2B] hover:bg-[#433939] text-[#E6D5B8] py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-all active:scale-95 shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Konfirmasi Tambah • <span x-text="formatPrice(selectedProduct?.harga * detailQty)"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>