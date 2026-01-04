@extends('layouts.dapur')

@section('title', 'Stok')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-3xl px-6 py-5 border-l-[6px] border-black">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-black rounded-2xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-box text-white text-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-bold text-[#374151] leading-none mb-1">29</p>
                <p class="text-xs text-[#6B7280] font-medium">Total Menu</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-3xl px-6 py-5 border-l-[6px] border-black">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-black rounded-2xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-arrow-trend-up text-white text-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-bold text-[#374151] leading-none mb-1">6</p>
                <p class="text-xs text-[#6B7280] font-medium">Total Antrean</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-3xl px-6 py-5 border-l-[6px] border-black">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-black rounded-2xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-triangle-exclamation text-white text-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-bold text-[#374151] leading-none mb-1">10</p>
                <p class="text-xs text-[#6B7280] font-medium">Stok Rendah</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-3xl px-6 py-5 border-l-[6px] border-black">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-black rounded-2xl flex items-center justify-center flex-shrink-0">
                <i class="fa-regular fa-circle-check text-white text-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-bold text-[#374151] leading-none mb-1">18</p>
                <p class="text-xs text-[#6B7280] font-medium">Stok Aman</p>
            </div>
        </div>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-2xl overflow-hidden">
    <!-- Header -->
    <div class="px-8 py-6 flex justify-between items-center border-b border-gray-100">
        <h2 class="text-base font-bold text-[#374151] uppercase tracking-wide">List Menu dan Stok</h2>
        <div class="flex gap-3">
            <button class="bg-white border border-gray-200 px-4 py-2 rounded-lg font-semibold text-sm text-[#374151] flex items-center gap-2 hover:bg-gray-50">
                <i class="fa-solid fa-filter text-xs"></i> Filter
            </button>
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-[#9CA3AF] text-xs"></i>
                <input type="text" placeholder="Search" class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-lg w-48 text-sm focus:outline-none">
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-white border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-[10px] font-bold text-[#9CA3AF] uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold text-[#9CA3AF] uppercase tracking-wider">Menu</th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold text-[#9CA3AF] uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold text-[#9CA3AF] uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold text-[#9CA3AF] uppercase tracking-wider">Antrean</th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold text-[#9CA3AF] uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold text-[#9CA3AF] uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stok as $s)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition cursor-pointer" onclick="openDetailModal('{{ $s['kode'] }}', '{{ $s['menu'] }}')">
                    <td class="px-6 py-4 text-sm font-bold text-[#374151]">{{ $s['kode'] }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-[#374151]">{{ $s['menu'] }}</td>
                    <td class="px-6 py-4 text-sm text-[#6B7280]">{{ $s['kategori'] }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-[#374151]">{{ $s['jumlah'] }}</td>
                    <td class="px-6 py-4 text-sm text-[#374151]">{{ $s['antrean'] }} Pesanan</td>
                    <td class="px-6 py-4">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase inline-block
                            {{ $s['status'] == 'Rendah' ? 'bg-[#E5E7EB] text-[#374151]' : 'bg-[#E5E7EB] text-[#374151]' }}">
                            {{ $s['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <button class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-semibold text-[#374151] flex items-center gap-2 hover:bg-gray-50 transition" onclick="event.stopPropagation(); openDetailModal('{{ $s['kode'] }}', '{{ $s['menu'] }}')">
                            <i class="fa-solid fa-file-lines text-[10px]"></i> Catatan
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-10 flex justify-between items-center text-[#9CA3AF]">
    <p class="font-medium text-sm">Showing 1-9 of 57 result</p>
    <div class="flex gap-2">
        <button class="w-10 h-10 flex items-center justify-center bg-black text-white rounded-lg font-bold text-sm hover:bg-gray-800 transition">1</button>
        <button class="w-10 h-10 flex items-center justify-center bg-white text-[#374151] rounded-lg font-semibold text-sm hover:bg-gray-50 transition">2</button>
        <button class="w-10 h-10 flex items-center justify-center bg-white text-[#374151] rounded-lg font-semibold text-sm hover:bg-gray-50 transition">3</button>
        <span class="px-2 flex items-center text-sm">...</span>
        <button class="w-10 h-10 flex items-center justify-center bg-white text-[#374151] rounded-lg font-semibold text-sm hover:bg-gray-50 transition">10</button>
        <button class="w-10 h-10 flex items-center justify-center bg-white text-[#374151] rounded-lg font-semibold text-sm hover:bg-gray-50 transition"><i class="fa-solid fa-chevron-right text-xs"></i></button>
    </div>
</div>

<!-- Modal Detail Stok -->
<div id="detailStokModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 p-4" onclick="closeDetailModal()">
    <div class="bg-white rounded-3xl w-full max-w-xl shadow-2xl relative overflow-hidden" onclick="event.stopPropagation()">
        <!-- Close Button -->
        <button onclick="closeDetailModal()" class="absolute top-4 right-4 w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition z-10">
            <i class="fa-solid fa-xmark text-gray-700 text-base font-bold"></i>
        </button>

        <!-- Header with Gray Background -->
        <div class="bg-gray-100 p-6 pb-5">
            <div class="flex items-start gap-4 mb-5">
                <div class="w-14 h-14 bg-black rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-utensils text-white text-xl"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-[#374151] mb-1">AYAM KRISPY</h2>
                    <div class="flex gap-2 mt-2">
                        <div class="bg-black text-white px-3 py-1 rounded-lg text-[10px] font-bold uppercase">
                            Makanan
                        </div>
                        <div class="bg-black text-white px-3 py-1 rounded-lg text-[10px] font-bold uppercase">
                            Cukup
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-[#BCC1CA] rounded-2xl p-4 flex items-center gap-3">
                    <div class="w-11 h-11 bg-black rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-box text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-[#374151] leading-none mb-0.5">16</p>
                        <p class="text-[10px] text-[#374151] font-semibold">Stok Tersedia</p>
                    </div>
                </div>
                <div class="bg-[#BCC1CA] rounded-2xl p-4 flex items-center gap-3">
                    <div class="w-11 h-11 bg-black rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-arrow-trend-up text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-[#374151] leading-none mb-0.5">8</p>
                        <p class="text-[10px] text-[#374151] font-semibold">Dalam Antrean</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="px-6 pb-6 pt-5">
            <h4 class="text-xs font-bold text-[#9CA3AF] uppercase tracking-wider mb-4">Pesanan Masuk (3)</h4>
            
            <div class="space-y-3">
                <!-- Order Item 1 -->
                <div class="bg-gray-100 rounded-2xl p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-black rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-bag-shopping text-white text-base"></i>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-[#374151] mb-0.5">PSN-001</h5>
                            <p class="text-xs text-[#6B7280] flex items-center gap-1.5">
                                <i class="fa-regular fa-clock text-[10px]"></i> Order 16.00
                            </p>
                        </div>
                    </div>
                    <div class="bg-black text-white px-4 py-2 rounded-xl flex items-center gap-2">
                        <i class="fa-solid fa-fire-burner text-sm"></i>
                        <span class="text-sm font-bold">X 2</span>
                    </div>
                </div>

                <!-- Order Item 2 -->
                <div class="bg-gray-100 rounded-2xl p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-black rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-utensils text-white text-base"></i>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-[#374151] mb-0.5">PSN-002</h5>
                            <p class="text-xs text-[#6B7280] flex items-center gap-1.5">
                                <i class="fa-regular fa-clock text-[10px]"></i> Order 12.00
                            </p>
                        </div>
                    </div>
                    <div class="bg-black text-white px-4 py-2 rounded-xl flex items-center gap-2">
                        <i class="fa-solid fa-fire-burner text-sm"></i>
                        <span class="text-sm font-bold">X 1</span>
                    </div>
                </div>

                <!-- Order Item 3 -->
                <div class="bg-gray-100 rounded-2xl p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-black rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-bag-shopping text-white text-base"></i>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-[#374151] mb-0.5">PSN-004</h5>
                            <p class="text-xs text-[#6B7280] flex items-center gap-1.5">
                                <i class="fa-regular fa-clock text-[10px]"></i> Order 06.00
                            </p>
                        </div>
                    </div>
                    <div class="bg-black text-white px-4 py-2 rounded-xl flex items-center gap-2">
                        <i class="fa-solid fa-fire-burner text-sm"></i>
                        <span class="text-sm font-bold">X 1</span>
                    </div>
                </div>

                <!-- Order Item 4 -->
                <div class="bg-gray-100 rounded-2xl p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-black rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-utensils text-white text-base"></i>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-[#374151] mb-0.5">PSN-010</h5>
                            <p class="text-xs text-[#6B7280] flex items-center gap-1.5">
                                <i class="fa-regular fa-clock text-[10px]"></i> Order 14.00
                            </p>
                        </div>
                    </div>
                    <div class="bg-black text-white px-4 py-2 rounded-xl flex items-center gap-2">
                        <i class="fa-solid fa-fire-burner text-sm"></i>
                        <span class="text-sm font-bold">X 2</span>
                    </div>
                </div>

                <!-- Order Item 5 -->
                <div class="bg-gray-100 rounded-2xl p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-black rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-utensils text-white text-base"></i>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-[#374151] mb-0.5">PSN-012</h5>
                            <p class="text-xs text-[#6B7280] flex items-center gap-1.5">
                                <i class="fa-regular fa-clock text-[10px]"></i> Order 11.00
                            </p>
                        </div>
                    </div>
                    <div class="bg-black text-white px-4 py-2 rounded-xl flex items-center gap-2">
                        <i class="fa-solid fa-fire-burner text-sm"></i>
                        <span class="text-sm font-bold">X 2</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openDetailModal(kode, menu) {
    document.getElementById('detailStokModal').classList.remove('hidden');
    document.getElementById('detailStokModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeDetailModal() {
    document.getElementById('detailStokModal').classList.add('hidden');
    document.getElementById('detailStokModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Close modal dengan ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDetailModal();
    }
});
</script>
@endsection