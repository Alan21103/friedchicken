<nav class="bg-[#F5F1EE] border-b border-[#332B2B]/10 px-6 py-3 flex items-center justify-between shadow-sm flex-shrink-0">
    <div class="flex items-center gap-3 w-full">
        <div id="logoIcon"
            class="w-11 h-11 bg-[#332B2B] rounded-xl flex items-center justify-center shrink-0 transition-all shadow-sm">
            <i class="fa-solid fa-drumstick-bite text-[#E6D5B8] text-lg"></i>
        </div>
        <span class="sidebar-text font-bold text-base text-[#332B2B] whitespace-nowrap">My Fried Chicken</span>
    </div>

    <div class="flex items-center gap-6">
        <div class="relative" x-data="{ showNotif: false }" @click.away="showNotif = false">
            <button @click="showNotif = !showNotif"
                class="relative text-[#332B2B]/60 hover:text-[#332B2B] transition-colors mt-2 p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>

                <template x-if="lowStockCount > 0">
                    <span class="absolute top-0 right-0 flex h-4 w-4">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#332B2B] opacity-75"></span>
                        <span
                            class="relative inline-flex rounded-full h-4 w-4 bg-[#332B2B] text-[10px] text-[#E6D5B8] items-center justify-center font-black"
                            x-text="lowStockCount"></span>
                    </span>
                </template>
            </button>

            <div x-show="showNotif" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-[#332B2B]/10 z-[60] overflow-hidden">

                <div class="p-4 border-b bg-[#F5F1EE] flex justify-between items-center">
                    <h4 class="font-bold text-[#332B2B]">Notifikasi Stok</h4>
                    <span class="text-[10px] bg-[#332B2B] text-[#E6D5B8] px-2 py-0.5 rounded-full font-bold"
                        x-text="lowStockCount + ' Produk'"></span>
                </div>

                <div class="max-h-64 overflow-y-auto">
                    <template x-if="lowStockCount > 0">
                        <template x-for="item in lowStockItems" :key="item.id">
                            <div
                                class="p-4 border-b border-[#F5F1EE] last:border-0 hover:bg-[#F5F1EE]/50 transition-colors flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-[#332B2B]" x-text="item.nama"></p>
                                    <p class="text-xs text-gray-500">Sisa Stok: <span class="text-red-600 font-bold"
                                            x-text="item.stok"></span></p>
                                </div>
                            </div>
                        </template>
                    </template>

                    <template x-if="lowStockCount === 0">
                        <div class="p-8 text-center bg-white">
                            <svg class="w-12 h-12 text-[#F5F1EE] mx-auto mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm text-[#332B2B]/40 font-medium">Semua stok terpantau aman.</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="relative" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open"
                class="flex items-center gap-2 hover:bg-[#332B2B]/5 transition-all rounded-lg py-1 px-2 border border-transparent"
                :class="open ? 'bg-[#332B2B]/5 border-[#332B2B]/10' : ''">
                <div
                    class="w-9 h-9 bg-[#332B2B] rounded-full flex items-center justify-center text-[#E6D5B8] shadow-sm overflow-hidden border-2 border-white">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                    </svg>
                </div>
                <div class="text-left hidden sm:block">
                    <span class="text-xs block text-[#332B2B]/40 font-medium leading-none mb-1">Petugas</span>
                    <span class="text-sm font-bold text-[#332B2B] tracking-wide uppercase">Kasir</span>
                </div>
                <svg class="w-4 h-4 text-[#332B2B]/30 transition-transform duration-300" :class="open ? 'rotate-180' : ''"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border border-[#332B2B]/10 py-2 z-50">

                <div class="px-4 py-2 border-b border-gray-100 mb-1">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Sesi Aktif</p>
                    <p class="text-sm font-bold text-[#332B2B]">Admin Kasir</p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 font-bold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Logout System
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>