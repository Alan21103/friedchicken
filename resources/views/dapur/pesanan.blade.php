@extends('layouts.dapur')

@section('title', 'Pesanan')

@section('content')
    <div class="grid grid-cols-4 gap-5 mb-8">
        @php
            $statItems = [
                ['label' => 'Total Pesanan', 'val' => '29', 'icon' => 'fa-box'],
                ['label' => 'Menunggu', 'val' => '6', 'icon' => 'fa-clock', 'is_reg' => true],
                ['label' => 'Dimasak', 'val' => '10', 'icon' => 'fa-utensils'],
                ['label' => 'Selesai', 'val' => '18', 'icon' => 'fa-circle-check', 'is_reg' => true],
            ];
        @endphp
        @foreach($statItems as $stat)
        <div class="bg-white rounded-3xl px-6 py-5 border-l-[6px] border-black">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-black rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="{{ isset($stat['is_reg']) ? 'fa-regular' : 'fa-solid' }} {{ $stat['icon'] }} text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-3xl font-bold text-[#374151] leading-none mb-1">{{ $stat['val'] }}</p>
                    <p class="text-xs text-[#6B7280] font-medium">{{ $stat['label'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="text-2xl font-bold text-[#374151] mb-1">List Pesanan</h2>
            <p class="text-xs text-[#9CA3AF]">Klik baris pesanan atau tombol "Detail" untuk melihat dan mengubah status makanan.</p>
        </div>
        <div class="flex gap-3">
            <div class="relative inline-block text-left group">
                <button type="button" class="bg-white px-4 py-2 rounded-lg font-semibold text-sm text-[#374151] flex items-center gap-2 hover:bg-gray-50 border border-transparent focus:border-gray-200">
                    <i class="fa-solid fa-filter text-xs"></i> 
                    <span id="filterLabel">Semua</span>
                    <i class="fa-solid fa-chevron-down text-[10px] ml-1"></i>
                </button>
                <div class="hidden group-focus-within:block absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                    <ul class="py-1">
                        <li><button onclick="applyFilter('Semua')" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua</button></li>
                        <li><button onclick="applyFilter('Terbaru')" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-t border-gray-50">Terbaru</button></li>
                    </ul>
                </div>
            </div>

            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-[#9CA3AF] text-xs"></i>
                <input type="text" id="searchInput" onkeyup="searchOrder()" placeholder="Cari Pesanan"
                    class="pl-10 pr-4 py-2 bg-white rounded-lg w-64 text-sm focus:outline-none border border-transparent focus:border-gray-300 transition-all">
            </div>
        </div>
    </div>

    <div id="orderGrid" class="grid grid-cols-3 gap-5 mb-6">
        @foreach($pesanan as $index => $p)
            <div class="order-card {{ $index >= 9 ? 'hidden' : '' }} bg-white rounded-2xl p-5 cursor-pointer hover:shadow-md transition group" 
                 data-page="{{ floor($index / 9) + 1 }}"
                 data-kode="{{ $p['kode'] }}"
                 onclick="openModal('{{ $p['kode'] }}', '{{ $p['customer'] }}', '{{ $p['meja'] ?? 'Take Away' }}', '{{ $p['waktu'] }}', '{{ $p['tipe'] }}', {{ json_encode($p['items']) }})">
                
                <div class="flex justify-between items-start mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-black rounded-xl flex items-center justify-center">
                            <i class="fa-solid {{ $p['tipe'] == 'Dine In' ? 'fa-chair' : 'fa-bag-shopping' }} text-white text-base"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-[#374151] leading-none mb-1">{{ $p['kode'] }}</h4>
                            <p class="text-[10px] text-[#9CA3AF] font-medium flex items-center gap-1">
                                <i class="fa-solid fa-user" style="font-size: 8px;"></i> {{ $p['customer'] }}
                            </p>
                        </div>
                    </div>
                    
                    <span id="card-status-{{ $p['kode'] }}"
                        class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase flex items-center gap-1 transition-all
                        {{ $p['status'] == 'Selesai' ? 'bg-white text-black border-2 border-black' : 'bg-black text-white' }}">
                        <i class="status-icon fa-solid {{ $p['status'] == 'Dimasak' ? 'fa-utensils' : ($p['status'] == 'Menunggu' ? 'fa-clock' : 'fa-circle-check') }}" style="font-size: 8px;"></i>
                        <span class="status-text">{{ $p['status'] }}</span>
                    </span>
                </div>

                <div class="space-y-2.5 mb-5">
                    <div class="flex justify-between items-center">
                        <span class="text-[#374151] font-medium text-xs flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-[10px] text-[#9CA3AF]"></i> {{ $p['meja'] ?? 'Take Away' }}
                        </span>
                        <span class="bg-[#E5E7EB] px-2.5 py-0.5 rounded-full text-[9px] font-bold text-[#374151] uppercase">
                            {{ $p['tipe'] }}
                        </span>
                    </div>
                    <p class="text-xs text-[#374151] font-medium flex items-center gap-2">
                        <i class="fa-regular fa-clock text-[10px] text-[#9CA3AF]"></i> Order {{ $p['waktu'] }}
                    </p>
                    <p class="text-xs text-[#374151] font-medium flex items-center gap-2">
                        <i class="fa-solid fa-box text-[10px] text-[#9CA3AF]"></i> {{ count($p['items']) }} Item
                    </p>
                </div>

                <button class="w-full py-2.5 bg-[#E5E7EB] rounded-xl font-bold text-xs text-[#374151] flex items-center justify-center gap-2 group-hover:bg-[#D1D5DB] transition">
                    <i class="fa-regular fa-eye text-sm"></i> Detail
                </button>
            </div>
        @endforeach
    </div>

    @if(count($pesanan) > 0)
    <div class="flex flex-col md:flex-row justify-between items-center mt-8 mb-10 gap-4">
        <div class="text-xs text-[#6B7280] font-medium">
            Showing <span id="startRange">1</span>-<span id="endRange">{{ min(9, count($pesanan)) }}</span> of {{ count($pesanan) }} result
        </div>

        <div id="paginationControls" class="flex items-center gap-1.5">
            <button onclick="changePage(currentPage - 1)" id="prevBtn" 
                class="w-8 h-8 flex items-center justify-center bg-white border border-gray-100 rounded-lg text-gray-400 hover:bg-gray-50 transition-all disabled:opacity-30 disabled:cursor-not-allowed">
                <i class="fa-solid fa-chevron-left text-[10px]"></i>
            </button>

            <div id="pageNumbers" class="flex gap-1.5">
                @for($i = 1; $i <= ceil(count($pesanan) / 9); $i++)
                    <button onclick="changePage({{ $i }})" 
                        class="page-btn w-8 h-8 rounded-lg font-bold text-xs transition-all {{ $i == 1 ? 'bg-black text-white shadow-sm' : 'bg-white text-[#374151] border border-gray-100 hover:bg-gray-50' }}">
                        {{ $i }}
                    </button>
                @endfor
            </div>

            <button onclick="changePage(currentPage + 1)" id="nextBtn"
                class="w-8 h-8 flex items-center justify-center bg-white border border-gray-100 rounded-lg text-gray-400 hover:bg-gray-50 transition-all disabled:opacity-30 disabled:cursor-not-allowed">
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </button>
        </div>
    </div>
    @endif

    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" onclick="closeModal()">
        <div class="bg-white rounded-3xl w-full max-w-xl shadow-2xl relative animate-in fade-in zoom-in duration-200" onclick="event.stopPropagation()">
            <button onclick="closeModal()" class="absolute -top-3 -right-3 w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition shadow-md z-10">
                <i class="fa-solid fa-xmark text-black text-sm"></i>
            </button>

            <div class="bg-[#F5F5F7] p-6 pb-5 rounded-t-3xl border-b border-gray-100">
                <div class="flex items-start gap-4 mb-5">
                    <div id="modalIconBox" class="w-14 h-14 bg-black rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i id="modalIcon" class="fa-solid fa-utensils text-white text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h2 id="modalTipe" class="text-xs font-normal text-[#374151] mb-1 uppercase tracking-wider">DINE IN</h2>
                        <h3 id="modalKode" class="text-xl font-bold text-[#374151] mb-1 leading-none">PSN-000</h3>
                        <p id="modalMeja" class="text-xs text-[#6B7280] font-medium flex items-center gap-1.5 mt-1">
                            <i class="fa-solid fa-location-dot text-[10px]"></i> <span>Meja 0</span>
                        </p>
                    </div>
                    <div class="flex flex-col gap-2 items-end">
                        <div class="bg-black text-white px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase flex items-center gap-2">
                            <i class="fa-regular fa-clock"></i> Order <span id="modalWaktu">00:00</span>
                        </div>
                        <div class="bg-black text-white px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase flex items-center gap-2">
                            <i class="fa-solid fa-user"></i> <span id="modalCustomer">User</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div id="tab-menunggu" class="bg-[#9DA3AE] rounded-2xl p-4 flex flex-col items-center justify-center gap-1 transition-all">
                        <i class="fa-regular fa-clock text-2xl text-white mb-1"></i>
                        <span class="count text-xl font-black text-white leading-none">0</span>
                        <span class="text-[10px] font-bold text-white uppercase tracking-tighter">Menunggu</span>
                    </div>
                    <div id="tab-dimasak" class="bg-[#9DA3AE] rounded-2xl p-4 flex flex-col items-center justify-center gap-1 transition-all">
                        <i class="fa-solid fa-utensils text-2xl text-white mb-1"></i>
                        <span class="count text-xl font-black text-white leading-none">0</span>
                        <span class="text-[10px] font-bold text-white uppercase tracking-tighter">Dimasak</span>
                    </div>
                    <div id="tab-selesai" class="bg-[#9DA3AE] rounded-2xl p-4 flex flex-col items-center justify-center gap-1 transition-all">
                        <i class="fa-solid fa-circle-check text-2xl text-white mb-1"></i>
                        <span class="count text-xl font-black text-white leading-none">0</span>
                        <span class="text-[10px] font-bold text-white uppercase tracking-tighter">Selesai</span>
                    </div>
                </div>
            </div>

            <div class="px-6 py-6 bg-white rounded-b-3xl">
                <h4 class="text-[10px] font-bold text-[#9CA3AF] uppercase tracking-widest mb-4">Daftar Menu</h4>
                <div id="menuItemsContainer" class="space-y-4 max-h-[280px] overflow-y-auto pr-1">
                </div>

                <div id="finishOrderContainer" class="mt-8 hidden animate-in slide-in-from-bottom-2">
                    <div class="flex justify-center w-full">
                        <button onclick="confirmFinishOrder()" class="w-full py-2.5 bg-black text-white rounded-xl flex items-center justify-center gap-3 font-bold text-xs shadow-sm cursor-pointer border-none outline-none">
                            <i class="fa-solid fa-circle-check text-base"></i>
                            Selesaikan Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentOrderKode = '';
        let currentPage = 1;
        const itemsPerPage = 9;
        const totalItems = {{ count($pesanan) }};

        function applyFilter(type) {
            const grid = document.getElementById('orderGrid');
            const cards = Array.from(document.querySelectorAll('.order-card'));
            document.getElementById('filterLabel').innerText = type;

            if (type === 'Terbaru') {
                cards.sort((a, b) => b.getAttribute('data-kode').localeCompare(a.getAttribute('data-kode')));
            } else {
                cards.sort((a, b) => a.getAttribute('data-kode').localeCompare(b.getAttribute('data-kode')));
            }

            grid.innerHTML = '';
            cards.forEach((card, idx) => {
                card.setAttribute('data-page', Math.floor(idx / 9) + 1);
                grid.appendChild(card);
            });
            changePage(1);
        }

        function searchOrder() {
            const input = document.getElementById('searchInput').value.toUpperCase();
            const cards = document.querySelectorAll('.order-card');
            cards.forEach(card => {
                const kode = card.getAttribute('data-kode').toUpperCase();
                card.style.display = kode.includes(input) ? '' : 'none';
            });
            if(!input) changePage(1);
        }

        function changePage(pageNum) {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            if (pageNum < 1 || pageNum > totalPages) return;
            
            currentPage = pageNum;
            const cards = document.querySelectorAll('.order-card');
            
            cards.forEach(card => {
                card.classList.toggle('hidden', card.getAttribute('data-page') != currentPage);
            });

            document.querySelectorAll('.page-btn').forEach((btn) => {
                if (parseInt(btn.innerText) === currentPage) {
                    btn.className = "page-btn w-8 h-8 rounded-lg font-bold text-xs bg-black text-white shadow-sm transition-all";
                } else {
                    btn.className = "page-btn w-8 h-8 rounded-lg font-bold text-xs bg-white text-[#374151] border border-gray-100 hover:bg-gray-50 transition-all";
                }
            });

            const start = ((currentPage - 1) * itemsPerPage) + 1;
            const end = Math.min(currentPage * itemsPerPage, totalItems);
            if(document.getElementById('startRange')) document.getElementById('startRange').innerText = start;
            if(document.getElementById('endRange')) document.getElementById('endRange').innerText = end;

            if(document.getElementById('prevBtn')) document.getElementById('prevBtn').disabled = (currentPage === 1);
            if(document.getElementById('nextBtn')) document.getElementById('nextBtn').disabled = (currentPage === totalPages);
        }

        function openModal(kode, customer, meja, waktu, tipe, items) {
            currentOrderKode = kode;
            document.getElementById('modalKode').innerText = kode;
            document.getElementById('modalCustomer').innerText = customer;
            document.getElementById('modalMeja').querySelector('span').innerText = meja;
            document.getElementById('modalWaktu').innerText = waktu;
            document.getElementById('modalTipe').innerText = tipe;

            const icon = document.getElementById('modalIcon');
            icon.className = tipe === 'Dine In' ? 'fa-solid fa-chair text-white text-xl' : 'fa-solid fa-bag-shopping text-white text-xl';

            renderMenuItems(items);
            document.getElementById('detailModal').classList.replace('hidden', 'flex');
            document.body.style.overflow = 'hidden';
        }

        function renderMenuItems(items) {
            const container = document.getElementById('menuItemsContainer');
            container.innerHTML = items.map((item, index) => `
                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 flex justify-between items-center">
                    <div class="flex-1">
                        <h5 class="text-sm font-bold text-[#374151]">${item.name}</h5>
                        <p class="text-xs text-[#6B7280] font-medium">X ${item.qty}</p>
                        ${item.note ? `<p class="text-[10px] text-[#9CA3AF] italic mt-0.5">${item.note}</p>` : ''}
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <div id="badge-item-${index}" class="px-3 py-1 rounded-full flex items-center gap-1.5 transition-all">
                            <i class="fa-solid text-[9px]"></i>
                            <span class="text-[9px] font-bold uppercase"></span>
                        </div>
                        <div class="relative">
                            <select onchange="updateItemStatus(${index}, this.value)" 
                                class="bg-[#E5E7EB] border-0 rounded-lg pl-3 pr-8 py-2 text-[10px] font-extrabold text-[#374151] appearance-none focus:outline-none cursor-pointer uppercase min-w-[110px]">
                                <option value="Menunggu" ${item.status === 'Menunggu' ? 'selected' : ''}>Menunggu</option>
                                <option value="Dimasak" ${item.status === 'Dimasak' ? 'selected' : ''}>Dimasak</option>
                                <option value="Selesai" ${item.status === 'Selesai' ? 'selected' : ''}>Selesai</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[9px] text-[#6B7280] pointer-events-none"></i>
                        </div>
                    </div>
                </div>
            `).join('');

            items.forEach((item, i) => updateBadgeUI(i, item.status));
            updateSummaryTabs();
            syncCardStatus();
        }

        function updateItemStatus(index, status) {
            updateBadgeUI(index, status);
            updateSummaryTabs();
            syncCardStatus();
        }

        function updateBadgeUI(index, status) {
            const badge = document.getElementById(`badge-item-${index}`);
            const text = badge.querySelector('span');
            const icon = badge.querySelector('i');
            text.innerText = status;

            if (status === 'Selesai') {
                badge.className = "px-3 py-1 rounded-full flex items-center gap-1.5 bg-white border-2 border-black text-black";
                icon.className = "fa-solid fa-circle-check";
            } else if (status === 'Dimasak') {
                badge.className = "px-3 py-1 rounded-full flex items-center gap-1.5 bg-black text-white";
                icon.className = "fa-solid fa-utensils";
            } else {
                badge.className = "px-3 py-1 rounded-full flex items-center gap-1.5 bg-gray-100 text-gray-500 border border-gray-200";
                icon.className = "fa-regular fa-clock";
            }
        }

        function updateSummaryTabs() {
            const selects = document.querySelectorAll('#menuItemsContainer select');
            let counts = { Menunggu: 0, Dimasak: 0, Selesai: 0 };
            selects.forEach(s => counts[s.value]++);
            
            document.querySelector('#tab-menunggu .count').innerText = counts.Menunggu;
            document.querySelector('#tab-dimasak .count').innerText = counts.Dimasak;
            document.querySelector('#tab-selesai .count').innerText = counts.Selesai;
        }

        function syncCardStatus() {
            const selects = Array.from(document.querySelectorAll('#menuItemsContainer select'));
            const statuses = selects.map(s => s.value);
            const cardStatus = document.getElementById(`card-status-${currentOrderKode}`);
            if(!cardStatus) return;

            const icon = cardStatus.querySelector('.status-icon');
            const text = cardStatus.querySelector('.status-text');

            if (statuses.every(s => s === 'Selesai')) {
                cardStatus.className = "px-2.5 py-1 rounded-full text-[9px] font-bold uppercase flex items-center gap-1 bg-white text-black border-2 border-black transition-all";
                icon.className = "status-icon fa-solid fa-circle-check";
                text.innerText = "Selesai";
                document.getElementById('finishOrderContainer').classList.remove('hidden');
            } else {
                cardStatus.className = "px-2.5 py-1 rounded-full text-[9px] font-bold uppercase flex items-center gap-1 bg-black text-white transition-all";
                document.getElementById('finishOrderContainer').classList.add('hidden');
                
                if (statuses.some(s => s === 'Dimasak' || s === 'Selesai')) {
                    icon.className = "status-icon fa-solid fa-utensils";
                    text.innerText = "Dimasak";
                } else {
                    icon.className = "status-icon fa-solid fa-clock";
                    text.innerText = "Menunggu";
                }
            }
        }

        function confirmFinishOrder() { closeModal(); }
        function closeModal() {
            document.getElementById('detailModal').classList.replace('flex', 'hidden');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('DOMContentLoaded', () => {
            if(document.getElementById('prevBtn')) changePage(1);
        });
    </script>
@endsection