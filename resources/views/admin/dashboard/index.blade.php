@extends('layouts.app')

@section('title', 'Dashboard - Admin Tata Usaha')
@section('header_title', 'Dashboard')
@section('header_subtitle', 'Ringkasan data prestasi siswa')

@section('content')
<div class="space-y-6 pb-8">
    
    <!-- STATISTIK KARTU ATAS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-blue-200 text-gray-800 rounded-xl p-5 shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-sm font-medium text-gray-800 mb-1">Total Prestasi</p>
                <h3 class="text-3xl font-bold mb-2">{{ number_format($stats['total'], 0, ',', '.') }}</h3>
                <p class="text-xs text-black-600"><i class="fa-solid fa-chart-simple mr-1"></i> Keseluruhan Data</p>
            </div>
            <i class="fa-solid fa-medal absolute -right-4 -bottom-4 text-7xl text-blue-600 opacity-50 z-0"></i>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Disetujui</p>
                <h3 class="text-3xl font-bold text-gray-800 mb-2">{{ number_format($stats['disetujui'], 0, ',', '.') }}</h3>
                <p class="text-xs text-gray-400">{{ $stats['persen_disetujui'] }}% dari total</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-500 text-xl">
                <i class="fa-solid fa-check-double"></i>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Pending</p>
                <h3 class="text-3xl font-bold text-gray-800 mb-2">{{ number_format($stats['pending'], 0, ',', '.') }}</h3>
                <p class="text-xs text-gray-400">{{ $stats['persen_pending'] }}% dari total</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-500 text-xl">
                <i class="fa-regular fa-clock"></i>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Ditolak</p>
                <h3 class="text-3xl font-bold text-gray-800 mb-2">{{ number_format($stats['ditolak'], 0, ',', '.') }}</h3>
                <p class="text-xs text-gray-400">{{ $stats['persen_ditolak'] }}% dari total</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-500 text-xl">
                <i class="fa-regular fa-rectangle-xmark"></i>
            </div>
        </div>
    </div>

    <!-- AREA GRAFIK -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm lg:col-span-2">
            <h4 class="text-sm font-semibold text-gray-800 mb-4">Grafik Prestasi per Tahun</h4>
            <div class="h-64 w-full">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
            <h4 class="text-sm font-semibold text-gray-800 mb-4">Prestasi Berdasarkan Kategori</h4>
            <div class="h-56 w-full relative flex items-center justify-center">
                <canvas id="doughnutChart"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none mt-4">
                    <span class="text-xs text-gray-400">Total</span>
                    <span class="text-xl font-bold text-gray-800">{{ number_format($stats['total'], 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="mt-4 space-y-2">
                <!-- Custom Legend Kategori Dinamis -->
                @forelse($kategoriDetails as $label => $val)
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $val[0] }}"></span>
                        <span class="text-gray-600">{{ $label }}</span>
                    </div>
                    <span class="text-gray-800 font-medium">{{ $val[1] }}</span>
                </div>
                @empty
                <div class="text-center text-xs text-gray-400 mt-4">Belum ada data</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- NOTIFIKASI TERBARU -->
    <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-50 flex justify-between items-center">
            <h4 class="text-sm font-semibold text-gray-800">Notifikasi Terbaru</h4>
            <a href="#" class="text-xs text-primary hover:underline">Lihat Semua</a>
        </div>
        <div class="p-0">
            @forelse($notifikasiTerbaru as $notif)
            <div class="flex gap-4 p-5 border-b border-gray-50 last:border-0 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center {{ $notif['bg'] }} {{ $notif['color'] }}">
                    <i class="{{ $notif['icon'] }}"></i>
                </div>
                <div class="flex-1">
                    <h5 class="text-sm font-semibold text-gray-800">{{ $notif['judul'] }}</h5>
                    <p class="text-xs text-gray-500 mt-1">{{ $notif['pesan'] }}</p>
                </div>
                <span class="text-[11px] text-gray-400 whitespace-nowrap">{{ $notif['waktu'] }}</span>
            </div>
            @empty
            <div class="p-8 text-center text-sm text-gray-400">
                Tidak ada notifikasi baru.
            </div>
            @endforelse
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pengecekan data untuk Bar Chart (Tadinya Line Chart)
        const barLabels = {!! json_encode($chartTahunan['labels']) !!};
        const barData = {!! json_encode($chartTahunan['data']) !!};
        
        // Init Bar Chart (Hanya jika ada data)
        if(barLabels.length > 0) {
            const ctxBar = document.getElementById('lineChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar', // DIUBAH DARI 'line' MENJADI 'bar'
                data: {
                    labels: barLabels,
                    datasets: [{
                        label: 'Total Prestasi',
                        data: barData,
                        backgroundColor: '#93c5fd', // Warna biru solid
                        hoverBackgroundColor: '##93c5fd', // Biru lebih gelap saat dihover
                        borderRadius: 6, // Ujung atas batang agak melengkung (modern look)
                        borderSkipped: false,
                        barThickness: 'flex', // Menyesuaikan lebar batang secara otomatis
                        maxBarThickness: 40 // Maksimal lebar batang agar tidak terlalu gemuk
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 10,
                            titleFont: { size: 13, family: 'Poppins' },
                            bodyFont: { size: 12, family: 'Poppins' }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            border: {display: false}, 
                            grid: {color: '#f3f4f6'},
                            ticks: {
                                precision: 0 // Pastikan angka di sumbu Y adalah bilangan bulat (1, 2, 3...)
                            }
                        },
                        x: { 
                            border: {display: false}, 
                            grid: {display: false} 
                        }
                    }
                }
            });
        }

        // Pengecekan data untuk Doughnut Chart (Tetap sama)
        const doughnutLabels = {!! json_encode($chartKategori['labels']) !!};
        const doughnutData = {!! json_encode($chartKategori['data']) !!};

        // Init Doughnut Chart (Hanya jika ada data)
        if(doughnutData.length > 0) {
            const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: doughnutLabels,
                    datasets: [{
                        data: doughnutData,
                        backgroundColor: ['#93c5fd', '#6366f1', '#38bdf8', '#06b6d4', '#2dd4bf', '#93c5fd'],
                        borderWidth: 0,
                        cutout: '75%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        }
    });
</script>
@endsection