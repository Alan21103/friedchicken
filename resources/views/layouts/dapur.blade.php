<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Fried Chicken - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { 
            font-family: 'Inter', sans-serif; 
            background: #EDEDED;
        }
        .sidebar-transition {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        /* Menghilangkan teks saat sidebar ditutup */
        .sidebar-collapsed .sidebar-text {
            display: none;
            opacity: 0;
            width: 0;
        }
        .menu-item:hover, .menu-item.active {
            background-color: rgba(29, 23, 23, 0.85) !important;
            color: white !important;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 0px; }
    </style>
</head>
<body>
    <div class="flex min-h-screen overflow-hidden">
        
        <aside id="sidebar" class="sidebar-transition w-64 flex flex-col border-r border-gray-100 shrink-0" style="background-color: #F5F1EE;">
            <div class="h-24 flex items-center px-4 overflow-hidden">
                <div id="logoWrapper" class="flex items-center gap-3 w-full transition-all duration-300">
                    <div id="logoIcon" class="w-16 h-16 flex items-center justify-center shrink-0 transition-all overflow-hidden">
                        <img src="{{ asset('images/navbar-logo.png') }}" alt="Logo" class="w-full h-full object-contain scale-110">
                    </div>
                    <span class="sidebar-text font-bold text-base text-[#6B7280] whitespace-nowrap">My Fried Chicken</span>
                </div>
            </div>
            
            <nav class="flex-1 px-3 pt-2 overflow-y-auto custom-scrollbar">
                <p class="sidebar-text text-[10px] font-semibold text-[#9CA3AF] uppercase tracking-wider mb-4 px-4 whitespace-nowrap">Main Menu</p>
                <div class="flex flex-col gap-2">
                    <a href="{{ url('/dapur') }}" class="menu-item flex items-center px-4 py-3 rounded-xl transition-all {{ Request::is('dapur') ? 'active' : 'text-[#9CA3AF]' }}">
                        <div class="w-6 flex justify-center shrink-0">
                            <i class="fa-solid fa-file-lines text-lg"></i>
                        </div>
                        <span class="sidebar-text font-medium text-sm ml-3 whitespace-nowrap">Pesanan</span>
                    </a>
                    <a href="{{ url('/dapur/stok') }}" class="menu-item flex items-center px-4 py-3 rounded-xl transition-all {{ Request::is('dapur/stok') ? 'active' : 'text-[#9CA3AF]' }}">
                        <div class="w-6 flex justify-center shrink-0">
                            <i class="fa-solid fa-box-open text-lg"></i>
                        </div>
                        <span class="sidebar-text font-medium text-sm ml-3 whitespace-nowrap">Stok</span>
                    </a>
                </div>
            </nav>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
            
            <header class="h-16 flex items-center justify-between px-8 shrink-0 border-b border-gray-100" style="background-color: #F5F1EE;">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-lg text-[#6B7280] hover:bg-white/50 transition-colors">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-[#374151]">@yield('title')</h1>
                </div>
                
                <div class="relative inline-block text-left group">
                    <button type="button" class="flex items-center gap-3 bg-white pl-2 pr-4 py-1.5 rounded-full cursor-pointer hover:bg-gray-100 transition-all focus:outline-none border border-gray-50">
                        <div class="w-8 h-8 bg-[#332B2B] rounded-full flex items-center justify-center text-white text-[10px]">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <span class="font-semibold text-sm text-[#374151]">Dapur</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-[#9CA3AF]"></i>
                    </button>

                    <div class="hidden group-hover:block absolute right-0 w-52 z-50 pt-2 transition-all">
                        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                            <div class="px-5 py-4 border-b border-gray-50 bg-gray-50/50">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Akses Sistem</p>
                                <p class="text-sm font-extrabold text-[#332B2B]">Dapur</p>
                            </div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-5 py-4 text-sm text-red-600 font-bold hover:bg-red-50 flex items-center gap-3 transition-colors">
                                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                    Keluar Sistem
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 px-8 py-6 overflow-auto" style="background-color: #EDEDED;">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const logoWrapper = document.getElementById('logoWrapper');
            const isFull = sidebar.classList.contains('w-64');
            
            if (isFull) {
                // Saat Menutup (Collapse)
                sidebar.classList.replace('w-64', 'w-20');
                sidebar.classList.add('sidebar-collapsed');
                
                // Membuat logo ke tengah (presisi dengan icon menu)
                logoWrapper.classList.remove('gap-3');
                logoWrapper.classList.add('justify-center');
            } else {
                // Saat Membuka (Expand)
                sidebar.classList.replace('w-20', 'w-64');
                sidebar.classList.remove('sidebar-collapsed');
                
                // Mengembalikan posisi logo ke kiri
                logoWrapper.classList.add('gap-3');
                logoWrapper.classList.remove('justify-center');
            }
        }
    </script>
</body>
</html>