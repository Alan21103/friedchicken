<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - My Fried Chiken</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        /* Background body dibuat sangat cerah dan netral agar kontras dengan sidebar krem */
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #FDFCFB; 
        }
        
        [x-cloak] { display: none !important; }

        /* Menghilangkan spinner bawaan browser pada input number */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
          -webkit-appearance: none; 
          margin: 0; 
        }

        /* Scrollbar kustom agar tetap minimalis */
        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #FDFCFB;
        }
        ::-webkit-scrollbar-thumb {
            background: #E6D5B8;
            border-radius: 10px;
        }
    </style>
</head>
<body class="antialiased text-[#332B2B]" x-data="{ sidebarOpen: true }" x-cloak>

    @include('owner.components.sidebar')

    <div class="transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">
        <header class="h-20 bg-white/80 backdrop-blur-md flex justify-between items-center px-8 sticky top-0 z-10 shadow-sm">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="text-[#4A3F3F] hover:text-[#332B2B] transition-colors p-2 rounded-xl hover:bg-[#E6D5B8]/20">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div>
                    <p class="text-[10px] font-bold text-[#E6D5B8] uppercase tracking-[0.2em] leading-none mb-1">Halaman</p>
                    <h1 class="font-bold text-[#332B2B] text-base">@yield('title')</h1>
                </div>
            </div>

            <div class="relative" x-data="{ userOpen: false }">
                <div @click="userOpen = !userOpen" @click.away="userOpen = false" 
                    class="flex items-center gap-3 bg-white px-4 py-2 rounded-2xl border border-[#E6D5B8]/30 cursor-pointer hover:shadow-md hover:border-[#E6D5B8] transition-all duration-300 group">
                    <div class="w-8 h-8 bg-[#332B2B] rounded-full flex items-center justify-center text-[#E6D5B8] text-[11px] shadow-sm group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-[#332B2B]">Owner</span>
                        <span class="text-[9px] text-[#4A3F3F]/60 font-medium">Administrator</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[9px] text-[#E6D5B8] transition-transform duration-300 ml-1"
                       :class="userOpen ? 'rotate-180' : ''"></i>
                </div>

                <div x-show="userOpen" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                    class="absolute right-0 mt-3 w-52 bg-white rounded-2xl shadow-2xl border border-[#E6D5B8]/20 py-3 z-50 overflow-hidden"
                    x-cloak>
                    
                    <div class="px-5 py-2 mb-2">
                        <p class="text-[9px] font-black text-[#E6D5B8] uppercase tracking-widest">Sesi Aktif</p>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                            class="w-full text-left px-5 py-3 text-[13px] font-bold text-red-400 hover:bg-red-50 transition-colors flex items-center gap-3 group">
                            <div class="w-7 h-7 bg-red-50 rounded-lg flex items-center justify-center group-hover:bg-red-100 transition-colors">
                                <i class="fa-solid fa-power-off text-[10px]"></i>
                            </div>
                            <span>Keluar Panel</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="p-10">
            @yield('content')
        </main>
    </div>

</body>
</html>