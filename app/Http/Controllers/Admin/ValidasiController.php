<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Kategori;
use App\Models\Tingkat;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class ValidasiController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $tingkat = Tingkat::orderBy('nama_tingkat')->get();
        $tahunAjaran = TahunAjaran::orderBy('tahun', 'desc')->get();
        $counts = [
            'semua' => Prestasi::count(),
            'pending' => Prestasi::where('status', 'pending')->count(),
            'disetujui' => Prestasi::where('status', 'disetujui')->count(),
            'ditolak' => Prestasi::where('status', 'ditolak')->count(),
        ];

        $currentStatus = $request->get('status', 'semua');
        $query = Prestasi::with(['siswa', 'kategori', 'tingkat', 'tahunAjaran'])->latest();
        if ($currentStatus !== 'semua') {
            $query->where('status', $currentStatus);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lomba', 'like', "%{$search}%")
                  ->orWhereHas('siswa', function($qSiswa) use ($search) {
                      $qSiswa->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter Tingkat
        if ($request->filled('tingkat_id')) {
            $query->where('tingkat_id', $request->tingkat_id);
        }

        // Filter Tahun Ajaran
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        $prestasi = $query->paginate(10)->withQueryString(); // withQueryString agar filter tidak hilang saat pindah halaman pagination

        return view('admin.validasi.index', compact('prestasi', 'kategori', 'tingkat', 'tahunAjaran', 'counts', 'currentStatus'));
    }
}
