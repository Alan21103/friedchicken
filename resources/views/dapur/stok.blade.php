@extends('layouts.dapur')

@section('title', 'Stok')

@section('content')
<style>
    body {
        background-color: #EDEDED !important;
    }
</style>

<div class="grid grid-cols-4 gap-5 mb-8">
    @php
        $statsStok = [
            ['label' => 'Total Menu', 'val' => '29', 'icon' => 'fa-box', 'iconBg' => '#F08606', 'border' => '#332B2B'],
            ['label' => 'Total Antrean', 'val' => '6', 'icon' => 'fa-arrow-trend-up', 'iconBg' => '#518EC8', 'border' => '#332B2B'],
            ['label' => 'Stok Rendah', 'val' => '10', 'icon' => 'fa-triangle-exclamation', 'iconBg' => '#C81515', 'border' => '#332B2B'],
            ['label' => 'Stok Aman', 'val' => '18', 'icon' => 'fa-circle-check', 'iconBg' => '#2ABE2A', 'border' => '#332B2B'],
        ];
    @endphp
    @foreach($statsStok as $stat)
    <div class="rounded-3xl px-6 py-5 border-l-[6px] shadow-sm" style="background-color: #F5F1EE; border-color: {{ $stat['border'] }}">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0" style="background-color: {{ $stat['iconBg'] }}">
                <i class="fa-solid {{ $stat['icon'] }} text-white text-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-bold text-[#374151] leading-none mb-1">{{ $stat['val'] }}</p>
                <p class="text-xs text-[#6B7280] font-medium">{{ $stat['label'] }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="rounded-2xl overflow-hidden shadow-sm border border-gray-100" style="background-color: #F5F1EE;">
    <div class="px-8 py-6 flex justify-between items-center border-b border-gray-100">
        <h2 class="text-base font-bold text-[#374151] uppercase tracking-wide">List Menu dan Stok</h2>
        <div class="flex gap-3">
            <div class="relative inline-block text-left group">
                <button type="button" class="bg-white px-4 py-2 rounded-lg font-semibold text-sm text-[#374151] flex items-center gap-2 hover:bg-gray-50 border border-transparent focus:border-gray-200 transition">
                    <i class="fa-solid fa-filter text-xs"></i> 
                    <span id="filterLabel">Semua</span>
                    <i class="fa-solid fa-chevron-down text-[10px] ml-1"></i>
                </button>
                <div class="hidden group-focus-within:block group-hover:block absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                    <ul class="py-1">
                        <li><button onclick="applyFilter('Semua')" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">Semua</button></li>
                        <li><button onclick="applyFilter('Makanan')" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-t border-gray-50 transition">Makanan</button></li>
                        <li><button onclick="applyFilter('Paket')" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-t border-gray-50 transition">Paket</button></li>
                        <li><button onclick="applyFilter('Minuman')" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-t border-gray-50 transition">Minuman</button></li>
                    </ul>
                </div>
            </div>
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-[#9CA3AF] text-xs"></i>
                <input type="text" id="searchInput" onkeyup="handleSearch()" placeholder="Search" class="pl-10 pr-4 py-2 bg-white rounded-lg w-48 text-sm focus:outline-none border border-transparent focus:border-gray-300 transition-all">
            </div>
        </div>
    </div>

    <div id="tableContainer" class="overflow-x-auto">
        <table class="w-full table-fixed">
            <thead>
                <tr class="border-b border-gray-100 h-16" style="background-color: #F5F1EE;">
                    <th class="w-[10%] px-6 py-5 text-left text-[10px] font-bold text-[#9CA3AF] uppercase tracking-wider">Kode</th>
                    <th class="w-[28%] px-6 py-5 text-left text-[10px] font-bold text-[#9CA3AF] uppercase tracking-wider">Menu</th>
                    <th class="w-[12%] px-6 py-5 text-left text-[10px] font-bold text-[#9CA3AF] uppercase tracking-wider">Kategori</th>
                    <th class="w-[8%] px-6 py-5 text-left text-[10px] font-bold text-[#9CA3AF] uppercase tracking-wider">Stok</th>
                    <th class="w-[14%] px-6 py-5 text-left text-[10px] font-bold text-[#9CA3AF] uppercase tracking-wider">Antrean</th>
                    <th class="w-[14%] px-6 py-5 text-left text-[10px] font-bold text-[#9CA3AF] uppercase tracking-wider">Status</th>
                    <th class="w-[14%] px-6 py-5 text-left text-[10px] font-bold text-[#9CA3AF] uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="stokBody">
                @foreach($stok as $s)
                @php
                    $isPaket = str_contains(strtolower($s['menu']), 'panas') || str_contains(strtolower($s['menu']), 'pamer');
                    $catFinal = $isPaket ? 'Paket' : $s['kategori'];
                    $isRendah = strtolower($s['status']) === 'rendah';
                    $statusBg = $isRendah ? 'rgba(200, 21, 21, 0.23)' : 'rgba(42, 190, 42, 0.23)';
                    $statusColor = $isRendah ? '#C81515' : '#2ABE2A';
                @endphp
                <tr class="stok-row border-b border-gray-50 hover:bg-white/50 transition cursor-pointer h-[72px]" 
                    data-kategori="{{ $catFinal }}"
                    style="background-color: #F5F1EE;"
                    onclick="openDetailModal({{ json_encode($s) }}, '{{ $catFinal }}')">
                    <td class="px-6 py-5 text-sm font-bold text-[#374151] truncate">{{ $s['kode'] }}</td>
                    <td class="px-6 py-5 text-sm font-medium text-[#374151] menu-name truncate">{{ $s['menu'] }}</td>
                    <td class="px-6 py-5 text-sm text-[#6B7280] truncate">{{ $catFinal }}</td>
                    <td class="px-6 py-5 text-sm font-semibold text-[#374151]">{{ $s['jumlah'] }}</td>
                    <td class="px-6 py-5 text-sm text-[#374151]">{{ $s['antrean'] }} Pesanan</td>
                    <td class="px-6 py-5">
                        <span class="px-5 py-1.5 rounded-full text-[10px] font-bold uppercase inline-block whitespace-nowrap" 
                              style="background-color: {{ $statusBg }}; color: {{ $statusColor }}">
                            {{ $s['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <button class="bg-white px-4 py-2 rounded-lg text-sm font-semibold text-[#374151] flex items-center gap-2 hover:bg-gray-50 transition border border-gray-200" 
                            onclick="event.stopPropagation(); openDetailModal({{ json_encode($s) }}, '{{ $catFinal }}')">
                            <i class="fa-solid fa-file-lines text-xs"></i> <span class="hidden xl:inline">Catatan</span>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-10 flex justify-between items-center text-[#9CA3AF]">
    <p class="font-medium text-sm">
        Showing <span id="startRange" class="text-black font-bold">0</span>-<span id="endRange" class="text-black font-bold">0</span> of <span id="totalItems">0</span> result
    </p>
    <div class="flex gap-2 items-center">
        <button onclick="goToPage(currentPage - 1)" id="prevBtn" class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-[#374151] hover:bg-gray-50 disabled:opacity-30 disabled:cursor-not-allowed transition shadow-sm">
            <i class="fa-solid fa-chevron-left text-xs"></i>
        </button>
        
        <div id="paginationButtons" class="flex gap-2"></div>

        <button onclick="goToPage(currentPage + 1)" id="nextBtn" class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-[#374151] hover:bg-gray-50 disabled:opacity-30 disabled:cursor-not-allowed transition shadow-sm">
            <i class="fa-solid fa-chevron-right text-xs"></i>
        </button>
    </div>
</div>

<div id="detailStokModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 p-4" onclick="closeDetailModal()">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl relative" onclick="event.stopPropagation()">
        
        <button onclick="closeDetailModal()" class="absolute -top-4 -right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition shadow-xl z-20 border border-gray-100">
            <i class="fa-solid fa-xmark text-[#332B2B] text-lg font-bold"></i>
        </button>

        <div class="bg-[#332B2B] p-6 pb-5">
            <div class="flex items-start gap-4 mb-5">
                <div class="w-14 h-14 bg-[#423D3D] rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-utensils text-white text-xl"></i>
                </div>
                <div class="flex-1">
                    <h2 id="modalMenuTitle" class="text-xl font-bold text-white mb-2 uppercase leading-tight">MENU NAME</h2>
                    <div class="flex gap-2 mt-2" id="modalBadges"></div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="bg-[#3A3A3A] rounded-2xl p-4 flex items-center gap-3">
                    <div class="w-14 h-14 bg-[#F08606] rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-box text-white text-2xl"></i>
                    </div>
                    <div>
                        <p id="modalStokQty" class="text-3xl font-black text-white leading-none mb-1">0</p>
                        <p class="text-xs text-white/70 font-medium">Stok Tersedia</p>
                    </div>
                </div>
                <div class="bg-[#3A3A3A] rounded-2xl p-4 flex items-center gap-3">
                    <div class="w-14 h-14 bg-[#518EC8] rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-arrow-trend-up text-white text-2xl"></i>
                    </div>
                    <div>
                        <p id="modalAntreanQty" class="text-3xl font-black text-white leading-none mb-1">0</p>
                        <p class="text-xs text-white/70 font-medium">Dalam Antrean</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 pb-6 pt-5 text-[#374151]">
            <h4 id="modalAntreanTitle" class="text-xs font-bold text-[#9CA3AF] uppercase tracking-wider mb-4">Pesanan Masuk (0)</h4>
            <div id="modalOrderList" class="space-y-3 max-h-[350px] overflow-y-auto pr-2"></div>
        </div>
    </div>
</div>

<script>
let currentPage = 1;
const itemsPerPage = 12;
let currentFilter = 'Semua';
let searchQuery = '';

function updateTable() {
    const rows = Array.from(document.querySelectorAll('.stok-row'));
    const filteredRows = rows.filter(row => {
        const menuName = row.querySelector('.menu-name').innerText.toLowerCase();
        const kategori = row.getAttribute('data-kategori');
        const matchesFilter = (currentFilter === 'Semua' || kategori === currentFilter);
        const matchesSearch = menuName.includes(searchQuery.toLowerCase());
        return matchesFilter && matchesSearch;
    });

    const totalItems = filteredRows.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage) || 1;
    if (currentPage > totalPages) currentPage = totalPages;

    rows.forEach(row => row.classList.add('hidden'));
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const displayedRows = filteredRows.slice(start, end);
    displayedRows.forEach(row => row.classList.remove('hidden'));

    const tableContainer = document.getElementById('tableContainer');
    const minHeight = Math.max(displayedRows.length * 72, 72);
    tableContainer.style.minHeight = minHeight + 'px';

    renderPagination(totalPages, totalItems, start, end);
}

function renderPagination(totalPages, totalItems, start, end) {
    const container = document.getElementById('paginationButtons');
    const startRange = document.getElementById('startRange');
    const endRange = document.getElementById('endRange');
    const totalDisplay = document.getElementById('totalItems');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    const actualEnd = Math.min(end, totalItems);
    startRange.innerText = totalItems > 0 ? start + 1 : 0;
    endRange.innerText = actualEnd;
    totalDisplay.innerText = totalItems;

    prevBtn.disabled = currentPage <= 1;
    nextBtn.disabled = currentPage >= totalPages || totalItems === 0;

    let html = '';
    for (let i = 1; i <= totalPages; i++) {
        const activeStyle = i === currentPage 
            ? 'background-color: #332B2B; color: white;' 
            : 'background-color: white; color: #374151; border: 1px solid #E5E7EB;';
        html += `<button onclick="goToPage(${i})" class="w-10 h-10 flex items-center justify-center rounded-lg font-bold text-sm transition" style="${activeStyle}">${i}</button>`;
    }
    container.innerHTML = html;
}

function goToPage(page) {
    currentPage = page;
    updateTable();
}

function applyFilter(cat) {
    currentFilter = cat;
    document.getElementById('filterLabel').innerText = cat;
    currentPage = 1;
    updateTable();
}

function handleSearch() {
    searchQuery = document.getElementById('searchInput').value;
    currentPage = 1;
    updateTable();
}

function openDetailModal(data, category) {
    document.getElementById('modalMenuTitle').innerText = data.menu;
    document.getElementById('modalStokQty').innerText = data.jumlah;
    document.getElementById('modalAntreanQty').innerText = data.antrean;
    document.getElementById('modalAntreanTitle').innerText = `Pesanan Masuk (${data.antrean})`;

    const isRendah = data.status.toLowerCase() === 'rendah';
    const statusBg = isRendah ? 'rgba(200, 21, 21, 0.23)' : 'rgba(42, 190, 42, 0.23)';
    const statusColor = isRendah ? '#C81515' : '#2ABE2A';

    document.getElementById('modalBadges').innerHTML = `
        <div class="bg-[#423D3D] text-white px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-tighter">${category}</div>
        <div class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-tighter" style="background-color: ${statusBg}; color: ${statusColor}">${data.status}</div>
    `;

    const list = document.getElementById('modalOrderList');
    list.innerHTML = '';

    if (data.antrean > 0) {
        for (let i = 1; i <= data.antrean; i++) {
            list.innerHTML += `
                <div class="bg-[#332B2B] rounded-2xl p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-[#423D3D] rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-bag-shopping text-white text-base"></i>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-white mb-0.5 uppercase">PSN-00${i}</h5>
                            <p class="text-[10px] text-white/70 flex items-center gap-1.5 font-medium">
                                <i class="fa-regular fa-clock"></i> Order 15:${10+i}
                            </p>
                        </div>
                    </div>
                    <div class="bg-[#423D3D] text-white px-4 py-2 rounded-xl">
                        <span class="text-sm font-bold uppercase">X 1</span>
                    </div>
                </div>`;
        }
    } else {
        list.innerHTML = '<div class="text-center py-10 text-gray-400 text-sm font-medium italic">Tidak ada antrean pesanan</div>';
    }

    document.getElementById('detailStokModal').classList.replace('hidden', 'flex');
    document.body.style.overflow = 'hidden';
}

function closeDetailModal() {
    document.getElementById('detailStokModal').classList.replace('flex', 'hidden');
    document.body.style.overflow = 'auto';
}

document.addEventListener('DOMContentLoaded', updateTable);
</script>
@endsection