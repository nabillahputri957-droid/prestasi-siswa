@extends('layouts.app')

@section('title', 'Dashboard - Kepala Sekolah')
@section('header_title', 'Dashboard')
@section('header_subtitle', 'Ringkasan data prestasi dan antrean verifikasi')

@section('content')
<div class="space-y-6 pb-8">
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-orange-400 to-orange-500 text-white rounded-xl p-5 shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-sm font-medium text-orange-100 mb-1">Perlu Verifikasi</p>
                <h3 class="text-3xl font-bold mb-2">{{ $stats['pending'] }}</h3>
                <p class="text-xs text-orange-100">Data menunggu keputusan Anda</p>
            </div>
            <i class="fa-solid fa-clipboard-question absolute -right-4 -bottom-4 text-7xl text-orange-600 opacity-30 z-0"></i>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Prestasi</p>
                <h3 class="text-3xl font-bold text-gray-800 mb-2">{{ $stats['total'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-primary text-xl">
                <i class="fa-solid fa-medal"></i>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Disetujui</p>
                <h3 class="text-3xl font-bold text-green-600 mb-2">{{ $stats['disetujui'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-500 text-xl">
                <i class="fa-solid fa-check-double"></i>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Ditolak / Revisi</p>
                <h3 class="text-3xl font-bold text-red-600 mb-2">{{ $stats['ditolak'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-500 text-xl">
                <i class="fa-solid fa-xmark"></i>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-50 flex justify-between items-center">
            <div>
                <h4 class="text-sm font-semibold text-gray-800">Antrean Verifikasi Terbaru</h4>
                <p class="text-xs text-gray-500 mt-1">Data prestasi yang baru diinput oleh Tata Usaha</p>
            </div>
            <a href="#" class="text-xs font-medium text-primary hover:text-blue-700 hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-medium">Nama Lomba</th>
                        <th class="px-6 py-4 font-medium">Siswa</th>
                        <th class="px-6 py-4 font-medium text-center">Kategori</th>
                        <th class="px-6 py-4 font-medium text-center">Tanggal Input</th>
                        <th class="px-6 py-4 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($prestasiPending as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $item->nama_lomba }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $item->siswa->nama }}</td>
                        <td class="px-6 py-4 text-center text-gray-600">{{ $item->kategori->jenis_prestasi }} ({{ $item->kategori->nama_kategori }})</td>
                        <td class="px-6 py-4 text-center text-gray-600">{{ $item->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="#" class="inline-block bg-orange-50 text-orange-600 hover:bg-orange-100 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors">
                                Proses Validasi
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada data yang menunggu verifikasi. Wah, pekerjaan Anda sudah beres! 🎉</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection