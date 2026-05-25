<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $siswa = Siswa::with(['tahunAjaran', 'kelas'])
            ->when($search, function($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                             ->orWhere('nisn', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        // Data untuk dropdown di Modal
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        $tahunAjaran = TahunAjaran::orderBy('tahun', 'desc')->get();
            
        return view('admin.siswa.index', compact('siswa', 'kelas', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nisn' => 'required|unique:siswa,nisn',
            'nama' => 'required|string|max:255',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'status' => 'required|in:aktif,alumni',
        ];

        // Jika status aktif, kelas wajib diisi
        if ($request->status == 'aktif') {
            $rules['kelas_id'] = 'required|exists:kelas,id';
        }

        $request->validate($rules);

        Siswa::create($request->all());
        return redirect()->back()->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $rules = [
            'nisn' => 'required|unique:siswa,nisn,' . $id,
            'nama' => 'required|string|max:255',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'status' => 'required|in:aktif,alumni',
        ];

        if ($request->status == 'aktif') {
            $rules['kelas_id'] = 'required|exists:kelas,id';
        }

        $request->validate($rules);

        // Jika alumni, kita bisa mengosongkan kelas_id atau membiarkannya
        $data = $request->all();
        if ($request->status == 'alumni') {
            $data['kelas_id'] = null;
        }

        $siswa->update($data);
        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Siswa::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data siswa berhasil dihapus!');
    }
}