<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\Kategori;
use App\Models\Tingkat;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\PrestasiSubmitted;

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
            'juara' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'file_bukti' => 'required|mimes:pdf,jpg,jpeg,png|max:5120', 
        ]);

        $taAktif = TahunAjaran::where('status', 'aktif')->first();
        if (!$taAktif) {
            return back()->with('error', 'Tidak ada Tahun Ajaran yang aktif. Silakan set di menu Tahun Ajaran.');
        }

        $data = $request->except('file_bukti');
        $data['tahun_ajaran_id'] = $taAktif->id;
        $data['created_by'] = Auth::id();
        $data['unggulan'] = $request->has('unggulan') ? true : false;
        $data['status'] = 'pending'; 

        if ($request->hasFile('file_bukti')) {
            $file = $request->file('file_bukti');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('storage/bukti_prestasi');
            $file->move($destinationPath, $filename);
            
            $data['file_bukti'] = $filename;
        }

        $prestasi = Prestasi::create($data);

        // Notify Kepala Sekolah
        $kepalaSekolah = User::where('role', 'kepala_sekolah')->get();
        foreach ($kepalaSekolah as $ks) {
            $ks->notify(new PrestasiSubmitted([
                'judul' => 'Validasi Prestasi Baru',
                'pesan' => "Terdapat data prestasi baru '{$prestasi->nama_lomba}' atas nama {$prestasi->siswa->nama} yang menunggu verifikasi Anda.",
                'url' => route('kepsek.verifikasi.show', $prestasi->id),
                'warna' => 'text-blue-500 bg-blue-50',
                'icon' => 'fa-solid fa-file-signature'
            ]));
        }

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
            'juara' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'file_bukti' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->except('file_bukti');
        $data['unggulan'] = $request->has('unggulan') ? true : false;
        
        if ($prestasi->status == 'ditolak') {
            $data['status'] = 'pending';
            $data['catatan'] = null;
        }

        if ($request->hasFile('file_bukti')) {
            $destinationPath = public_path('storage/bukti_prestasi');
            if ($prestasi->file_bukti && File::exists($destinationPath . '/' . $prestasi->file_bukti)) {
                File::delete($destinationPath . '/' . $prestasi->file_bukti);
            }
            
            $file = $request->file('file_bukti');
            $filename = time() . '_' . $file->getClientOriginalName();
        
            $file->move($destinationPath, $filename);
            $data['file_bukti'] = $filename;
        }

        $prestasi->update($data);

        // Jika status berubah jadi pending, kirim notif ulang
        if (isset($data['status']) && $data['status'] == 'pending') {
            $kepalaSekolah = User::where('role', 'kepala_sekolah')->get();
            foreach ($kepalaSekolah as $ks) {
                $ks->notify(new PrestasiSubmitted([
                    'judul' => 'Validasi Revisi Prestasi',
                    'pesan' => "Data prestasi '{$prestasi->nama_lomba}' atas nama {$prestasi->siswa->nama} telah diperbarui dan menunggu verifikasi Anda.",
                    'url' => route('kepsek.verifikasi.show', $prestasi->id),
                    'warna' => 'text-blue-500 bg-blue-50',
                    'icon' => 'fa-solid fa-file-signature'
                ]));
            }
        }

        return redirect()->route('admin.prestasi.index')->with('success', 'Data prestasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $destinationPath = public_path('storage/bukti_prestasi');
        
        if ($prestasi->file_bukti && File::exists($destinationPath . '/' . $prestasi->file_bukti)) {
            File::delete($destinationPath . '/' . $prestasi->file_bukti);
        }
        
        $prestasi->delete();
        return redirect()->route('admin.prestasi.index')->with('success', 'Data prestasi berhasil dihapus!');
    }
}