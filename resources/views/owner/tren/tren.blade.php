@extends('owner.layouts.layouts')

@section('title', 'Tren Menu')

@section('content')
<div class="space-y-6" x-data="{ 
    range: 'Mingguan',         
    rangeBanding: 'Mingguan',  
    trendType: 'Paling Laris',
    selectedDate: '',          
    selectedDateBanding: '',   
    menu1: 'PaNas 1',          
    menu2: 'Ayam Krispy',      
    chartProgress: null,
    chartBanding: null,
    
    allData: {
        'Mingguan': {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            progress: [45, 52, 38, 65, 48, 70, 85],
            topPerDay: ['PaNas 1', 'Ayam Krispy', 'PaNas 1', 'PaNas 2', 'PaNas 1', 'Ayam Krispy', 'PaNas 1'],
            laris: [
                { nama: 'PaNas 1', terjual: 245, omzet: 'Rp 8.575.000', trend: '+15,2%', up: true, color: '#332B2B' },
                { nama: 'Ayam Krispy', terjual: 198, omzet: 'Rp 4.575.000', trend: '+5,2%', up: true, color: '#4A3F3F' },
                { nama: 'PaNas 2', terjual: 135, omzet: 'Rp 3.105.000', trend: '+2,1%', up: true, color: '#737D8C' }
            ],
            kurang: [
                { nama: 'Es Jeruk Nipis', terjual: 12, omzet: 'Rp 120.000', trend: '-25,0%', up: false, color: '#332B2B' },
                { nama: 'Tahu Goreng', terjual: 8, omzet: 'Rp 40.000', trend: '-10,5%', up: false, color: '#4A3F3F' },
                { nama: 'Susu Coklat', terjual: 5, omzet: 'Rp 75.000', trend: '-5,2%', up: false, color: '#737D8C' }
            ],
            menuDatasets: {
                'PaNas 1': [10, 15, 8, 20, 15, 12, 25],
                'Ayam Krispy': [8, 12, 10, 15, 12, 18, 20],
                'PaNas 2': [5, 10, 5, 12, 8, 10, 15],
                'Es Jeruk Nipis': [2, 1, 3, 2, 1, 2, 2],
                'Tahu Goreng': [1, 2, 1, 1, 1, 1, 1],
                'Susu Coklat': [1, 0, 1, 1, 0, 1, 1]
            }
        },
        'Bulanan': {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            progress: [450, 520, 480, 600, 550, 700, 850, 800, 750, 900, 880, 950],
            topPerDay: ['PaNas 1', 'PaNas 1', 'Ayam Krispy', 'Burger Cheese', 'PaNas 1', 'PaNas 2', 'Ayam Krispy', 'PaNas 1', 'Burger Cheese', 'PaNas 1', 'PaNas 1', 'PaNas 2'],
            laris: [
                { nama: 'PaNas 1', terjual: 1240, omzet: 'Rp 43.400.000', trend: '+18,2%', up: true, color: '#332B2B' },
                { nama: 'Burger Cheese', terjual: 980, omzet: 'Rp 24.500.000', trend: '+12,5%', up: true, color: '#4A3F3F' },
                { nama: 'Ayam Krispy', terjual: 850, omzet: 'Rp 19.550.000', trend: '+8,2%', up: true, color: '#737D8C' }
            ],
            kurang: [
                { nama: 'Air Mineral', terjual: 45, omzet: 'Rp 225.000', trend: '-5,0%', up: false, color: '#332B2B' },
                { nama: 'Kerupuk', terjual: 30, omzet: 'Rp 60.000', trend: '-12,5%', up: false, color: '#4A3F3F' },
                { nama: 'Teh Tawar', terjual: 20, omzet: 'Rp 40.000', trend: '-2,2%', up: false, color: '#737D8C' }
            ],
            menuDatasets: {
                'PaNas 1': [80, 90, 75, 110, 95, 120, 140, 130, 120, 150, 140, 160],
                'Ayam Krispy': [70, 85, 80, 100, 90, 110, 130, 120, 110, 140, 130, 150],
                'Burger Cheese': [60, 70, 65, 85, 75, 95, 110, 100, 95, 120, 115, 130],
                'Air Mineral': [5, 4, 3, 6, 4, 5, 5, 4, 3, 4, 2, 1],
                'Kerupuk': [3, 2, 4, 3, 2, 3, 4, 2, 3, 2, 1, 1],
                'Teh Tawar': [2, 3, 2, 2, 3, 2, 3, 2, 2, 2, 1, 2]
            }
        },
        'Tahunan': {
            labels: ['2023', '2024', '2025', '2026'],
            progress: [5500, 6200, 7800, 9500],
            topPerDay: ['PaNas 1', 'PaNas 1', 'PaNas 1', 'PaNas 1'],
            laris: [
                { nama: 'PaNas 1', terjual: 15400, omzet: 'Rp 539.000.000', trend: '+25,2%', up: true, color: '#332B2B' },
                { nama: 'Ayam Krispy', terjual: 12800, omzet: 'Rp 294.400.000', trend: '+20,5%', up: true, color: '#4A3F3F' },
                { nama: 'PaNas 2', terjual: 10500, omzet: 'Rp 241.500.000', trend: '+18,2%', up: true, color: '#737D8C' }
            ],
            kurang: [
                { nama: 'Menu Musiman A', terjual: 150, omzet: 'Rp 4.500.000', trend: '-45,0%', up: false, color: '#332B2B' },
                { nama: 'Menu Musiman B', terjual: 120, omzet: 'Rp 3.600.000', trend: '-30,5%', up: false, color: '#4A3F3F' },
                { nama: 'Paket Promo C', terjual: 95, omzet: 'Rp 1.900.000', trend: '-15,2%', up: false, color: '#737D8C' }
            ],
            menuDatasets: {
                'PaNas 1': [1200, 1500, 1800, 2200],
                'Ayam Krispy': [1000, 1300, 1600, 2000],
                'PaNas 2': [800, 1100, 1300, 1700],
                'Menu Musiman A': [100, 80, 50, 40],
                'Menu Musiman B': [90, 70, 45, 30],
                'Paket Promo C': [50, 40, 30, 20]
            }
        },
        'Harian': {
            labels: ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'],
            progress: [5, 12, 25, 18, 15, 30, 45, 10],
            topPerDay: ['Kopi', 'Bubur', 'PaNas 1', 'PaNas 1', 'Es Teh', 'Ayam Krispy', 'PaNas 1', 'Burger'],
            laris: [
                { nama: 'PaNas 1', terjual: 45, omzet: 'Rp 1.575.000', trend: '+2,2%', up: true, color: '#332B2B' },
                { nama: 'Kopi', terjual: 30, omzet: 'Rp 450.000', trend: '+5,0%', up: true, color: '#4A3F3F' },
                { nama: 'Burger', terjual: 25, omzet: 'Rp 625.000', trend: '+1,5%', up: true, color: '#737D8C' }
            ],
            kurang: [
                { nama: 'Susu Putih', terjual: 2, omzet: 'Rp 30.000', trend: '-8,0%', up: false, color: '#332B2B' },
                { nama: 'Bubur Ayam', terjual: 1, omzet: 'Rp 15.000', trend: '-15,5%', up: false, color: '#4A3F3F' },
                { nama: 'Milo', terjual: 0, omzet: 'Rp 0', trend: '0%', up: false, color: '#737D8C' }
            ],
            menuDatasets: {
                'PaNas 1': [1, 2, 10, 8, 5, 7, 12, 0],
                'Ayam Krispy': [0, 1, 8, 5, 4, 10, 10, 0],
                'Burger': [0, 0, 5, 3, 2, 5, 8, 2],
                'Susu Putih': [1, 1, 0, 0, 0, 0, 0, 0],
                'Bubur Ayam': [2, 5, 0, 0, 0, 0, 0, 0],
                'Milo': [1, 3, 0, 0, 0, 0, 0, 0]
            }
        }
    },

    get currentMenu() {
        const data = this.allData[this.range];
        return this.trendType === 'Paling Laris' ? data.laris : data.kurang;
    },

    get menuOptions() {
        return Object.keys(this.allData[this.rangeBanding].menuDatasets);
    },

    updateFilter(item) { this.range = item; this.selectedDate = ''; this.renderCharts(); },
    updateDate() { if(this.selectedDate) { this.range = 'Harian'; this.renderCharts(); } },
    updateFilterBanding(item) { this.rangeBanding = item; this.selectedDateBanding = ''; this.renderCharts(); },
    updateDateBanding() { if(this.selectedDateBanding) { this.rangeBanding = 'Harian'; this.renderCharts(); } },

    renderCharts() {
        this.$nextTick(() => {
            const dAtas = this.allData[this.range];
            const dBawah = this.allData[this.rangeBanding];

            // --- GRAFIK ATAS: PROGRESS PENJUALAN ---
            const ctx1 = document.getElementById('chartProgressMenu').getContext('2d');
            if (this.chartProgress) this.chartProgress.destroy();
            const grad1 = ctx1.createLinearGradient(0, 0, 0, 300);
            grad1.addColorStop(0, 'rgba(51, 43, 43, 0.4)'); 
            grad1.addColorStop(1, 'rgba(230, 213, 184, 0.05)');

            this.chartProgress = new Chart(ctx1, {
                type: 'line',
                data: { 
                    labels: dAtas.labels, 
                    datasets: [{ 
                        data: dAtas.progress, 
                        borderColor: '#332B2B', 
                        backgroundColor: grad1, 
                        fill: true, 
                        tension: 0.4, 
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#332B2B'
                    }] 
                },
                options: {
                    responsive: true, 
                    maintainAspectRatio: false,
                    // PERBAIKAN: Agar tooltip muncul tanpa harus menyentuh garis tipis
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            enabled: true,
                            backgroundColor: '#332B2B', 
                            cornerRadius: 12, 
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: (ctx) => [
                                    `Terjual: ${ctx.parsed.y} Unit`,
                                    `Terlaris: ${dAtas.topPerDay[ctx.dataIndex] || '-'}`
                                ]
                            }
                        }
                    },
                    scales: { 
                        y: { beginAtZero: true, ticks: { font: { size: 10, weight: 'bold' }, color: '#4A3F3F66' }, grid: { color: '#E6D5B822' } }, 
                        x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#4A3F3F66' } } 
                    }
                }
            });

            // --- GRAFIK BAWAH: PERBANDINGAN DINAMIS ---
            const ctx2 = document.getElementById('chartBandingMenu').getContext('2d');
            if (this.chartBanding) this.chartBanding.destroy();

            this.chartBanding = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: dBawah.labels,
                    datasets: [
                        { label: this.menu1, data: dBawah.menuDatasets[this.menu1], borderColor: '#332B2B', backgroundColor: 'rgba(51, 43, 43, 0.1)', fill: true, tension: 0, pointRadius: 4, pointBackgroundColor: '#332B2B' },
                        { label: this.menu2, data: dBawah.menuDatasets[this.menu2], borderColor: '#E6D5B8', backgroundColor: 'rgba(230, 213, 184, 0.3)', fill: true, tension: 0, pointRadius: 4, pointBackgroundColor: '#E6D5B8' }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: { 
                        legend: { position: 'top', align: 'end', labels: { usePointStyle: true, font: { weight: 'bold', size: 10 }, color: '#332B2B' } },
                        tooltip: { backgroundColor: '#332B2B', cornerRadius: 10 }
                    },
                    scales: { 
                        y: { beginAtZero: true, ticks: { font: { size: 10, weight: 'bold' }, color: '#4A3F3F66' }, grid: { color: '#E6D5B822' } }, 
                        x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#4A3F3F66' } } 
                    }
                }
            });
        });
    }
}" x-init="renderCharts()">

    <div class="mb-8 text-left px-1">
        <h2 class="text-3xl font-black text-[#332B2B] tracking-tight">Tren Menu</h2>
        <p class="text-base text-[#4A3F3F]/60 mt-1 font-medium">Analisis performa menu makanan dan minuman</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
        {{-- List Trend Menu --}}
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-[#E6D5B8]/30 flex flex-col min-h-[550px] relative overflow-hidden">
            <div class="absolute top-0 left-0 w-32 h-32 bg-[#E6D5B8]/10 rounded-full -ml-16 -mt-16"></div>
            
            <div class="flex justify-between items-center mb-12 relative z-10">
                <h3 class="font-black text-[#332B2B] text-xl tracking-tight">Trend Menu</h3>
                <div class="flex gap-1 bg-[#E6D5B8]/40 p-1.5 rounded-2xl border border-[#E6D5B8]/50">
                    <button @click="trendType = 'Paling Laris'" :class="trendType === 'Paling Laris' ? 'bg-[#332B2B] text-[#E6D5B8] shadow-md' : 'text-[#4A3F3F]/60'" class="px-5 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition">Paling Laris</button>
                    <button @click="trendType = 'Kurang Laris'" :class="trendType === 'Kurang Laris' ? 'bg-[#332B2B] text-[#E6D5B8] shadow-md' : 'text-[#4A3F3F]/60'" class="px-5 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition">Kurang Laris</button>
                </div>
            </div>

            <div class="flex-1 flex flex-col justify-around">
                <template x-for="(item, index) in currentMenu" :key="index">
                    <div class="flex items-center justify-between py-6 border-b border-[#E6D5B8]/20 last:border-0 group">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 rounded-[1.25rem] flex items-center justify-center bg-[#332B2B] text-[#E6D5B8] font-black text-xl shadow-lg shadow-[#332B2B]/20 transition-transform group-hover:scale-110" x-text="index + 1"></div>
                            <div>
                                <h4 class="font-black text-[#332B2B] text-lg tracking-tight" x-text="item.nama"></h4>
                                <p class="text-[10px] font-black text-[#E6D5B8] bg-[#332B2B] inline-block px-2 py-0.5 rounded mt-1 uppercase tracking-widest" x-text="item.terjual + ' Terjual'"></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-black text-[#332B2B] text-lg tracking-tight" x-text="item.omzet"></p>
                            <div class="flex items-center justify-end gap-1.5 text-[11px] font-black" :class="item.up ? 'text-emerald-500' : 'text-rose-400'">
                                <i :class="item.up ? 'fa-solid fa-arrow-trend-up' : 'fa-solid fa-arrow-trend-down'"></i>
                                <span x-text="item.trend" class="tracking-widest"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Grafik Progress Penjualan --}}
        <div class="flex flex-col gap-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex flex-1 gap-1.5 bg-[#E6D5B8]/40 p-1.5 rounded-[1.5rem] border border-[#E6D5B8]/50 shadow-sm">
                    <template x-for="item in ['Mingguan', 'Bulanan', 'Tahunan']">
                        <button @click="updateFilter(item)" :class="range === item && !selectedDate ? 'bg-[#332B2B] text-[#E6D5B8] shadow-md' : 'text-[#4A3F3F]/60'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all" x-text="item"></button>
                    </template>
                </div>
                <div class="bg-white px-5 py-3 rounded-[1.5rem] border border-[#E6D5B8]/30 shadow-sm flex items-center gap-3">
                    <input type="date" x-model="selectedDate" @change="updateDate()" class="text-xs font-black text-[#332B2B] outline-none border-none cursor-pointer focus:ring-0 uppercase tracking-widest">
                </div>
            </div>

            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-[#E6D5B8]/30 flex-1 flex flex-col relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#E6D5B8]/10 rounded-full -mr-16 -mt-16"></div>
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-2 h-2 rounded-full bg-[#332B2B]"></div>
                    <h3 class="font-black text-[#332B2B] text-sm uppercase tracking-[0.2em]">Grafik Progress Menu</h3>
                </div>
                <div class="flex-1 w-full relative min-h-[300px]">
                    <canvas id="chartProgressMenu"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Perbandingan --}}
    <div class="bg-white p-12 rounded-[3.5rem] shadow-sm border border-[#E6D5B8]/30 mt-8 flex flex-col relative overflow-hidden">
        <div class="flex flex-col xl:flex-row justify-between items-center mb-12 gap-8 relative z-10">
            <div class="shrink-0">
                <h3 class="font-black text-[#332B2B] text-xl tracking-tight">PERBANDINGAN TREN MENU</h3>
               
            </div>
            
            <div class="flex flex-wrap items-center justify-end gap-5 w-full">
                <div class="flex gap-1 bg-[#E6D5B8]/40 p-1.5 rounded-2xl border border-[#E6D5B8]/50 shadow-sm">
                    <template x-for="item in ['Mingguan', 'Bulanan', 'Tahunan']">
                        <button @click="updateFilterBanding(item)" :class="rangeBanding === item && !selectedDateBanding ? 'bg-[#332B2B] text-[#E6D5B8] shadow-md' : 'text-[#4A3F3F]/60'" class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition" x-text="item"></button>
                    </template>
                </div>

                <div class="flex gap-4">
                    <div class="relative group">
                        <select x-model="menu1" @change="renderCharts()" class="bg-[#FDFCFB] border border-[#E6D5B8] rounded-xl px-6 py-3.5 text-[11px] font-black text-[#332B2B] outline-none appearance-none pr-12 cursor-pointer focus:border-[#332B2B] transition-all uppercase tracking-widest">
                            <template x-for="opt in menuOptions">
                                <option :value="opt" x-text="opt"></option>
                            </template>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-[#332B2B]/30 text-[10px] pointer-events-none group-hover:text-[#332B2B]"></i>
                    </div>

                    <div class="relative group">
                        <select x-model="menu2" @change="renderCharts()" class="bg-[#FDFCFB] border border-[#E6D5B8] rounded-xl px-6 py-3.5 text-[11px] font-black text-[#332B2B] outline-none appearance-none pr-12 cursor-pointer focus:border-[#332B2B] transition-all uppercase tracking-widest">
                            <template x-for="opt in menuOptions">
                                <option :value="opt" x-text="opt"></option>
                            </template>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-[#332B2B]/30 text-[10px] pointer-events-none group-hover:text-[#332B2B]"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="h-[450px] w-full relative">
            <canvas id="chartBandingMenu"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection