<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Fried Chiken - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { 
            font-family: 'Inter', sans-serif; 
            background: #F5F5F7;
        }
        /* Animasi transisi lebar sidebar */
        .sidebar-transition {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        /* Menyembunyikan text saat sidebar kecil agar tidak overflow */
        .sidebar-collapsed .sidebar-text {
            display: none;
        }
    </style>
</head>
<body>
    <div class="flex min-h-screen overflow-hidden">
        <aside id="sidebar" class="sidebar-transition w-64 bg-white flex flex-col border-r border-gray-100 shrink-0">
            <div class="px-6 py-6 flex items-center gap-3 overflow-hidden">
                <div class="w-10 h-10 bg-[#9CA3AF] rounded-lg flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-cube text-white text-lg"></i>
                </div>
                <span class="sidebar-text font-bold text-base text-[#6B7280] whitespace-nowrap">My Fried Chicken</span>
            </div>
            
            <nav class="flex-1 px-4 pt-2 overflow-y-auto overflow-x-hidden">
                <p class="sidebar-text text-[10px] font-semibold text-[#9CA3AF] uppercase tracking-wider mb-3 px-3 whitespace-nowrap">Main Menu</p>
                
                <div class="flex flex-col gap-1">
                    <a href="{{ url('/dapur') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all {{ Request::is('dapur') ? 'bg-[#E5E7EB] text-[#374151]' : 'text-[#9CA3AF] hover:bg-gray-50' }}">
                        <i class="fa-solid fa-file-lines text-lg shrink-0 w-6 text-center"></i>
                        <span class="sidebar-text font-medium text-sm whitespace-nowrap">Pesanan</span>
                    </a>
                    
                    <a href="{{ url('/dapur/stok') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all {{ Request::is('dapur/stok') ? 'bg-[#E5E7EB] text-[#374151]' : 'text-[#9CA3AF] hover:bg-gray-50' }}">
                        <i class="fa-solid fa-box-open text-lg shrink-0 w-6 text-center"></i>
                        <span class="sidebar-text font-medium text-sm whitespace-nowrap">Stok</span>
                    </a>
                </div>
            </nav>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
            <header class="h-16 bg-white flex items-center justify-between px-8 shrink-0 border-b border-gray-50">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-lg text-[#6B7280] hover:bg-gray-100 transition-colors">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-[#374151]">@yield('title')</h1>
                </div>
                
                <div class="flex items-center gap-3 bg-[#F3F4F6] pl-2 pr-4 py-1.5 rounded-full cursor-pointer hover:bg-gray-200 transition-all">
                    <div class="w-8 h-8 bg-[#9CA3AF] rounded-full flex items-center justify-center text-white">
                        <i class="fa-solid fa-image text-xs"></i>
                    </div>
                    <span class="font-semibold text-sm text-[#374151]">Dapur</span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-[#9CA3AF]"></i>
                </div>
            </header>

            <div class="flex-1 px-8 py-6 overflow-auto">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const isCollapsed = sidebar.classList.contains('w-64');
            
            if (isCollapsed) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20', 'sidebar-collapsed');
            } else {
                sidebar.classList.remove('w-20', 'sidebar-collapsed');
                sidebar.classList.add('w-64');
            }
        }
    </script>
</body>
</html>