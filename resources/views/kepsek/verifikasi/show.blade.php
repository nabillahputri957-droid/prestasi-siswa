@extends('layouts.app')

@section('title', 'Detail Validasi Prestasi')
@section('header_title', 'Detail Data Prestasi')
@section('header_subtitle', 'Periksa informasi prestasi sebelum melakukan verifikasi')

@section('content')
<div class="mb-6">
    <a href="{{ route('kepsek.verifikasi.index') }}" class="text-primary font-medium text-sm hover:underline">
        <i class="fa-solid fa-arrow-left mr-2"></i> Verifikasi Data / Detail
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h4 class="text-primary font-bold text-sm uppercase mb-6 flex items-center gap-2">
            <i class="fa-solid fa-trophy"></i> Informasi Prestasi
        </h4>
        <div class="space-y-4 text-sm">
            <div><p class="text-gray-400 mb-1">Nama Lomba</p><p class="font-bold text-gray-800">{{ $prestasi->nama_lomba }}</p></div>
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-gray-400 mb-1">Kategori</p><p class="font-bold text-gray-800">{{ $prestasi->kategori->jenis_prestasi }} ({{ $prestasi->kategori->nama_kategori }})</p></div>
                <div><p class="text-gray-400 mb-1">Tingkat</p><p class="font-bold text-gray-800">{{ $prestasi->tingkat->nama_tingkat }}</p></div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-gray-400 mb-1">Juara</p><p class="font-bold text-blue-600">{{ $prestasi->juara }}</p></div>
                <div><p class="text-gray-400 mb-1">Tanggal</p><p class="font-bold text-gray-800">{{ $prestasi->tanggal->format('d F Y') }}</p></div>
            </div>
            <div><p class="text-gray-400 mb-1">Deskripsi</p><p class="text-gray-600 leading-relaxed">{{ $prestasi->deskripsi }}</p></div>
            <hr class="border-gray-50">
            <div><p class="text-gray-400 mb-1">Diajukan Oleh</p><p class="font-bold text-gray-800">{{ $prestasi->creator->nama }}</p></div>
            <div><p class="text-gray-400 mb-1">Tanggal Pengajuan</p><p class="font-bold text-gray-800">{{ $prestasi->created_at->format('d M Y, H:i') }} WIB</p></div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h4 class="text-primary font-bold text-sm uppercase mb-6 flex items-center gap-2">
            <i class="fa-solid fa-user-graduate"></i> Informasi Siswa
        </h4>
        <div class="space-y-4 text-sm">
            <div><p class="text-gray-400 mb-1">Nama Siswa</p><p class="font-bold text-gray-800 text-lg">{{ $prestasi->siswa->nama }}</p></div>
            <div><p class="text-gray-400 mb-1">NISN</p><p class="font-bold text-gray-800">{{ $prestasi->siswa->nisn }}</p></div>
            <div><p class="text-gray-400 mb-1">Kelas</p><p class="font-bold text-gray-800">{{ $prestasi->siswa->kelas->nama_kelas ?? '-' }}</p></div>
            <div><p class="text-gray-400 mb-1">Tahun Ajaran</p><p class="font-bold text-gray-800">{{ $prestasi->tahunAjaran->tahun }}</p></div>
            <div>
                <p class="text-gray-400 mb-1">Status</p>
                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Aktif</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col">
        <h4 class="text-primary font-bold text-sm uppercase mb-6 flex items-center gap-2">
            <i class="fa-solid fa-certificate"></i> Bukti Prestasi
        </h4>
        <div class="flex-1 bg-gray-50 rounded-xl border border-gray-100 overflow-hidden mb-4 min-h-[250px]">
            @php $ext = pathinfo($prestasi->file_bukti, PATHINFO_EXTENSION); @endphp
            @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                <img src="{{ asset('storage/bukti_prestasi/' . $prestasi->file_bukti) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex flex-col items-center justify-center p-8">
                    <i class="fa-solid fa-file-pdf text-6xl text-red-500 mb-4"></i>
                    <p class="text-xs font-bold text-gray-500">DOKUMEN SERTIFIKAT (PDF)</p>
                </div>
            @endif
        </div>
        <a href="{{ asset('storage/bukti_prestasi/' . $prestasi->file_bukti) }}" target="_blank" class="text-center text-xs font-bold text-primary hover:underline">
            {{ $prestasi->file_bukti }}
        </a>
    </div>

    <div class="lg:col-span-3 mt-4">
        <div class="bg-white rounded-2xl p-8 shadow-md border-t-4 border-primary">
            <h4 class="font-bold text-gray-800 mb-4">Verifikasi Data</h4>
            <form action="{{ route('kepsek.verifikasi.validasi', $prestasi->id) }}" method="POST" id="form-validasi">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Catatan <span class="text-gray-400 font-normal">(Wajib diisi jika menolak)</span></label>
                    <textarea name="catatan" rows="3" placeholder="Berikan catatan atau alasan penolakan..." 
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary outline-none transition-all">{{ $prestasi->catatan }}</textarea>
                </div>

                <div class="flex justify-end gap-4">
                    @if($prestasi->status == 'pending')
                        <button type="submit" name="status" value="disetujui" class="px-10 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl font-bold shadow-lg shadow-green-100 flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-check-double"></i> Setujui
                        </button>
                        <button type="submit" name="status" value="ditolak" class="px-10 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-bold shadow-lg shadow-red-100 flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-xmark"></i> Tolak
                        </button>
                    @else
                        <div class="py-2 px-6 rounded-lg bg-gray-100 text-gray-500 font-bold italic">
                            Status data ini: {{ ucfirst($prestasi->status) }}
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection