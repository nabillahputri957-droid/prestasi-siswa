<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::latest()->paginate(10);
        return view('admin.tahun_ajaran.index', compact('tahunAjaran'));
    }

    public function create()
    {
        return view('admin.tahun_ajaran.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string|max:20|unique:tahun_ajaran,tahun',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($request->status == 'aktif') {
            TahunAjaran::where('status', 'aktif')->update(['status' => 'nonaktif']);
        }

        TahunAjaran::create($request->all());
        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Tahun Ajaran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        return view('admin.tahun_ajaran.form', compact('tahunAjaran'));
    }

    public function update(Request $request, $id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        $request->validate([
            'tahun' => 'required|string|max:20|unique:tahun_ajaran,tahun,' . $id,
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($request->status == 'aktif' && $tahunAjaran->status == 'nonaktif') {
            TahunAjaran::where('status', 'aktif')->update(['status' => 'nonaktif']);
        }

        $tahunAjaran->update($request->all());
        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Tahun Ajaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        
        if ($tahunAjaran->siswa()->count() > 0) {
            return back()->with('error', 'Gagal dihapus! Tahun ajaran ini masih memiliki data siswa yang terhubung.');
        }

        $tahunAjaran->delete();
        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Tahun Ajaran berhasil dihapus!');
    }

    public function setAktif($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        
        TahunAjaran::where('status', 'aktif')->update(['status' => 'nonaktif']);
        
        $tahunAjaran->update(['status' => 'aktif']);

        return back()->with('success', 'Tahun Ajaran ' . $tahunAjaran->tahun . ' berhasil diaktifkan!');
    }
}
