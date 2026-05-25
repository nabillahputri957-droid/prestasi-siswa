<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestasi;
use App\Models\Kategori;
use App\Models\Tingkat;
use App\Models\TahunAjaran;

class PrestasiController extends Controller
{
    // Method untuk semua prestasi
    public function index(Request $request)
    {
        return $this->getPrestasiData($request, 'Semua Prestasi', false);
    }

    // Method khusus prestasi unggulan
    public function unggulan(Request $request)
    {
        return $this->getPrestasiData($request, 'Prestasi Unggulan', true);
    }

    // Private method agar kode tidak berulang (DRY)
    private function getPrestasiData(Request $request, $title, $isUnggulan)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $tingkat = Tingkat::orderBy('nama_tingkat')->get();
        $tahunAjaran = TahunAjaran::orderBy('tahun', 'desc')->get();

        $query = Prestasi::with(['siswa.kelas', 'kategori', 'tingkat', 'tahunAjaran'])
                         ->where('status', 'disetujui');

        if ($isUnggulan) {
            $query->where('unggulan', true);
        }

        // Logika Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lomba', 'like', "%{$search}%")
                  ->orWhereHas('siswa', function($qSiswa) use ($search) {
                      $qSiswa->where('nama', 'like', "%{$search}%")
                             ->orWhere('nisn', 'like', "%{$search}%");
                  });
            });
        }
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('tingkat_id')) {
            $query->where('tingkat_id', $request->tingkat_id);
        }
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        $prestasi = $query->latest('tanggal')->paginate(12)->withQueryString();

        // Kita gunakan 1 file view yang sama untuk index & unggulan agar efisien
        return view('pengunjung.prestasi.index', compact('prestasi', 'kategori', 'tingkat', 'tahunAjaran', 'title', 'isUnggulan'));
    }
}
