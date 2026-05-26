<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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

        // LOGIKA DINAMIS UNTUK HOSTING / LOKAL
        // Cek apakah folder public_html ada (berarti di server hosting)
        if (File::exists(base_path('public_html'))) {
            $destinationPath = base_path('public_html/storage/pengaturan');
        } else {
            // Jika tidak ada, gunakan public_path bawaan (untuk di lokal)
            $destinationPath = public_path('storage/pengaturan');
        }

        // PASTIKAN FOLDER ADA, JIKA TIDAK MAKA BUAT OTOMATIS
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }

        // Handle Upload Logo
        if ($request->hasFile('logo')) {
            if ($pengaturan->logo && File::exists($destinationPath . '/' . $pengaturan->logo)) {
                File::delete($destinationPath . '/' . $pengaturan->logo);
            }
            
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
            if ($pengaturan->hero_image && File::exists($destinationPath . '/' . $pengaturan->hero_image)) {
                File::delete($destinationPath . '/' . $pengaturan->hero_image);
            }
            
            $heroName = 'hero_' . time() . '.' . $request->hero_image->getClientOriginalExtension();
            $request->hero_image->move($destinationPath, $heroName);
            $data['hero_image'] = $heroName;
        }

        $pengaturan->update($data);

        return back()->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}