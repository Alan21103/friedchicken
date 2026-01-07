<aside
    x-show="sidebarOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="w-64 bg-white h-screen border-r border-gray-200 fixed left-0 top-0 overflow-y-auto z-20"
    x-data="{ subMenuOpen: true }">
    <div class="p-6 flex items-center gap-2.5 border-b border-gray-100">
        <div class="w-9 h-9 bg-slate-400 rounded-lg flex items-center justify-center text-white">
            <i class="fa-solid fa-drumstick-bite text-lg"></i>
        </div>
        <span class="font-semibold text-gray-600 text-base">My Fried Chiken</span>
    </div>

    <nav class="mt-4 px-4">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3 px-2">Main Menu</p>

        <div class="space-y-0.5">
            <div>
                <button @click="subMenuOpen = !subMenuOpen"
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-all duration-200"
                    :class="subMenuOpen ? 'bg-[#DEE2E6] text-gray-800 font-semibold' : 'text-gray-500 hover:bg-gray-50'">
                    <span class="text-sm">Menu</span>
                    <i class="fa-solid fa-chevron-down text-[9px] transition-transform duration-300"
                        :class="subMenuOpen ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="subMenuOpen" x-collapse class="mt-1 space-y-0.5 pl-1">

                    <a href="{{ route('owner.menu.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[13px] transition duration-200 {{ request()->routeIs('owner.menu.index') ? 'text-gray-800 font-semibold bg-gray-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        <i class="fa-solid fa-burger text-base"></i>
                        <span>Kelola Menu</span>
                    </a>

                    <a href="{{ route('owner.kategori.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[13px] transition duration-200 {{ request()->routeIs('owner.kategori.index') ? 'text-gray-800 font-semibold bg-gray-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        <i class="fa-solid fa-shapes text-base"></i>
                        <span>Kelola Kategori</span>
                    </a>

                    <a href="{{ route('owner.predikat.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[13px] transition duration-200 
   {{ request()->routeIs('owner.predikat.index') ? 'text-gray-800 font-semibold bg-gray-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        <i class="fa-solid fa-tag text-base"></i>
                        <span>Kelola Predikat</span>
                    </a>

                    <a href="#"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[13px] transition duration-200 text-gray-500 hover:text-gray-700 hover:bg-gray-50">
                        <i class="fa-solid fa-percent text-[9px] border-2 border-current rounded p-[2px]"></i>
                        <span>Kelola Pajak & Service Fee</span>
                    </a>
                </div>
            </div>

            <a href="#"
                class="flex items-center gap-3 px-3 py-2.5 text-gray-500 hover:bg-gray-50 hover:text-gray-700 rounded-lg transition duration-200 text-sm">
                <i class="fa-solid fa-chart-line ml-0.5"></i>
                <span>Laporan Penjualan</span>
            </a>
        </div>
    </nav>
</aside>