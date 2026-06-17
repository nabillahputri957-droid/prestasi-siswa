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
            'kelas_id' => 'required|exists:kelas,id',
        ];

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
            'kelas_id' => 'required|exists:kelas,id',
        ];

        $request->validate($rules);
        $data = $request->all();

        $siswa->update($data);
        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Siswa::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data siswa berhasil dihapus!');
    }

    public function searchByNisn(Request $request)
    {
        $nisn = $request->query('nisn');
        $siswa = Siswa::where('nisn', $nisn)->first();

        if ($siswa) {
            return response()->json([
                'success' => true,
                'data' => $siswa
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Siswa tidak ditemukan'
        ]);
    }
}