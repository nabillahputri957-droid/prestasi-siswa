@extends('layouts.public')

@section('title', $title . ' - SMP Negeri 1 Example')

@section('content')

<div class="pt-28 pb-16 bg-slate-50 border-b border-slate-200">
    <div class="container mx-auto px-4 md:px-8 max-w-7xl text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4 flex items-center justify-center gap-3">
            @if($isUnggulan)
                <i class="fa-solid fa-star text-yellow-400"></i>
            @else
                <i class="fa-solid fa-medal text-primary"></i>
            @endif
            {{ $title }}
        </h1>
        <p class="text-slate-500 max-w-2xl mx-auto">
            Jelajahi seluruh rekam jejak pencapaian siswa dan alumni kami. Gunakan fitur pencarian untuk menemukan data yang lebih spesifik.
        </p>
    </div>
</div>

<section class="py-12 bg-white min-h-screen">
    <div class="container mx-auto px-4 md:px-8 max-w-7xl">
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-10">
            <form action="{{ $isUnggulan ? route('public.prestasi.unggulan') : route('public.prestasi.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama lomba atau siswa..." 
                           class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-transparent rounded-xl focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-sm font-medium">
                </div>
                <div class="flex-1">
                    <select name="kategori_id" class="w-full px-4 py-3 bg-slate-50 border border-transparent rounded-xl focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-sm font-medium text-slate-600">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori as $k) <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->jenis_prestasi }} ({{ $k->nama_kategori }})</option> @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <select name="tingkat_id" class="w-full px-4 py-3 bg-slate-50 border border-transparent rounded-xl focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-sm font-medium text-slate-600">
                        <option value="">Semua Tingkat</option>
                        @foreach($tingkat as $t) <option value="{{ $t->id }}" {{ request('tingkat_id') == $t->id ? 'selected' : '' }}>{{ $t->nama_tingkat }}</option> @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <select name="tahun_ajaran_id" class="w-full px-4 py-3 bg-slate-50 border border-transparent rounded-xl focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-sm font-medium text-slate-600">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunAjaran as $ta) <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>{{ $ta->tahun }}</option> @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-primary hover:bg-blue-600 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-md shadow-blue-500/20 whitespace-nowrap">
                    Cari Data
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($prestasi as $item)
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group flex flex-col">
                <div class="h-48 bg-slate-100 relative overflow-hidden">
                    @php $ext = pathinfo($item->file_bukti, PATHINFO_EXTENSION); @endphp
                    @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/bukti_prestasi/' . $item->file_bukti) }}" alt="Bukti" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-blue-50 text-blue-300 group-hover:scale-105 transition-transform duration-500">
                            <i class="fa-solid fa-file-pdf text-5xl"></i>
                        </div>
                    @endif
                    
                    @if($item->unggulan)
                        <div class="absolute top-4 right-4 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1">
                            <i class="fa-solid fa-star"></i> Unggulan
                        </div>
                    @endif
                </div>

                <div class="p-6 flex flex-col flex-1">
                    <div class="flex gap-2 mb-3 flex-wrap">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-primary bg-blue-50 px-2.5 py-1 rounded-md">{{ $item->kategori->jenis_prestasi }} ({{ $item->kategori->nama_kategori }})</span>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md">{{ $item->tingkat->nama_tingkat }}</span>
                    </div>
                    
                    <h3 class="font-bold text-lg text-slate-900 mb-1 leading-tight">{{ $item->nama_lomba }}</h3>
                    <p class="text-slate-500 text-sm mb-4 line-clamp-2">{{ $item->deskripsi }}</p>
                    
                    <div class="mt-auto pt-4 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-sm">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-slate-800">{{ $item->siswa->nama }}</p>
                            <p class="text-xs text-slate-500">Kelas {{ $item->siswa->kelas->nama_kelas ?? 'Alumni' }} • {{ $item->tanggal->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center bg-slate-50 rounded-2xl border border-slate-200 border-dashed">
                <i class="fa-solid fa-folder-open text-5xl text-slate-300 mb-4 block"></i>
                <h3 class="text-xl font-bold text-slate-700">Tidak Ada Data Ditemukan</h3>
                <p class="text-slate-500 mt-2">Data prestasi yang Anda cari tidak tersedia. Silakan ubah filter pencarian.</p>
                <a href="{{ $isUnggulan ? route('public.prestasi.unggulan') : route('public.prestasi.index') }}" class="inline-block mt-6 bg-white border border-slate-200 text-slate-600 px-6 py-2 rounded-lg font-medium hover:bg-slate-50 transition-colors shadow-sm">
                    Reset Filter
                </a>
            </div>
            @endforelse
        </div>

        @if($prestasi->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $prestasi->links() }}
        </div>
        @endif

    </div>
</section>

@endsection