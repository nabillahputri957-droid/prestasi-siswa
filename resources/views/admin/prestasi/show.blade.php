@extends('layouts.app')
@section('title', 'Detail Prestasi')
@section('header_title', 'Detail Prestasi Siswa')

@section('content')
<div class="mb-4 flex items-center justify-between">
    <a href="{{ route('admin.prestasi.index') }}" class="text-gray-500 hover:text-primary text-sm font-medium transition-colors">
        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke daftar
    </a>
    <a href="{{ route('admin.prestasi.edit', $prestasi->id) }}" class="bg-yellow-50 text-yellow-600 border border-yellow-200 hover:bg-yellow-100 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
        <i class="fa-regular fa-pen-to-square mr-2"></i>Edit Data
    </a>
</div>

@if($prestasi->status == 'ditolak')
<div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6 flex gap-4 items-start shadow-sm">
    <i class="fa-solid fa-triangle-exclamation text-red-500 text-xl mt-0.5"></i>
    <div>
        <h3 class="text-red-800 font-bold text-sm">Data Ditolak oleh Kepala Sekolah</h3>
        <p class="text-red-600 text-sm mt-1"><strong>Catatan Kepsek:</strong> "{{ $prestasi->catatan }}"</p>
        <p class="text-xs text-red-400 mt-2">Silakan klik tombol Edit Data di atas untuk memperbaiki informasi sesuai catatan.</p>
    </div>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $prestasi->nama_lomba }}</h2>
                    <p class="text-sm text-gray-500 mt-1"><i class="fa-regular fa-calendar mr-1"></i> {{ $prestasi->tanggal->translatedFormat('d F Y') }}</p>
                </div>
                @if($prestasi->status == 'pending')
                    <span class="bg-yellow-50 text-yellow-600 border border-yellow-200 px-4 py-1.5 rounded-full text-sm font-semibold">Pending</span>
                @elseif($prestasi->status == 'disetujui')
                    <span class="bg-green-50 text-green-600 border border-green-200 px-4 py-1.5 rounded-full text-sm font-semibold">Disetujui</span>
                @else
                    <span class="bg-red-50 text-red-600 border border-red-200 px-4 py-1.5 rounded-full text-sm font-semibold">Ditolak</span>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm mb-6 bg-gray-50 p-4 rounded-xl border border-gray-100">
                <div>
                    <p class="text-gray-400 mb-1">Siswa Peraih</p>
                    <p class="font-semibold text-gray-800">{{ $prestasi->siswa->nama }} <span class="text-xs font-normal text-gray-500">({{ $prestasi->siswa->kelas->nama_kelas ?? 'Alumni' }})</span></p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Tahun Ajaran</p>
                    <p class="font-semibold text-gray-800">{{ $prestasi->tahunAjaran->tahun }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Kategori</p>
                    <p class="font-semibold text-gray-800">{{ $prestasi->kategori->jenis_prestasi }} ({{ $prestasi->kategori->nama_kategori }})</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Tingkat Lomba</p>
                    <p class="font-semibold text-gray-800">{{ $prestasi->tingkat->nama_tingkat }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Juara</p>
                    <p class="font-semibold text-gray-800">{{ $prestasi->juara }}</p>
                </div>
            </div>

            <div>
                <p class="text-gray-400 text-sm mb-2">Deskripsi Prestasi</p>
                <p class="text-gray-700 leading-relaxed text-sm whitespace-pre-line">{{ $prestasi->deskripsi }}</p>
            </div>
        </div>
    </div>

    <div class="md:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">File Bukti</h4>
            @php $ext = pathinfo($prestasi->file_bukti, PATHINFO_EXTENSION); @endphp
            
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 text-center mb-4">
                @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                    <a href="{{ asset('storage/bukti_prestasi/' . $prestasi->file_bukti) }}" target="_blank">
                        <img src="{{ asset('storage/bukti_prestasi/' . $prestasi->file_bukti) }}" alt="Bukti" class="w-full h-40 object-cover rounded shadow-sm hover:opacity-90 transition-opacity">
                    </a>
                @else
                    <i class="fa-solid fa-file-pdf text-5xl text-red-500 mb-2"></i>
                    <p class="text-sm font-medium text-gray-700">Dokumen PDF</p>
                @endif
            </div>

            <a href="{{ asset('storage/bukti_prestasi/' . $prestasi->file_bukti) }}" target="_blank" class="w-full block text-center px-4 py-2 bg-primary hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors shadow-sm">
                <i class="fa-solid fa-download mr-2"></i> Lihat / Unduh
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Info Sistem</h4>
            <ul class="text-sm space-y-3 text-gray-600">
                <li class="flex justify-between">
                    <span>Diinput Oleh</span>
                    <span class="font-medium text-gray-800">{{ $prestasi->creator->nama }}</span>
                </li>
                <li class="flex justify-between">
                    <span>Waktu Input</span>
                    <span class="font-medium text-gray-800">{{ $prestasi->created_at->format('d/m/Y H:i') }}</span>
                </li>
                <li class="flex justify-between">
                    <span>Status Unggulan</span>
                    @if($prestasi->unggulan)
                        <span class="text-yellow-600 font-bold"><i class="fa-solid fa-star mr-1"></i>Ya</span>
                    @else
                        <span class="text-gray-400">Tidak</span>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection