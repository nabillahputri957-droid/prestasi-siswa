<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Kategori;
use App\Models\Tingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PrestasiValidated; // Opsional: Untuk kirim notif nanti

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::all();
        $tingkat = Tingkat::all();
        
        $currentTab = $request->get('status', 'pending');
        
        $counts = [
            'pending' => Prestasi::where('status', 'pending')->count(),
            'disetujui' => Prestasi::where('status', 'disetujui')->count(),
            'ditolak' => Prestasi::where('status', 'ditolak')->count(),
        ];

        $query = Prestasi::with(['siswa', 'kategori', 'tingkat'])->where('status', $currentTab);

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('nama_lomba', 'like', '%' . $request->search . '%')
                  ->orWhereHas('siswa', function($q) use ($request) {
                      $q->where('nama', 'like', '%' . $request->search . '%');
                  });
        }

        $prestasi = $query->latest()->paginate(10)->withQueryString();

        return view('kepsek.verifikasi.index', compact('prestasi', 'counts', 'currentTab', 'kategori', 'tingkat'));
    }

    public function show($id)
    {
        $prestasi = Prestasi::with(['siswa.kelas', 'tahunAjaran', 'kategori', 'tingkat', 'creator'])->findOrFail($id);
        return view('kepsek.verifikasi.show', compact('prestasi'));
    }

    public function validasi(Request $request, $id)
    {
        $prestasi = Prestasi::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => $request->status == 'ditolak' ? 'required|string' : 'nullable|string',
        ], [
            'catatan.required' => 'Wajib memberikan catatan jika data ditolak.'
        ]);

        $prestasi->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        // Logika Notifikasi ke Admin (Pembuat data)
        $admin = $prestasi->creator;
        $statusTeks = $request->status == 'disetujui' ? 'DISETUJUI' : 'DITOLAK';
        $warna = $request->status == 'disetujui' ? 'text-green-500 bg-green-50' : 'text-red-500 bg-red-50';
        $icon = $request->status == 'disetujui' ? 'fa-solid fa-check-circle' : 'fa-solid fa-circle-xmark';

        $admin->notify(new \App\Notifications\PrestasiValidated([
            'judul' => "Data Prestasi $statusTeks",
            'pesan' => "Data prestasi '{$prestasi->nama_lomba}' atas nama {$prestasi->siswa->nama} telah {$request->status} oleh Kepala Sekolah.",
            'url' => route('admin.prestasi.show', $prestasi->id),
            'warna' => $warna,
            'icon' => $icon
        ]));

        return redirect()->route('kepsek.verifikasi.index')->with('success', 'Data berhasil divalidasi!');
    }
}
