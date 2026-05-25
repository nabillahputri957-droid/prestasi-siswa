@extends('layouts.app')

@section('title', 'Verifikasi Data - Kepala Sekolah')
@section('header_title', 'Verifikasi Data')
@section('header_subtitle', 'Validasi setiap pencapaian siswa sebelum dipublikasikan')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="flex border-b border-gray-100 bg-gray-50/50">
        @foreach(['pending' => 'Pending', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak'] as $status => $label)
            <a href="{{ route('kepsek.verifikasi.index', ['status' => $status]) }}" 
               class="px-8 py-4 text-sm font-bold border-b-2 transition-all flex items-center gap-2 
               {{ $currentTab == $status ? 'border-primary text-primary bg-white' : 'border-transparent text-gray-400 hover:text-gray-600' }}">
                {{ $label }} 
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $currentTab == $status ? 'bg-blue-100 text-primary' : 'bg-gray-200 text-gray-500' }}">
                    {{ $counts[$status] }}
                </span>
            </a>
        @endforeach
    </div>

    <div class="p-5 flex flex-wrap gap-4 items-center bg-white">
        <form action="{{ route('kepsek.verifikasi.index') }}" method="GET" class="flex flex-wrap gap-4 w-full">
            <input type="hidden" name="status" value="{{ $currentTab }}">
            <div class="relative flex-1 min-w-[250px]">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama lomba, siswa, atau NISN..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none transition-all">
            </div>
            
            <select name="kategori" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $k) <option value="{{ $k->id }}">{{ $k->jenis_prestasi }} ({{ $k->nama_kategori }})</option> @endforeach
            </select>

            <button type="submit" class="bg-white border border-gray-200 text-gray-600 px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50">
                <i class="fa-solid fa-filter mr-2"></i> Filter
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-[10px] uppercase tracking-widest">
                    <th class="px-6 py-4 font-bold">No</th>
                    <th class="px-6 py-4 font-bold">Nama Lomba</th>
                    <th class="px-6 py-4 font-bold">Siswa</th>
                    <th class="px-6 py-4 font-bold text-center">Kategori</th>
                    <th class="px-6 py-4 font-bold text-center">Tingkat</th>
                    <th class="px-6 py-4 font-bold text-center">Tanggal</th>
                    <th class="px-6 py-4 font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($prestasi as $index => $item)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-400">{{ $prestasi->firstItem() + $index }}</td>
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $item->nama_lomba }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->siswa->nama }}</td>
                    <td class="px-6 py-4 text-center text-gray-600">{{ $item->kategori->jenis_prestasi }} ({{ $item->kategori->nama_kategori }})</td>
                    <td class="px-6 py-4 text-center text-gray-600">{{ $item->tingkat->nama_tingkat }}</td>
                    <td class="px-6 py-4 text-center text-gray-600">{{ $item->tanggal->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('kepsek.verifikasi.show', $item->id) }}" 
                           class="inline-flex items-center justify-center w-8 h-8 rounded-lg {{ $currentTab == 'pending' ? 'bg-orange-50 text-orange-500' : 'bg-blue-50 text-primary' }} hover:scale-110 transition-transform">
                            <i class="{{ $currentTab == 'pending' ? 'fa-solid fa-file-signature' : 'fa-solid fa-eye' }}"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">Tidak ada data untuk diverifikasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-gray-50">{{ $prestasi->links() }}</div>
</div>
@endsection