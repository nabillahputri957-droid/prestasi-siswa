@extends('layouts.app')

@section('title', 'Data Prestasi - Kepala Sekolah')
@section('header_title', 'Data Prestasi')
@section('header_subtitle', 'Lihat seluruh data prestasi (hanya dapat melihat)')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
    <div class="p-5 border-b border-gray-50 bg-white">
        <form action="{{ route('kepsek.prestasi.index') }}" method="GET" class="flex flex-wrap gap-4 items-center w-full">
            
            <div class="relative flex-1 min-w-[250px]">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari lomba, nama siswa, atau NISN..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none transition-all">
            </div>

            <select name="kategori_id" onchange="this.form.submit()" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none min-w-[140px] text-gray-600">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->jenis_prestasi }} ({{ $k->nama_kategori }})</option>
                @endforeach
            </select>

            <select name="tingkat_id" onchange="this.form.submit()" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none min-w-[140px] text-gray-600">
                <option value="">Semua Tingkat</option>
                @foreach($tingkat as $t)
                    <option value="{{ $t->id }}" {{ request('tingkat_id') == $t->id ? 'selected' : '' }}>{{ $t->nama_tingkat }}</option>
                @endforeach
            </select>

            <select name="tahun_ajaran_id" onchange="this.form.submit()" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none min-w-[140px] text-gray-600">
                <option value="">Semua Tahun</option>
                @foreach($tahunAjaran as $ta)
                    <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>{{ $ta->tahun }}</option>
                @endforeach
            </select>

            <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none min-w-[140px] text-gray-600">
                <option value="">Semua Status</option>
                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>

            <button type="submit" class="bg-white border border-gray-200 text-gray-600 px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 flex items-center gap-2">
                <i class="fa-solid fa-filter"></i> Filter
            </button>

            @if(request()->anyFilled(['search', 'kategori_id', 'tingkat_id', 'tahun_ajaran_id', 'status']))
                <a href="{{ route('kepsek.prestasi.index') }}" class="px-3 py-2.5 text-gray-400 hover:text-red-500 transition-colors" title="Reset Filter">
                    <i class="fa-solid fa-rotate-right"></i>
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-[10px] uppercase tracking-widest">
                    <th class="px-6 py-4 font-bold">No</th>
                    <th class="px-6 py-4 font-bold">Nama Lomba</th>
                    <th class="px-6 py-4 font-bold">Siswa</th>
                    <th class="px-6 py-4 font-bold">Kategori</th>
                    <th class="px-6 py-4 font-bold">Tingkat</th>
                    <th class="px-6 py-4 font-bold">Tanggal</th>
                    <th class="px-6 py-4 font-bold text-center">Tahun Ajaran</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($prestasi as $index => $item)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-400">{{ $prestasi->firstItem() + $index }}</td>
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $item->nama_lomba }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->siswa->nama }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->kategori->jenis_prestasi }} ({{ $item->kategori->nama_kategori }})</td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->tingkat->nama_tingkat }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->tanggal->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-center text-gray-600">{{ $item->tahunAjaran->tahun }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($item->status == 'pending')
                            <span class="bg-orange-50 text-orange-600 border border-orange-200 px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider">Pending</span>
                        @elseif($item->status == 'disetujui')
                            <span class="bg-green-50 text-green-600 border border-green-200 px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider">Disetujui</span>
                        @else
                            <span class="bg-red-50 text-red-600 border border-red-200 px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider">Ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-3xl mb-3 text-gray-300 block"></i>
                        Tidak ada data prestasi yang sesuai dengan filter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-5 border-t border-gray-50 flex justify-between items-center text-sm text-gray-500">
        <div>
            Menampilkan {{ $prestasi->firstItem() ?? 0 }} - {{ $prestasi->lastItem() ?? 0 }} dari {{ $prestasi->total() }} data
        </div>
        <div>
            {{ $prestasi->links() }}
        </div>
    </div>
</div>
@endsection