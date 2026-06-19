@extends('layouts.app')

@section('title', 'Validasi Status Data')
@section('header_title', 'Validasi Status Data')
@section('header_subtitle', 'Pantau dan kelola status data prestasi secara komprehensif')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
    <div class="border-b border-gray-100 flex overflow-x-auto hide-scrollbar">
        <a href="{{ route('admin.validasi.index', array_merge(request()->query(), ['status' => 'semua'])) }}" 
           class="px-6 py-4 text-sm font-semibold whitespace-nowrap transition-colors flex items-center gap-2 border-b-2 {{ $currentStatus == 'semua' ? 'border-blue-400 text-blue-400' : 'border-transparent text-gray-500 hover:text-blue-500' }}">
           Semua <span class="bg-blue-50 text-blue-600 py-0.5 px-2 rounded-full text-xs">{{ $counts['semua'] }}</span>
        </a>
        
        <a href="{{ route('admin.validasi.index', array_merge(request()->query(), ['status' => 'pending'])) }}" 
           class="px-6 py-4 text-sm font-semibold whitespace-nowrap transition-colors flex items-center gap-2 border-b-2 {{ $currentStatus == 'pending' ? 'border-orange-500 text-orange-500' : 'border-transparent text-gray-500 hover:text-orange-500' }}">
           Pending <span class="bg-orange-50 text-orange-600 py-0.5 px-2 rounded-full text-xs">{{ $counts['pending'] }}</span>
        </a>

        <a href="{{ route('admin.validasi.index', array_merge(request()->query(), ['status' => 'disetujui'])) }}" 
           class="px-6 py-4 text-sm font-semibold whitespace-nowrap transition-colors flex items-center gap-2 border-b-2 {{ $currentStatus == 'disetujui' ? 'border-green-500 text-green-500' : 'border-transparent text-gray-500 hover:text-green-500' }}">
           Disetujui <span class="bg-green-50 text-green-600 py-0.5 px-2 rounded-full text-xs">{{ $counts['disetujui'] }}</span>
        </a>

        <a href="{{ route('admin.validasi.index', array_merge(request()->query(), ['status' => 'ditolak'])) }}" 
           class="px-6 py-4 text-sm font-semibold whitespace-nowrap transition-colors flex items-center gap-2 border-b-2 {{ $currentStatus == 'ditolak' ? 'border-red-500 text-red-500' : 'border-transparent text-gray-500 hover:text-red-500' }}">
           Ditolak <span class="bg-red-50 text-red-600 py-0.5 px-2 rounded-full text-xs">{{ $counts['ditolak'] }}</span>
        </a>
    </div>

    <div class="p-5 border-b border-gray-50 bg-gray-50/30">
        <form action="{{ route('admin.validasi.index') }}" method="GET" class="flex flex-wrap gap-4 items-center">
            <input type="hidden" name="status" value="{{ $currentStatus }}">

            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama lomba atau siswa..." 
                       class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
            </div>

            <select name="kategori_id" onchange="this.form.submit()" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none min-w-[150px] cursor-pointer text-gray-600">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->jenis_prestasi }} ({{ $k->nama_kategori }})</option>
                @endforeach
            </select>

            <select name="tingkat_id" onchange="this.form.submit()" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none min-w-[150px] cursor-pointer text-gray-600">
                <option value="">Semua Tingkat</option>
                @foreach($tingkat as $t)
                    <option value="{{ $t->id }}" {{ request('tingkat_id') == $t->id ? 'selected' : '' }}>{{ $t->nama_tingkat }}</option>
                @endforeach
            </select>

            <select name="tahun_ajaran_id" onchange="this.form.submit()" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none min-w-[150px] cursor-pointer text-gray-600">
                <option value="">Semua Tahun</option>
                @foreach($tahunAjaran as $ta)
                    <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>{{ $ta->tahun }}</option>
                @endforeach
            </select>

            @if(request('search') || request('kategori_id') || request('tingkat_id') || request('tahun_ajaran_id'))
                <a href="{{ route('admin.validasi.index', ['status' => $currentStatus]) }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition-colors" title="Reset Filter">
                    <i class="fa-solid fa-rotate-right"></i>
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium">No</th>
                    <th class="px-6 py-4 font-medium">Nama Lomba</th>
                    <th class="px-6 py-4 font-medium">Siswa</th>
                    <th class="px-6 py-4 font-medium text-center">Kategori</th>
                    <th class="px-6 py-4 font-medium text-center">Tingkat</th>
                    <th class="px-6 py-4 font-medium text-center">Tanggal</th>
                    <th class="px-6 py-4 font-medium text-center">Status</th>
                    <th class="px-6 py-4 font-medium text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($prestasi as $index => $item)
                <tr class="hover:bg-gray-50/50 transition-colors {{ $item->status == 'ditolak' ? 'bg-red-50/20' : '' }}">
                    <td class="px-6 py-4 text-gray-500">{{ $prestasi->firstItem() + $index }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $item->nama_lomba }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->siswa->nama }}</td>
                    <td class="px-6 py-4 text-center text-gray-600">{{ $item->kategori->jenis_prestasi }} ({{ $item->kategori->nama_kategori }})</td>
                    <td class="px-6 py-4 text-center text-gray-600">{{ $item->tingkat->nama_tingkat }}</td>
                    <td class="px-6 py-4 text-center text-gray-600">{{ $item->tanggal->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($item->status == 'pending')
                            <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded text-xs font-semibold">Pending</span>
                        @elseif($item->status == 'disetujui')
                            <span class="bg-green-100 text-green-600 px-3 py-1 rounded text-xs font-semibold">Disetujui</span>
                        @else
                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded text-xs font-semibold">Ditolak</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.prestasi.show', $item->id) }}" class="text-gray-400 hover:text-gray-800 transition-colors" title="Lihat Detail"><i class="fa-regular fa-eye text-lg"></i></a>
                            
                            <a href="{{ route('admin.prestasi.edit', $item->id) }}" class="{{ $item->status == 'ditolak' ? 'text-red-500 hover:text-red-700' : 'text-gray-400 hover:text-blue-500' }} transition-colors" title="Edit Data">
                                <i class="fa-regular fa-pen-to-square text-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-3xl mb-3 text-gray-300 block"></i>
                        Data prestasi tidak ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-5 border-t border-gray-50">
        {{ $prestasi->links() }}
    </div>
</div>
@endsection