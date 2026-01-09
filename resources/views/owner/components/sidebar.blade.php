<aside
    x-show="sidebarOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="w-64 bg-white h-screen border-r border-gray-100 fixed left-0 top-0 overflow-y-auto z-20 shadow-sm"
    x-data="{ 
        subMenuOpen: {{ request()->routeIs('owner.menu.*', 'owner.kategori.*', 'owner.predikat.*', 'owner.pajak.*') ? 'true' : 'false' }} 
    }">
    
    <div class="px-6 py-7 flex items-center gap-3 border-b border-gray-50/50">
        <div class="w-10 h-10 flex items-center justify-center shrink-0 overflow-hidden">
            <img src="{{ asset('images/navbar-logo.png') }}" 
                 alt="Logo" 
                 class="w-full h-full object-contain transform scale-125">
        </div>
        <div class="flex flex-col justify-center">
            <span class="font-black text-[#332B2B] text-[15px] tracking-tighter leading-none">
                My Fried Chicken
            </span>
            <span class="text-[9px] font-bold text-[#4A3F3F]/40 uppercase tracking-[0.1em] mt-1">
                Owner Dashboard
            </span>
        </div>
    </div>

    <nav class="mt-6 px-4">
        <p class="text-[10px] font-black text-[#4A3F3F]/40 uppercase tracking-[0.2em] mb-4 px-2">Main Menu</p>

        <div class="space-y-1.5">
            <div>
                <button @click="subMenuOpen = !subMenuOpen"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 outline-none group"
                    :class="subMenuOpen ? 'bg-[#332B2B] text-[#E6D5B8] shadow-lg shadow-[#332B2B]/20' : 'text-[#4A3F3F] hover:bg-[#E6D5B8]/30'">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-utensils text-sm w-5 transition-transform group-hover:scale-110"></i>
                        <span class="text-sm font-bold tracking-tight">Manajemen Menu</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[9px] transition-transform duration-300"
                        :class="subMenuOpen ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="subMenuOpen" x-collapse class="mt-1.5 space-y-1 pl-1">
                    @php
                        $subMenus = [
                            ['route' => 'owner.menu.index', 'label' => 'Kelola Menu', 'icon' => 'fa-burger'],
                            ['route' => 'owner.kategori.index', 'label' => 'Kelola Kategori', 'icon' => 'fa-shapes'],
                            ['route' => 'owner.predikat.index', 'label' => 'Kelola Predikat', 'icon' => 'fa-tag'],
                            ['route' => 'owner.pajak.pajak', 'label' => 'Pajak & Service Fee', 'icon' => 'fa-percent', 'isSpecial' => true],
                        ];
                    @endphp

                    @foreach($subMenus as $sub)
                    <a href="{{ route($sub['route']) }}"
                        class="flex items-center gap-3 px-5 py-2.5 rounded-xl text-[13px] transition duration-200 
                        {{ request()->routeIs($sub['route']) ? 'text-[#332B2B] font-bold bg-[#E6D5B8]/40' : 'text-[#4A3F3F]/70 hover:text-[#332B2B] hover:bg-[#E6D5B8]/20' }}">
                        @if(isset($sub['isSpecial']))
                            <div class="flex items-center justify-center border-2 border-current rounded p-[1px] w-4 h-4">
                                <i class="fa-solid {{ $sub['icon'] }} text-[8px]"></i>
                            </div>
                        @else
                            <i class="fa-solid {{ $sub['icon'] }} text-base w-5 text-center"></i>
                        @endif
                        <span class="tracking-tight">{{ $sub['label'] }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            @php
                $mainMenus = [
                    ['route' => 'owner.keuntungan.index', 'label' => 'Progress Keuntungan', 'icon' => 'fa-chart-line'],
                    ['route' => 'owner.tren.index', 'label' => 'Tren Menu', 'icon' => 'fa-arrow-trend-up'],
                ];
            @endphp

            @foreach($mainMenus as $menu)
            <a href="{{ route($menu['route']) }}"
                @click="subMenuOpen = false"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 text-sm 
                {{ request()->routeIs($menu['route']) ? 'bg-[#332B2B] text-[#E6D5B8] shadow-lg shadow-[#332B2B]/20 font-bold' : 'text-[#4A3F3F] hover:bg-[#E6D5B8]/30 hover:text-[#332B2B]' }}">
                <i class="fa-solid {{ $menu['icon'] }} text-sm w-5 text-center transition-transform hover:scale-110"></i>
                <span class="tracking-tight">{{ $menu['label'] }}</span>
            </a>
            @endforeach
        </div>
    </nav>
</aside>