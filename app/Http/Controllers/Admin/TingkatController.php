<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tingkat;
use Illuminate\Http\Request;

class TingkatController extends Controller
{
    public function index()
    {
        $tingkat = Tingkat::latest()->paginate(10);
        return view('admin.tingkat.index', compact('tingkat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tingkat' => 'required|string|max:50|unique:tingkat,nama_tingkat',
        ]);

        Tingkat::create($request->all());
        return redirect()->back()->with('success', 'Tingkat lomba berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $tingkat = Tingkat::findOrFail($id);
        $request->validate([
            'nama_tingkat' => 'required|string|max:50|unique:tingkat,nama_tingkat,' . $id,
        ]);

        $tingkat->update($request->all());
        return redirect()->back()->with('success', 'Tingkat lomba berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $tingkat = Tingkat::findOrFail($id);
        // Nanti bisa ditambahkan validasi cek relasi ke tabel prestasi di sini
        $tingkat->delete();
        return redirect()->back()->with('success', 'Tingkat lomba berhasil dihapus!');
    }
}
