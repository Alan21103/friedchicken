@extends('owner.layouts.layouts')

@section('title', 'Tren Menu')

@section('content')
<div class="space-y-6" x-data="{ 
    range: 'Mingguan',         
    rangeBanding: 'Mingguan',  
    trendType: 'Paling Laris',
    selectedDate: '',          
    selectedDateBanding: '',   
    menu1: 'PaNas 1',          // Pilihan menu dropdown 1
    menu2: 'Ayam Krispy',      // Pilihan menu dropdown 2
    chartProgress: null,
    chartBanding: null,
    
    // 1. DATA MASTER
    allData: {
        'Mingguan': {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            progress: [45, 52, 38, 65, 48, 70, 85],
            topPerDay: ['PaNas 1', 'Ayam Krispy', 'PaNas 1', 'PaNas 2', 'PaNas 1', 'Ayam Krispy', 'PaNas 1'],
            bottomPerDay: ['Es Jeruk Nipis', 'Tahu Goreng', 'Susu Coklat', 'Es Jeruk Nipis', 'Tahu Goreng', 'Susu Coklat', 'Tahu Goreng'],
            // Data spesifik tiap menu untuk perbandingan
            menuDatasets: {
                'PaNas 1': [10, 15, 8, 20, 15, 12, 25],
                'Ayam Krispy': [8, 12, 10, 15, 12, 18, 20],
                'PaNas 2 With Rice': [5, 10, 5, 12, 8, 10, 15],
                'Es Jeruk Nipis': [2, 1, 3, 2, 1, 2, 2],
                'Tahu Goreng': [1, 2, 1, 1, 1, 1, 1],
                'Susu Coklat': [1, 0, 1, 1, 0, 1, 1]
            }
        },
        'Bulanan': {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            progress: [450, 520, 480, 600, 550, 700, 850, 800, 750, 900, 880, 950],
            topPerDay: ['PaNas 1', 'PaNas 1', 'Ayam Krispy', 'Burger Cheese', 'PaNas 1', 'PaNas 2', 'Ayam Krispy', 'PaNas 1', 'Burger Cheese', 'PaNas 1', 'PaNas 1', 'PaNas 2'],
            bottomPerDay: ['Air Mineral', 'Kerupuk', 'Teh Tawar', 'Air Mineral', 'Kerupuk', 'Kerupuk', 'Teh Tawar', 'Air Mineral', 'Teh Tawar', 'Kerupuk', 'Air Mineral', 'Teh Tawar'],
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
            bottomPerDay: ['Menu Musiman A', 'Menu Musiman B', 'Menu Musiman A', 'Paket Promo C'],
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
            bottomPerDay: ['Milo', 'Teh Hijau', 'Susu Putih', 'Susu Putih', 'Bubur Ayam', 'Omelette', 'Susu Putih', 'Milo'],
            menuDatasets: {
                'PaNas 1': [1, 2, 10, 8, 5, 7, 12, 0],
                'Ayam Krispy': [0, 1, 8, 5, 4, 10, 10, 0],
                'Burger': [0, 0, 5, 3, 2, 5, 8, 2],
                'Susu Putih': [1, 1, 0, 0, 0, 0, 0, 0],
                'Bubur Ayam': [2, 5, 0, 0, 0, 0, 0, 0],
                'Omelette': [1, 3, 0, 0, 0, 0, 0, 0]
            }
        }
    },

    // 2. LOGIKA UTAMA
    get currentMenu() {
        const data = this.allData[this.range];
        return this.trendType === 'Paling Laris' ? [
            { nama: 'PaNas 1', terjual: 245, omzet: 'Rp 8.575.000', trend: '+15,2%', up: true, color: '#737D8C' },
            { nama: 'Ayam Krispy', terjual: 198, omzet: 'Rp 4.575.000', trend: '+5,2%', up: true, color: '#4B5563' },
            { nama: 'PaNas 2 With Rice', terjual: 135, omzet: 'Rp 1.575.000', trend: '-15,2%', up: false, color: '#9CA3AF' }
        ] : [
            { nama: 'Es Jeruk Nipis', terjual: 12, omzet: 'Rp 120.000', trend: '-25,0%', up: false, color: '#737D8C' },
            { nama: 'Tahu Goreng', terjual: 8, omzet: 'Rp 40.000', trend: '-10,5%', up: false, color: '#4B5563' },
            { nama: 'Susu Coklat', terjual: 5, omzet: 'Rp 75.000', trend: '-5,2%', up: false, color: '#9CA3AF' }
        ];
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
            grad1.addColorStop(0, 'rgba(115, 125, 140, 0.8)'); grad1.addColorStop(1, 'rgba(115, 125, 140, 0.1)');

            this.chartProgress = new Chart(ctx1, {
                type: 'line',
                data: { labels: dAtas.labels, datasets: [{ data: dAtas.progress, borderColor: '#737D8C', backgroundColor: grad1, fill: true, tension: 0.4 }] },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#374151', padding: 12, cornerRadius: 10, displayColors: false,
                            callbacks: {
                                label: (ctx) => [
                                    `Terjual: ${ctx.parsed.y} Unit`,
                                    `Terlaris: ${dAtas.topPerDay[ctx.dataIndex]}`,
                                ]
                            }
                        }
                    },
                    scales: { y: { beginAtZero: true }, x: { grid: { display: false } } }
                }
            });

            // --- GRAFIK BAWAH: PERBANDINGAN DINAMIS ---
            const ctx2 = document.getElementById('chartBandingMenu').getContext('2d');
            if (this.chartBanding) this.chartBanding.destroy();

            // Ambil data berdasarkan pilihan dropdown
            const dataM1 = dBawah.menuDatasets[this.menu1] || [];
            const dataM2 = dBawah.menuDatasets[this.menu2] || [];

            this.chartBanding = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: dBawah.labels,
                    datasets: [
                        { label: this.menu1, data: dataM1, borderColor: '#737D8C', backgroundColor: 'rgba(115, 125, 140, 0.6)', fill: true, tension: 0, pointRadius: 4 },
                        { label: this.menu2, data: dataM2, borderColor: '#1e293b', backgroundColor: 'rgba(30, 41, 59, 0.2)', fill: true, tension: 0, pointRadius: 4 }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: true, position: 'top', align: 'end', labels: { boxWidth: 10, font: { size: 10, weight: 'bold' } } },
                        tooltip: { backgroundColor: '#374151', callbacks: { label: (ctx) => ` ${ctx.dataset.label}: ${ctx.parsed.y} Terjual` } }
                    },
                    scales: { y: { beginAtZero: true }, x: { grid: { display: false } } }
                }
            });
        });
    }
}" x-init="renderCharts()">

    <div class="mb-4">
        <h2 class="text-3xl font-bold text-gray-700">Tren Menu</h2>
        <p class="text-sm text-gray-400 mt-1">Analisis performa menu makanan dan minuman</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col min-h-[500px]">
            <div class="flex justify-between items-center mb-10">
                <h3 class="font-bold text-gray-800 text-lg tracking-tight">Trend Menu</h3>
                <div class="flex gap-1 bg-[#F3F4F6] p-1 rounded-xl">
                    <button @click="trendType = 'Paling Laris'" :class="trendType === 'Paling Laris' ? 'bg-[#1e293b] text-white shadow-md' : 'text-gray-500'" class="px-5 py-2 rounded-lg text-xs font-bold transition">Paling Laris</button>
                    <button @click="trendType = 'Kurang Laris'" :class="trendType === 'Kurang Laris' ? 'bg-[#1e293b] text-white shadow-sm' : 'text-gray-500'" class="px-5 py-2 rounded-lg text-xs font-bold transition">Kurang Laris</button>
                </div>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <template x-for="(item, index) in currentMenu" :key="index">
                    <div class="flex items-center justify-between py-6 border-b border-gray-100 last:border-0">
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-sm" :style="'background-color:' + item.color" x-text="index + 1"></div>
                            <div>
                                <h4 class="font-extrabold text-gray-700 text-lg" x-text="item.nama"></h4>
                                <p class="text-sm text-gray-400 font-bold" x-text="item.terjual + ' Terjual'"></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-extrabold text-gray-700 text-lg" x-text="item.omzet"></p>
                            <div class="flex items-center justify-end gap-1 text-xs font-bold" :class="item.up ? 'text-emerald-500' : 'text-rose-500'">
                                <i :class="item.up ? 'fa-solid fa-arrow-up' : 'fa-solid fa-arrow-down'"></i>
                                <span x-text="item.trend"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex flex-1 gap-2 bg-[#F3F4F6] p-1.5 rounded-2xl">
                    <template x-for="item in ['Mingguan', 'Bulanan', 'Tahunan']">
                        <button @click="updateFilter(item)" :class="range === item && !selectedDate ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500'" class="flex-1 py-2.5 rounded-xl text-xs font-bold transition" x-text="item"></button>
                    </template>
                </div>
                <div class="bg-white px-4 py-2 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-2">
                    <input type="date" x-model="selectedDate" @change="updateDate()" class="text-xs font-bold text-gray-600 outline-none border-none cursor-pointer focus:ring-0">
                </div>
            </div>
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex-1 flex flex-col">
                <h3 class="font-bold text-gray-800 text-sm tracking-tight mb-4">Grafik Progress Penjualan</h3>
                <div class="flex-1 w-full relative min-h-[300px]">
                    <canvas id="chartProgressMenu"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 mt-6 flex flex-col">
        <div class="flex flex-col xl:flex-row justify-between items-center mb-10 gap-6 border-b border-gray-50 pb-6">
            <h3 class="font-bold text-gray-600 text-lg tracking-widest uppercase shrink-0">PERBANDINGAN TREN MENU</h3>
            
            <div class="flex flex-wrap items-center justify-end gap-4 w-full">
                <div class="flex gap-1 bg-[#F3F4F6] p-1 rounded-xl">
                    <template x-for="item in ['Mingguan', 'Bulanan', 'Tahunan']">
                        <button @click="updateFilterBanding(item)" :class="rangeBanding === item && !selectedDateBanding ? 'bg-[#1e293b] text-white shadow-md' : 'text-gray-500'" class="px-4 py-1.5 rounded-lg text-[10px] font-bold transition" x-text="item"></button>
                    </template>
                </div>
                <div class="bg-[#F3F4F6] px-4 py-1.5 rounded-xl flex items-center gap-2">
                    <input type="date" x-model="selectedDateBanding" @change="updateDateBanding()" class="bg-transparent text-[10px] font-bold text-gray-600 outline-none border-none cursor-pointer focus:ring-0">
                </div>

                <div class="flex gap-3">
                    <div class="relative">
                        <select x-model="menu1" @change="renderCharts()" class="bg-[#F3F4F6] border-none rounded-lg px-4 py-2.5 text-xs font-bold text-gray-600 outline-none appearance-none pr-10 cursor-pointer">
                            <template x-for="opt in menuOptions">
                                <option :value="opt" x-text="opt"></option>
                            </template>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
                    </div>
                    <div class="relative">
                        <select x-model="menu2" @change="renderCharts()" class="bg-[#F3F4F6] border-none rounded-lg px-4 py-2.5 text-xs font-bold text-gray-600 outline-none appearance-none pr-10 cursor-pointer">
                            <template x-for="opt in menuOptions">
                                <option :value="opt" x-text="opt"></option>
                            </template>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="h-[400px] w-full relative">
            <canvas id="chartBandingMenu"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection