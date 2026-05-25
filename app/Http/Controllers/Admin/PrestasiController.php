<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\Kategori;
use App\Models\Tingkat;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Menggunakan File untuk manipulasi folder public
use Illuminate\Support\Facades\Auth;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasi = Prestasi::with(['siswa', 'kategori', 'tingkat'])
            ->latest()
            ->paginate(10);
        return view('admin.prestasi.index', compact('prestasi'));
    }

    public function create()
    {
        $siswa = Siswa::where('status', 'aktif')->orderBy('nama')->get();
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $tingkat = Tingkat::orderBy('nama_tingkat')->get();
        return view('admin.prestasi.form', compact('siswa', 'kategori', 'tingkat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kategori_id' => 'required|exists:kategori,id',
            'tingkat_id' => 'required|exists:tingkat,id',
            'nama_lomba' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'file_bukti' => 'required|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        // Cek Tahun Ajaran Aktif
        $taAktif = TahunAjaran::where('status', 'aktif')->first();
        if (!$taAktif) {
            return back()->with('error', 'Tidak ada Tahun Ajaran yang aktif. Silakan set di menu Tahun Ajaran.');
        }

        $data = $request->except('file_bukti');
        $data['tahun_ajaran_id'] = $taAktif->id;
        $data['created_by'] = Auth::id();
        $data['unggulan'] = $request->has('unggulan') ? true : false;
        $data['status'] = 'pending'; // Default saat input baru

        if ($request->hasFile('file_bukti')) {
            $file = $request->file('file_bukti');
            // Format nama: Time_NamaFileAsli.ext
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Pindahkan file langsung ke folder public/storage/bukti_prestasi
            $destinationPath = public_path('storage/bukti_prestasi');
            $file->move($destinationPath, $filename);
            
            $data['file_bukti'] = $filename;
        }

        Prestasi::create($data);
        return redirect()->route('admin.prestasi.index')->with('success', 'Data prestasi berhasil ditambahkan dan berstatus Pending.');
    }

    public function show($id)
    {
        $prestasi = Prestasi::with(['siswa.kelas', 'tahunAjaran', 'kategori', 'tingkat', 'creator'])->findOrFail($id);
        return view('admin.prestasi.show', compact('prestasi'));
    }

    public function edit($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $siswa = Siswa::where('status', 'aktif')->orderBy('nama')->get();
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $tingkat = Tingkat::orderBy('nama_tingkat')->get();
        return view('admin.prestasi.form', compact('prestasi', 'siswa', 'kategori', 'tingkat'));
    }

    public function update(Request $request, $id)
    {
        $prestasi = Prestasi::findOrFail($id);
        
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kategori_id' => 'required|exists:kategori,id',
            'tingkat_id' => 'required|exists:tingkat,id',
            'nama_lomba' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'file_bukti' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->except('file_bukti');
        $data['unggulan'] = $request->has('unggulan') ? true : false;
        
        // Jika statusnya ditolak, diedit otomatis jadi pending lagi untuk ditinjau kepsek
        if ($prestasi->status == 'ditolak') {
            $data['status'] = 'pending';
            $data['catatan'] = null; // Reset catatan
        }

        if ($request->hasFile('file_bukti')) {
            $destinationPath = public_path('storage/bukti_prestasi');
            
            // Hapus file lama secara fisik jika ada
            if ($prestasi->file_bukti && File::exists($destinationPath . '/' . $prestasi->file_bukti)) {
                File::delete($destinationPath . '/' . $prestasi->file_bukti);
            }
            
            $file = $request->file('file_bukti');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Simpan file baru
            $file->move($destinationPath, $filename);
            $data['file_bukti'] = $filename;
        }

        $prestasi->update($data);
        return redirect()->route('admin.prestasi.index')->with('success', 'Data prestasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $destinationPath = public_path('storage/bukti_prestasi');
        
        // Hapus file fisik bukti prestasi
        if ($prestasi->file_bukti && File::exists($destinationPath . '/' . $prestasi->file_bukti)) {
            File::delete($destinationPath . '/' . $prestasi->file_bukti);
        }
        
        $prestasi->delete();
        return redirect()->route('admin.prestasi.index')->with('success', 'Data prestasi berhasil dihapus!');
    }
}