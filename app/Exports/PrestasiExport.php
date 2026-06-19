<?php

namespace App\Exports;

use App\Models\Prestasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PrestasiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Prestasi::with(['siswa', 'kategori', 'tingkat', 'tahunAjaran']);

        // Terapkan Filter yang sama dengan halaman index
        if ($this->request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $this->request->tahun_ajaran_id);
        }
        if ($this->request->filled('kategori_id')) {
            $query->where('kategori_id', $this->request->kategori_id);
        }
        if ($this->request->filled('siswa_id')) {
            $query->where('siswa_id', $this->request->siswa_id);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No', 'NISN', 'Nama Siswa', 'Kelas', 'Tahun Ajaran', 
            'Nama Lomba', 'Juara', 'Kategori', 'Tingkat', 'Tanggal', 'Status', 'Unggulan'
        ];
    }

    public function map($prestasi): array
    {
        static $no = 1;
        return [
            $no++,
            $prestasi->siswa->nisn,
            $prestasi->siswa->nama,
            $prestasi->siswa->kelas->nama_kelas ?? 'Alumni',
            $prestasi->tahunAjaran->tahun,
            $prestasi->nama_lomba,
            $prestasi->juara,
            $prestasi->kategori->nama_kategori,
            $prestasi->tingkat->nama_tingkat,
            $prestasi->tanggal->format('d/m/Y'),
            ucfirst($prestasi->status),
            $prestasi->unggulan ? 'Ya' : 'Tidak'
        ];
    }
}