<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::latest()->paginate(10);
        return view('admin.kelas.index', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas',
        ]);

        Kelas::create($request->all());
        return redirect()->back()->with('success', 'Data Kelas berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $request->validate([
            'nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas,' . $id,
        ]);

        $kelas->update($request->all());
        return redirect()->back()->with('success', 'Data Kelas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        
        if ($kelas->siswa()->count() > 0) {
            return back()->with('error', 'Gagal dihapus! Kelas ini masih memiliki data siswa.');
        }

        $kelas->delete();
        return redirect()->back()->with('success', 'Data Kelas berhasil dihapus!');
    }
}