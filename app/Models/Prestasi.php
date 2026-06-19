<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasi';
    
    protected $fillable = [
        'siswa_id', 'tahun_ajaran_id', 'kategori_id', 'tingkat_id',
        'nama_lomba', 'tanggal', 'deskripsi', 'file_bukti',
        'juara', 'status', 'catatan', 'unggulan', 'created_by'
    ];

    protected $casts = [
        'unggulan' => 'boolean',
        'tanggal' => 'date',
    ];
    
    public function siswa() { return $this->belongsTo(Siswa::class); }
    public function tahunAjaran() { return $this->belongsTo(TahunAjaran::class); }
    public function kategori() { return $this->belongsTo(Kategori::class); }
    public function tingkat() { return $this->belongsTo(Tingkat::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
