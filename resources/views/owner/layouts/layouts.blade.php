<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner - My Fried Chiken</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #F3F4F6; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased text-gray-800" x-data="{ sidebarOpen: true }" x-cloak>

    @include('owner.components.sidebar')

    <div class="transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">
        
        <header class="h-16 bg-white border-b border-gray-200 flex justify-between items-center px-8 sticky top-0 z-10">
            <div class="flex items-center gap-3 text-gray-400">
                <button @click="sidebarOpen = !sidebarOpen" class="hover:text-gray-600 transition-colors p-1.5">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <h1 class="font-semibold text-gray-800 text-sm">Kelola Menu</h1>
            </div>

            <div class="flex items-center gap-2.5 bg-gray-50 px-3.5 py-1.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100 transition">
                <div class="w-7 h-7 bg-slate-400 rounded-full flex items-center justify-center text-white text-[10px]">
                    <i class="fa-solid fa-user"></i>
                </div>
                <span class="text-xs font-semibold text-gray-700">Owner</span>
                <i class="fa-solid fa-chevron-down text-[9px] text-gray-400"></i>
            </div>
        </header>

        <main class="p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>