<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\TahunAjaran;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Data Statistik Hero
        $totalPrestasi = Prestasi::where('status', 'disetujui')->count();
        $totalSiswa = Siswa::count();

        // 2. Data Master untuk Filter Timeline
        $tahunAjaran = TahunAjaran::orderBy('tahun', 'desc')->get();

        // 3. Data Prestasi Unggulan (Ditampilkan 5 terbaru di Home)
        $unggulans = Prestasi::with(['siswa', 'kategori', 'tingkat'])
            ->where('status', 'disetujui')
            ->where('unggulan', true)
            ->latest('tanggal')
            ->take(5)
            ->get();

        // 4. Data Timeline (Hanya NON-Unggulan)
        $queryTimeline = Prestasi::with(['siswa.kelas', 'kategori', 'tingkat', 'tahunAjaran'])
            ->where('status', 'disetujui')
            ->where('unggulan', false);

        // Filter Tahun Ajaran pada Timeline
        if ($request->filled('tahun_ajaran_id')) {
            $queryTimeline->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        // Paginasi Timeline 5 data per halaman
        $prestasi = $queryTimeline->latest('tanggal')->paginate(5)->withQueryString();

        return view('pengunjung.home.index', compact(
            'totalPrestasi', 'totalSiswa', 'tahunAjaran', 'unggulans', 'prestasi'
        ));
    }
}