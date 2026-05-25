@extends('layouts.app')

@section('title', 'Laporan & Export - Kepala Sekolah')
@section('header_title', 'Laporan Data Prestasi')
@section('header_subtitle', 'Generate dan unduh rekapitulasi data prestasi siswa')

@section('content')
<div class="space-y-6">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="text-sm font-semibold text-gray-800 mb-4 uppercase tracking-wider">Filter Laporan</h4>
            <form action="{{ route('kepsek.laporan.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Tahun Ajaran</label>
                        <select name="tahun_ajaran_id" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                            <option value="">Semua Tahun Ajaran</option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>{{ $ta->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Kategori</label>
                        <select name="kategori_id" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                            <option value="">Semua Kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->jenis_prestasi }} ({{ $k->nama_kategori }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Siswa</label>
                        <select name="siswa_id" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                            <option value="">Semua Siswa</option>
                            @foreach($siswa as $siswa)
                                <option value="{{ $siswa->id }}" {{ request('siswa_id') == $siswa->id ? 'selected' : '' }}>{{ $siswa->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-5 py-2 bg-primary hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors shadow-sm">
                        Tampilkan Data
                    </button>
                    @if(request()->anyFilled(['tahun_ajaran_id', 'kategori_id', 'siswa_id']))
                        <a href="{{ route('kepsek.laporan.index') }}" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg text-sm font-medium transition-colors">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <h4 class="text-sm font-semibold text-gray-800 mb-4 uppercase tracking-wider">Export Laporan</h4>
            <p class="text-xs text-gray-500 mb-6">File hasil export akan menyesuaikan dengan filter data di samping.</p>
            
            <div class="mt-auto space-y-3">
                <a href="{{ route('kepsek.laporan.pdf', request()->query()) }}" target="_blank" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white border border-red-200 rounded-lg text-sm font-semibold transition-all">
                    <i class="fa-solid fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('kepsek.laporan.excel', request()->query()) }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-green-50 text-green-600 hover:bg-green-600 hover:text-white border border-green-200 rounded-lg text-sm font-semibold transition-all">
                    <i class="fa-solid fa-file-excel"></i> Export Excel
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-100 p-4 rounded-xl shadow-sm text-center">
            <p class="text-xs text-gray-500 mb-1">Total Prestasi</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</h3>
        </div>
        <div class="bg-white border border-green-100 p-4 rounded-xl shadow-sm text-center">
            <p class="text-xs text-green-600 mb-1">Disetujui</p>
            <h3 class="text-2xl font-bold text-green-600">{{ $stats['disetujui'] }}</h3>
        </div>
        <div class="bg-white border border-orange-100 p-4 rounded-xl shadow-sm text-center">
            <p class="text-xs text-orange-600 mb-1">Pending</p>
            <h3 class="text-2xl font-bold text-orange-600">{{ $stats['pending'] }}</h3>
        </div>
        <div class="bg-white border border-red-100 p-4 rounded-xl shadow-sm text-center">
            <p class="text-xs text-red-600 mb-1">Ditolak</p>
            <h3 class="text-2xl font-bold text-red-600">{{ $stats['ditolak'] }}</h3>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-50 bg-gray-50">
            <h4 class="text-sm font-semibold text-gray-800">Preview Data Laporan</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-[10px] uppercase tracking-widest">
                        <th class="px-6 py-4 font-bold">Nama Lomba</th>
                        <th class="px-6 py-4 font-bold">Siswa</th>
                        <th class="px-6 py-4 font-bold">Kategori</th>
                        <th class="px-6 py-4 font-bold">Tingkat</th>
                        <th class="px-6 py-4 font-bold">Tanggal</th>
                        <th class="px-6 py-4 font-bold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($prestasi as $item)
                    <tr>
                        <td class="px-6 py-4 text-gray-800 font-bold">{{ $item->nama_lomba }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $item->siswa->nama }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $item->kategori->jenis_prestasi }} ({{ $item->kategori->nama_kategori }})</td>
                        <td class="px-6 py-4 text-gray-600">{{ $item->tingkat->nama_tingkat }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $item->tanggal->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($item->status == 'disetujui')
                                <span class="bg-green-50 text-green-600 border border-green-200 px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider">Disetujui</span>
                            @elseif($item->status == 'pending')
                                <span class="bg-orange-50 text-orange-600 border border-orange-200 px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider">Pending</span>
                            @else
                                <span class="bg-red-50 text-red-600 border border-red-200 px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada data untuk ditampilkan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-50">{{ $prestasi->links() }}</div>
    </div>
</div>
@endsection