@extends('owner.layouts.layouts')

@section('title', 'Progress Keuntungan')

@section('content')
<div class="space-y-6" 
    x-data="{ 
        range: 'Mingguan',
        isComparing: false,
        selectedDate: '',
        chart: null,
        
        // DATA DUMMY (Data Utama & Data Perbandingan)
        allData: {
            'Mingguan': {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                current: [15, 28, 18, 32, 20, 36, 43],
                previous: [12, 20, 25, 22, 18, 30, 35],
                max: 80, // Max ditingkatkan karena data akan ditumpuk
                unit: ' rb'
            },
            'Bulanan': {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                current: [120, 150, 180, 210, 190, 240, 300, 280, 320, 350, 310, 400],
                previous: [100, 130, 140, 180, 170, 200, 250, 240, 280, 300, 290, 350],
                max: 800, // Max ditingkatkan
                unit: ' rb'
            },
            'Tahunan': {
                labels: ['2022', '2023', '2024', '2025', '2026'],
                current: [1.5, 2.8, 4.2, 5.8, 8.5],
                previous: [1.0, 1.8, 2.5, 4.0, 5.5],
                max: 15, // Max ditingkatkan
                unit: ' jt'
            },
            'Harian': {
                labels: ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'],
                current: [5, 12, 25, 18, 15, 30, 45, 10],
                previous: [3, 8, 20, 15, 10, 25, 35, 5],
                max: 80, // Max ditingkatkan
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

            // Buat gradien untuk dataset utama (atas)
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(115, 125, 140, 0.9)');
            gradient.addColorStop(1, 'rgba(115, 125, 140, 0.4)');

            // Konfigurasi Dataset Utama (Periode Ini - Abu-abu)
            const datasets = [{
                label: this.isComparing ? 'Periode Ini' : 'Keuntungan',
                data: currentData.current,
                borderColor: '#737D8C',
                borderWidth: this.isComparing ? 1 : 3, // Border lebih tipis saat mode banding
                fill: true,
                backgroundColor: gradient,
                tension: 0.4,
                pointRadius: 0,
                order: 1 // Dirender di atas (urutan ke-1)
            }];

            // Tambahkan Dataset Perbandingan (Periode Lalu - Hitam Pekat)
            if (this.isComparing) {
                datasets.push({
                    label: 'Periode Lalu',
                    data: currentData.previous,
                    borderColor: '#000000',
                    backgroundColor: '#000000', // Warna hitam pekat
                    borderWidth: 0, // Tanpa border agar terlihat solid
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    order: 2 // Dirender di bawah (urutan ke-2)
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
                            position: 'bottom',
                            labels: { font: { size: 10, weight: 'bold' }, usePointStyle: true }
                        },
                        tooltip: {
                            enabled: true,
                            backgroundColor: '#374151',
                            padding: 15,
                            cornerRadius: 12,
                            callbacks: {
                                label: (context) => {
                                    const value = context.parsed?.y ?? 0;
                                    return context.dataset.label + ': Rp.' + new Intl.NumberFormat('id-ID').format(value) + currentUnit;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            stacked: this.isComparing, // AKTIFKAN MODE STACKED DI SINI
                            // Hapus max manual agar otomatis menyesuaikan total tumpukan
                            ticks: { 
                                color: '#9CA3AF', 
                                font: { size: 11 },
                                callback: function(value) { return 'Rp.' + value + currentUnit; }
                            },
                            grid: { color: '#F3F4F6' }
                        },
                        x: { grid: { display: false }, ticks: { color: '#9CA3AF', font: { size: 11 } } }
                    }
                }
            });
        }
    }" 
    x-init="renderChart()">
    
    <div class="mb-4">
        <h2 class="text-3xl font-bold text-gray-700">Progress Keuntungan</h2>
        <p class="text-sm text-gray-400 mt-1">
            <span x-show="!isComparing" x-text="selectedDate ? 'Data Harian: ' + selectedDate : 'Analisis Keuntungan Berdasarkan Timeline'"></span>
            <span x-show="isComparing" class="text-slate-600 font-bold" x-text="'Membandingkan ' + range + ' ini dengan ' + range + ' lalu (Stacked)'"></span>
        </p>
    </div>

    <div class="bg-white p-10 rounded-[2rem] shadow-sm border border-gray-100">
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 mb-10">
            <div class="flex items-center gap-2">
                <h3 class="font-bold text-gray-800 text-lg">Grafik Progress Keuntungan</h3>
                <i class="fa-solid fa-circle-info text-gray-400 text-sm"></i>
            </div>
            
            <div class="flex flex-wrap items-center gap-4">
                <input type="date" x-model="selectedDate" @change="updateDate()"
                    class="px-4 py-2 bg-[#F3F4F6] border-none rounded-lg text-xs font-bold text-gray-600 outline-none">

                <div class="flex gap-2 bg-[#F3F4F6] p-1 rounded-xl">
                    <template x-for="item in ['Mingguan', 'Bulanan', 'Tahunan']">
                        <button @click="updateFilter(item)" 
                            :class="range === item && !selectedDate ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500'"
                            class="px-5 py-2 rounded-lg text-xs font-bold transition-all duration-200"
                            x-text="item">
                        </button>
                    </template>
                </div>

                <button @click="toggleComparison()" 
                    :class="isComparing ? 'bg-[#737D8C] text-white' : 'bg-[#F3F4F6] text-gray-500'"
                    class="px-5 py-2 rounded-lg text-xs font-bold transition-all duration-200 shadow-sm flex items-center gap-2"> 
                    Bandingkan
                </button>
            </div>
        </div>

        <div class="h-[450px] w-full relative">
            <canvas id="keuntunganChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection