<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Statistik (Card Atas)
        $total = Prestasi::count();
        $disetujui = Prestasi::where('status', 'disetujui')->count();
        $pending = Prestasi::where('status', 'pending')->count();
        $ditolak = Prestasi::where('status', 'ditolak')->count();

        $stats = [
            'total' => $total,
            'disetujui' => $disetujui,
            'pending' => $pending,
            'ditolak' => $ditolak,
            // Hitung persentase agar dinamis
            'persen_disetujui' => $total > 0 ? round(($disetujui / $total) * 100, 1) : 0,
            'persen_pending' => $total > 0 ? round(($pending / $total) * 100, 1) : 0,
            'persen_ditolak' => $total > 0 ? round(($ditolak / $total) * 100, 1) : 0,
        ];

        // 2. Data Grafik Line (Prestasi per Tahun)
        // Dikelompokkan berdasarkan tahun dari kolom 'tanggal' lomba
        $prestasiPerTahun = Prestasi::select(DB::raw('YEAR(tanggal) as year'), DB::raw('count(*) as total'))
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->take(5) // Ambil 5 tahun terakhir
            ->get();

        $chartTahunan = [
            'labels' => $prestasiPerTahun->pluck('year')->toArray(),
            'data' => $prestasiPerTahun->pluck('total')->toArray(),
        ];

        // 3. Data Grafik Doughnut (Prestasi per Kategori)
        $kategori = Kategori::withCount('prestasi')->get();
        
        $chartKategori = [
            'labels' => $kategori->pluck('nama_kategori')->toArray(),
            'data' => $kategori->pluck('prestasi_count')->toArray(),
        ];

        // Siapkan warna dinamis untuk custom legend di HTML
        $bgColors = ['bg-blue-500', 'bg-indigo-500', 'bg-sky-400', 'bg-cyan-500', 'bg-teal-400', 'bg-blue-300'];
        $kategoriDetails = [];
        foreach($kategori as $index => $kategori) {
            if ($kategori->prestasi_count > 0) { // Hanya tampilkan di legend jika ada datanya
                $colorClass = $bgColors[$index % count($bgColors)];
                $kategoriDetails[$kategori->nama_kategori] = [$colorClass, $kategori->prestasi_count];
            }
        }

        // 4. Data Notifikasi Terbaru (Ambil 5 terbaru)
        $notifikasiRaw = auth()->user()->notifications()->take(5)->get();
        $notifikasiTerbaru = [];
        foreach($notifikasiRaw as $notif) {
            $notifikasiTerbaru[] = [
                'judul' => $notif->data['judul'] ?? 'Pemberitahuan',
                'pesan' => $notif->data['pesan'] ?? 'Ada pembaruan sistem.',
                'waktu' => $notif->created_at->diffForHumans(),
                'icon' => $notif->data['icon'] ?? 'fa-solid fa-bell',
                'bg' => 'bg-blue-50', // Default background
                'color' => 'text-blue-500', // Default text color
            ];
        }

        return view('admin.dashboard.index', compact('stats', 'chartTahunan', 'chartKategori', 'kategoriDetails', 'notifikasiTerbaru'));
    }
}