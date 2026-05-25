<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Gunakan File facade untuk menghapus gambar fisik

class PengaturanController extends Controller
{
    public function index()
    {
        // Ambil data pertama, jika tidak ada, buat otomatis dengan id 1
        $pengaturan = Pengaturan::firstOrCreate(
            ['id' => 1],
            ['nama_sekolah' => 'SMP Negeri 1 Example']
        );

        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $pengaturan = Pengaturan::findOrFail(1);

        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'logo_kop' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'hero_image' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
        ]);

        $data = $request->except(['logo', 'hero_image', 'logo_kop', '_token', '_method']);

        // Tentukan folder tujuan secara fisik di public/storage/pengaturan
        $destinationPath = public_path('storage/pengaturan');

        // Handle Upload Logo
        if ($request->hasFile('logo')) {
            // Hapus logo lama secara fisik jika ada
            if ($pengaturan->logo && File::exists($destinationPath . '/' . $pengaturan->logo)) {
                File::delete($destinationPath . '/' . $pengaturan->logo);
            }
            
            // Simpan logo baru langsung ke folder public
            $logoName = 'logo_' . time() . '.' . $request->logo->getClientOriginalExtension();
            $request->logo->move($destinationPath, $logoName);
            $data['logo'] = $logoName;
        }

        // Handle Upload Logo Kop
        if ($request->hasFile('logo_kop')) {
            if ($pengaturan->logo_kop && File::exists($destinationPath . '/' . $pengaturan->logo_kop)) {
                File::delete($destinationPath . '/' . $pengaturan->logo_kop);
            }
            
            $logoKopName = 'logo_kop_' . time() . '.' . $request->logo_kop->getClientOriginalExtension();
            $request->logo_kop->move($destinationPath, $logoKopName);
            $data['logo_kop'] = $logoKopName;
        }

        // Handle Upload Hero Image
        if ($request->hasFile('hero_image')) {
            // Hapus hero image lama secara fisik jika ada
            if ($pengaturan->hero_image && File::exists($destinationPath . '/' . $pengaturan->hero_image)) {
                File::delete($destinationPath . '/' . $pengaturan->hero_image);
            }
            
            // Simpan hero image baru langsung ke folder public
            $heroName = 'hero_' . time() . '.' . $request->hero_image->getClientOriginalExtension();
            $request->hero_image->move($destinationPath, $heroName);
            $data['hero_image'] = $heroName;
        }

        $pengaturan->update($data);

        return back()->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}