<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Tingkat;
use Illuminate\Http\Request;

class ModulPrestasiController extends Controller
{
    public function index()
    {
        $kategori = Kategori::latest()->paginate(10, ['*'], 'kategori_page');
        $tingkat = Tingkat::latest()->paginate(10, ['*'], 'tingkat_page');
        
        return view('admin.modul_prestasi.index', compact('kategori', 'tingkat'));
    }
}
