<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestasi;
use App\Models\TahunAjaran;
use App\Models\Kategori;
use App\Models\Siswa;
use App\Exports\PrestasiExport; // Memakai ulang class export dari Admin
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tahunAjaran = TahunAjaran::orderBy('tahun', 'desc')->get();
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $siswa = Siswa::orderBy('nama')->get();

        // Base Query
        $query = Prestasi::with(['siswa', 'kategori', 'tingkat', 'tahunAjaran']);

        // Logika Filter
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('siswa_id')) {
            $query->where('siswa_id', $request->siswa_id);
        }

        // Data untuk Kartu Ringkasan
        $stats = [
            'total' => (clone $query)->count(),
            'disetujui' => (clone $query)->where('status', 'disetujui')->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'ditolak' => (clone $query)->where('status', 'ditolak')->count(),
        ];

        $prestasi = $query->latest()->paginate(10)->withQueryString();

        return view('kepsek.laporan.index', compact('prestasi', 'tahunAjaran', 'kategori', 'siswa', 'stats'));
    }

    public function exportPdf(Request $request)
    {
        $query = Prestasi::with(['siswa', 'kategori', 'tingkat', 'tahunAjaran']);

        // Terapkan filter yang sama untuk export
        if ($request->filled('tahun_ajaran_id')) $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        if ($request->filled('kategori_id')) $query->where('kategori_id', $request->kategori_id);
        if ($request->filled('siswa_id')) $query->where('siswa_id', $request->siswa_id);

        $prestasi = $query->latest()->get();

        // Kita gunakan view PDF yang sama dengan milik Admin agar seragam
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('prestasi'))->setPaper('a4', 'landscape');
        
        return $pdf->download('Laporan_Prestasi_Kepsek.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new PrestasiExport($request), 'Laporan_Prestasi_Kepsek.xlsx');
    }
}
