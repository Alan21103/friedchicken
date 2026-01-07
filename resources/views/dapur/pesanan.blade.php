@extends('layouts.dapur')

@section('title', 'Pesanan')

@section('content')
    <div class="grid grid-cols-4 gap-5 mb-8">
        @php
            $statItems = [
                ['label' => 'Total Pesanan', 'val' => '29', 'icon' => 'fa-box', 'bg' => '#423D3D', 'border' => '#332B2B', 'icon_color' => 'text-white'],
                ['label' => 'Menunggu', 'val' => '6', 'icon' => 'fa-clock', 'is_reg' => true, 'bg' => '#D3B105', 'border' => '#332B2B', 'icon_color' => 'text-black'],
                ['label' => 'Dimasak', 'val' => '10', 'icon' => 'fa-utensils', 'bg' => '#2ABE2A', 'border' => '#332B2B', 'icon_color' => 'text-white'],
                ['label' => 'Selesai', 'val' => '18', 'icon' => 'fa-circle-check', 'is_reg' => true, 'bg' => '#55A2EB', 'border' => '#332B2B', 'icon_color' => 'text-white'],
            ];
        @endphp
        @foreach($statItems as $stat)
        <div class="bg-white rounded-3xl px-6 py-5 border-l-[6px]" style="border-color: {{ $stat['border'] }}">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0" style="background-color: {{ $stat['bg'] }}">
                    <i class="{{ isset($stat['is_reg']) ? 'fa-regular' : 'fa-solid' }} {{ $stat['icon'] }} {{ $stat['icon_color'] }} text-xl"></i>
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
            <div class="order-card {{ $index >= 9 ? 'hidden' : '' }} bg-white rounded-2xl overflow-hidden cursor-pointer hover:shadow-md transition group" 
                 data-page="{{ floor($index / 9) + 1 }}"
                 data-kode="{{ $p['kode'] }}"
                 onclick="openModal('{{ $p['kode'] }}', '{{ $p['customer'] }}', '{{ $p['meja'] ?? 'Take Away' }}', '{{ $p['waktu'] }}', '{{ $p['tipe'] }}', {{ json_encode($p['items']) }})">
                
                <div class="bg-[#332B2B] p-4 pb-3.5">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-[#423D3D] rounded-xl flex items-center justify-center">
                                <i class="fa-solid {{ $p['tipe'] == 'Dine In' ? 'fa-chair' : 'fa-bag-shopping' }} text-white text-base"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-base text-white leading-none mb-1.5">{{ $p['kode'] }}</h4>
                                <p class="text-[11px] text-white/80 font-medium flex items-center gap-1.5">
                                    <i class="fa-solid fa-user" style="font-size: 9px;"></i> {{ $p['customer'] }}
                                </p>
                            </div>
                        </div>
                        
                        <span id="card-status-{{ $p['kode'] }}"
                            class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase flex items-center gap-1 transition-all
                            {{ $p['status'] == 'Selesai' ? 'bg-[#55A2EB] text-white' : ($p['status'] == 'Dimasak' ? 'bg-[#2ABE2A] text-white' : 'bg-[#D3B105] text-black') }}">
                            <i class="status-icon fa-solid {{ $p['status'] == 'Dimasak' ? 'fa-utensils' : ($p['status'] == 'Menunggu' ? 'fa-clock' : 'fa-circle-check') }}" style="font-size: 8px;"></i>
                            <span class="status-text">{{ $p['status'] }}</span>
                        </span>
                    </div>
                </div>

                <div class="p-5 pt-4">
                    <div class="space-y-2.5 mb-5">
                        <div class="flex justify-between items-center">
                            <span class="text-[#374151] font-medium text-xs flex items-center gap-2">
                                <i class="fa-solid fa-location-dot text-[10px] text-[#9CA3AF]"></i> {{ $p['meja'] ?? 'Take Away' }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold text-white uppercase" style="background-color: {{ $p['tipe'] == 'Dine In' ? '#7D829B' : '#000000' }}">
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

                    <button class="w-full py-2.5 rounded-xl font-bold text-xs text-[#374151] flex items-center justify-center gap-2 group-hover:opacity-80 transition" style="background-color: rgba(234, 217, 196, 0.21); border: 1px solid rgba(153, 153, 153, 0.5);">
                        <i class="fa-regular fa-eye text-sm"></i> Detail
                    </button>
                </div>
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
                        class="page-btn w-8 h-8 rounded-lg font-bold text-xs transition-all" style="{{ $i == 1 ? 'background-color: #332B2B; color: white;' : 'background-color: white; color: #374151; border: 1px solid #E5E7EB;' }}">
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
        <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl relative animate-in fade-in zoom-in duration-200" onclick="event.stopPropagation()">
            <button onclick="closeModal()" class="absolute -top-3 -right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition shadow-md z-10">
                <i class="fa-solid fa-xmark text-black text-base"></i>
            </button>

            <div class="bg-[#332B2B] p-7 rounded-t-3xl">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div id="modalIconBox" class="w-16 h-16 bg-[#423D3D] rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i id="modalIcon" class="fa-solid fa-utensils text-white text-2xl"></i>
                        </div>
                        <div>
                            <h2 id="modalTipe" class="text-xs font-semibold text-white/70 mb-1.5 uppercase tracking-wider">DINE IN</h2>
                            <h3 id="modalKode" class="text-2xl font-bold text-white mb-2 leading-none">PSN-000</h3>
                            <p id="modalMeja" class="text-sm text-white/90 font-medium flex items-center gap-2">
                                <i class="fa-solid fa-location-dot text-xs"></i> <span>Meja 0</span>
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2.5 items-end">
                        <div class="bg-[#423D3D] text-white px-4 py-2 rounded-xl text-xs font-bold uppercase flex items-center gap-2">
                            <i class="fa-regular fa-clock"></i> Order <span id="modalWaktu">00:00</span>
                        </div>
                        <div class="bg-[#423D3D] text-white px-4 py-2 rounded-xl text-xs font-bold uppercase flex items-center gap-2">
                            <i class="fa-solid fa-user"></i> <span id="modalCustomer">User</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white px-7 py-6">
                <div class="grid grid-cols-3 gap-4">
                    <div id="tab-menunggu" class="bg-[#D3B105] rounded-2xl p-5 flex flex-col items-center justify-center gap-1.5 transition-all">
                        <i class="fa-regular fa-clock text-3xl text-black mb-1"></i>
                        <span class="count text-2xl font-black text-black leading-none">0</span>
                        <span class="text-xs font-bold text-black uppercase tracking-tight">Menunggu</span>
                    </div>
                    <div id="tab-dimasak" class="bg-[#2ABE2A] rounded-2xl p-5 flex flex-col items-center justify-center gap-1.5 transition-all">
                        <i class="fa-solid fa-utensils text-3xl text-white mb-1"></i>
                        <span class="count text-2xl font-black text-white leading-none">0</span>
                        <span class="text-xs font-bold text-white uppercase tracking-tight">Dimasak</span>
                    </div>
                    <div id="tab-selesai" class="bg-[#55A2EB] rounded-2xl p-5 flex flex-col items-center justify-center gap-1.5 transition-all">
                        <i class="fa-solid fa-circle-check text-3xl text-white mb-1"></i>
                        <span class="count text-2xl font-black text-white leading-none">0</span>
                        <span class="text-xs font-bold text-white uppercase tracking-tight">Selesai</span>
                    </div>
                </div>
            </div>

            <div class="px-7 pb-7 bg-white rounded-b-3xl">
                <h4 class="text-xs font-bold text-[#9CA3AF] uppercase tracking-widest mb-5">Daftar Menu (<span id="totalItems">0</span> Item)</h4>
                <div id="menuItemsContainer" class="space-y-4 max-h-[320px] overflow-y-auto pr-2">
                </div>

                <div id="finishOrderContainer" class="mt-8 hidden animate-in slide-in-from-bottom-2">
                    <div class="flex justify-center w-full">
                        <button onclick="confirmFinishOrder()" class="w-full py-3 rounded-xl flex items-center justify-center gap-3 font-bold text-sm shadow-sm cursor-pointer border-none outline-none text-white" style="background-color: #332B2B">
                            <i class="fa-solid fa-circle-check text-lg"></i>
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
                    btn.style.backgroundColor = '#332B2B';
                    btn.style.color = 'white';
                    btn.style.border = 'none';
                } else {
                    btn.style.backgroundColor = 'white';
                    btn.style.color = '#374151';
                    btn.style.border = '1px solid #E5E7EB';
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
            document.getElementById('totalItems').innerText = items.length;
            container.innerHTML = items.map((item, index) => `
                <div class="bg-[#332B2B] rounded-2xl p-5 flex justify-between items-center">
                    <div class="flex-1">
                        <h5 class="text-base font-bold text-white mb-1">${item.name}</h5>
                        <p class="text-sm text-white/70 font-medium">X ${item.qty}</p>
                        ${item.note ? `<p class="text-xs text-white/50 italic mt-1">${item.note}</p>` : ''}
                    </div>
                    <div class="flex flex-col items-end gap-2.5">
                        <div id="badge-item-${index}" class="px-3.5 py-1.5 rounded-full flex items-center gap-2 transition-all">
                            <i class="fa-solid text-xs"></i>
                            <span class="text-xs font-bold uppercase"></span>
                        </div>
                        <div class="relative">
                            <select onchange="updateItemStatus(${index}, this.value)" 
                                class="bg-[#423D3D] border-0 rounded-xl pl-4 pr-10 py-2.5 text-xs font-extrabold text-white appearance-none focus:outline-none cursor-pointer uppercase min-w-[120px]">
                                <option value="Menunggu" ${item.status === 'Menunggu' ? 'selected' : ''}>Menunggu</option>
                                <option value="Dimasak" ${item.status === 'Dimasak' ? 'selected' : ''}>Dimasak</option>
                                <option value="Selesai" ${item.status === 'Selesai' ? 'selected' : ''}>Selesai</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-white/70 pointer-events-none"></i>
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
                badge.className = "px-3.5 py-1.5 rounded-full flex items-center gap-2 bg-[#55A2EB] text-white";
                icon.className = "fa-solid fa-circle-check";
            } else if (status === 'Dimasak') {
                badge.className = "px-3.5 py-1.5 rounded-full flex items-center gap-2 bg-[#2ABE2A] text-white";
                icon.className = "fa-solid fa-utensils";
            } else {
                badge.className = "px-3.5 py-1.5 rounded-full flex items-center gap-2 bg-[#D3B105] text-black";
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
                cardStatus.className = "px-2.5 py-1 rounded-full text-[9px] font-bold uppercase flex items-center gap-1 bg-[#55A2EB] text-white transition-all";
                icon.className = "status-icon fa-solid fa-circle-check";
                text.innerText = "Selesai";
                document.getElementById('finishOrderContainer').classList.remove('hidden');
            } else {
                document.getElementById('finishOrderContainer').classList.add('hidden');
                
                if (statuses.some(s => s === 'Dimasak' || s === 'Selesai')) {
                    cardStatus.className = "px-2.5 py-1 rounded-full text-[9px] font-bold uppercase flex items-center gap-1 bg-[#2ABE2A] text-white transition-all";
                    icon.className = "status-icon fa-solid fa-utensils";
                    text.innerText = "Dimasak";
                } else {
                    cardStatus.className = "px-2.5 py-1 rounded-full text-[9px] font-bold uppercase flex items-center gap-1 bg-[#D3B105] text-black transition-all";
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