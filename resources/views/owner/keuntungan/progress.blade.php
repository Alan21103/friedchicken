@extends('owner.layouts.layouts')

@section('title', 'Progress Keuntungan')

@section('content')
<div class="space-y-8" 
    x-data="{ 
        range: 'Mingguan',
        isComparing: false,
        selectedDate: '',
        chart: null,
        
        allData: {
            'Mingguan': {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                current: [15, 28, 18, 32, 20, 36, 43],
                previous: [12, 20, 25, 22, 18, 30, 35],
                max: 80,
                unit: ' rb'
            },
            'Bulanan': {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                current: [120, 150, 180, 210, 190, 240, 300, 280, 320, 350, 310, 400],
                previous: [100, 130, 140, 180, 170, 200, 250, 240, 280, 300, 290, 350],
                max: 800,
                unit: ' rb'
            },
            'Tahunan': {
                labels: ['2022', '2023', '2024', '2025', '2026'],
                current: [1.5, 2.8, 4.2, 5.8, 8.5],
                previous: [1.0, 1.8, 2.5, 4.0, 5.5],
                max: 15,
                unit: ' jt'
            },
            'Harian': {
                labels: ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'],
                current: [5, 12, 25, 18, 15, 30, 45, 10],
                previous: [3, 8, 20, 15, 10, 25, 35, 5],
                max: 80,
                unit: ' rb'
            }
        },

        updateFilter(item) {
            this.range = item;
            this.selectedDate = '';
            this.isComparing = false;
            this.renderChart();
        },

        toggleComparison() {
            this.isComparing = !this.isComparing;
            this.renderChart();
        },

        updateDate() {
            if(this.selectedDate) {
                this.range = 'Harian';
                this.isComparing = false;
                this.renderChart();
            }
        },

        renderChart() {
            const ctx = document.getElementById('keuntunganChart').getContext('2d');
            if (this.chart) { this.chart.destroy(); }

            const currentData = this.allData[this.range];
            const currentUnit = currentData.unit;

            // Gradien Utama: Dark Brown ke Cream sangat transparan
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(51, 43, 43, 0.4)');
            gradient.addColorStop(1, 'rgba(230, 213, 184, 0.05)');

            const datasets = [{
                label: this.isComparing ? 'Periode Ini' : 'Keuntungan',
                data: currentData.current,
                borderColor: '#332B2B',
                borderWidth: this.isComparing ? 1.5 : 3,
                fill: true,
                backgroundColor: gradient,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#332B2B',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 3,
                order: 1
            }];

            if (this.isComparing) {
                datasets.push({
                    label: 'Periode Lalu',
                    data: currentData.previous,
                    borderColor: '#E6D5B8',
                    backgroundColor: '#E6D5B8', // Cream solid untuk tumpukan bawah
                    borderWidth: 0,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    order: 2
                });
            }

            this.chart = new Chart(ctx, {
                type: 'line',
                data: { labels: currentData.labels, datasets: datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { 
                            display: this.isComparing,
                            position: 'top',
                            align: 'end',
                            labels: { 
                                font: { size: 10, weight: 'bold' }, 
                                usePointStyle: true,
                                color: '#4A3F3F',
                                padding: 20
                            }
                        },
                        tooltip: {
                            enabled: true,
                            backgroundColor: '#332B2B',
                            titleFont: { size: 12, weight: 'bold' },
                            padding: 15,
                            cornerRadius: 15,
                            displayColors: true,
                            callbacks: {
                                label: (context) => {
                                    const value = context.parsed?.y ?? 0;
                                    return ' ' + context.dataset.label + ': ' + this.formatRupiahSimple(value) + currentUnit;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            stacked: this.isComparing,
                            ticks: { 
                                color: '#4A3F3F66', 
                                font: { size: 10, weight: 'bold' },
                                callback: function(value) { return 'Rp' + value + currentUnit; }
                            },
                            grid: { color: '#E6D5B822' }
                        },
                        x: { 
                            grid: { display: false }, 
                            ticks: { color: '#4A3F3F66', font: { size: 10, weight: 'bold' } } 
                        }
                    }
                }
            });
        },
        
        formatRupiahSimple(val) {
            return new Intl.NumberFormat('id-ID').format(val);
        }
    }" 
    x-init="renderChart()">
    
    {{-- Header --}}
    <div class="mb-10 text-left px-1">
        <h2 class="text-3xl font-black text-[#332B2B] tracking-tight">Progress Keuntungan</h2>
        <p class="text-base text-[#4A3F3F]/60 mt-1 font-medium">
            <span x-show="!isComparing" x-text="selectedDate ? 'Data Harian: ' + selectedDate : 'Analisis grafik pertumbuhan pendapatan restoran'"></span>
            <span x-show="isComparing" class="text-[#332B2B] font-bold" x-text="'Perbandingan ' + range + ' (Mode Stacked)'"></span>
        </p>
    </div>

    {{-- Main Chart Card --}}
    <div class="bg-white p-12 rounded-[3rem] shadow-sm border border-[#E6D5B8]/30 relative overflow-hidden">
        {{-- Dekorasi Aksen --}}
        <div class="absolute top-0 right-0 w-40 h-40 bg-[#E6D5B8]/10 rounded-full -mr-20 -mt-20"></div>

        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-8 mb-12 relative z-10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#332B2B] rounded-2xl flex items-center justify-center text-[#E6D5B8] shadow-lg shadow-[#332B2B]/20">
                    <i class="fa-solid fa-chart-line text-lg"></i>
                </div>
                <div class="text-left">
                    <h3 class="font-black text-[#332B2B] text-xl tracking-tight">Grafik Progress Keuntungan</h3>
                    <p class="text-[10px] font-black text-[#E6D5B8] uppercase tracking-[0.2em]">Data Real-time</p>
                </div>
            </div>
            
            <div class="flex flex-wrap items-center gap-4">
                {{-- Date Picker Kustom --}}
                <div class="relative group">
                    <input type="date" x-model="selectedDate" @change="updateDate()"
                        class="px-5 py-3 bg-[#FDFCFB] border border-[#E6D5B8] rounded-xl text-xs font-bold text-[#332B2B] outline-none hover:border-[#332B2B] transition-colors cursor-pointer">
                </div>

                {{-- Range Filter --}}
                <div class="flex gap-1.5 bg-[#FDFCFB] p-1.5 rounded-2xl border border-[#E6D5B8]/50">
                    <template x-for="item in ['Mingguan', 'Bulanan', 'Tahunan']">
                        <button @click="updateFilter(item)" 
                            :class="range === item && !selectedDate ? 'bg-[#332B2B] text-[#E6D5B8] shadow-md' : 'text-[#4A3F3F]/50 hover:bg-[#E6D5B8]/20'"
                            class="px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all duration-300"
                            x-text="item">
                        </button>
                    </template>
                </div>

                {{-- Compare Button --}}
                <button @click="toggleComparison()" 
                    :class="isComparing ? 'bg-[#4A3F3F] text-[#E6D5B8]' : 'bg-white border border-[#E6D5B8] text-[#332B2B]'"
                    class="px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all duration-300 shadow-sm flex items-center gap-2 group"> 
                    <i class="fa-solid fa-layer-group text-[10px]" :class="isComparing ? 'text-[#E6D5B8]' : 'text-[#E6D5B8]'"></i>
                    <span>Bandingkan</span>
                </button>
            </div>
        </div>

        {{-- Area Grafik --}}
        <div class="h-[480px] w-full relative group">
            <canvas id="keuntunganChart"></canvas>
        </div>
        
        {{-- Footer Chart Info --}}
        <div class="mt-8 pt-8 border-t border-[#E6D5B8]/20 flex flex-wrap gap-8 justify-center">
            <div class="flex items-center gap-3">
                <div class="w-2.5 h-2.5 rounded-full bg-[#332B2B]"></div>
                <span class="text-[10px] font-black text-[#4A3F3F] uppercase tracking-widest">Pendapatan Berjalan</span>
            </div>
            <template x-if="isComparing">
                <div class="flex items-center gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-[#E6D5B8]"></div>
                    <span class="text-[10px] font-black text-[#4A3F3F] uppercase tracking-widest">Pendapatan Sebelumnya</span>
                </div>
            </template>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection