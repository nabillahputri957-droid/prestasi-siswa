<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['nama_kategori', 'jenis_prestasi'];

    // Relasi ke prestasi (nanti dibuat)
    // TAMBAHKAN KODE INI
    public function prestasi()
    {
        return $this->hasMany(Prestasi::class);
    }
}
