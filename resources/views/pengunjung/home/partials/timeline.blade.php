<section id="timeline" class="py-20 bg-white">
    <div class="container mx-auto px-4 md:px-8 max-w-7xl">
        
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl font-bold text-slate-900 mb-4">Timeline Prestasi</h2>
            <p class="text-slate-500">Eksplorasi jejak langkah para juara dari waktu ke waktu. Setiap pencapaian adalah cerita inspiratif.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-12">
            
            <div class="w-full lg:w-1/4">
                <div class="sticky top-28">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-900 mb-5 pl-2">Filter Tahun</h3>
                    <div class="flex flex-col space-y-1.5">
                        <a href="{{ route('home') }}#timeline" class="px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ !request('tahun_ajaran_id') ? 'bg-primary text-white shadow-md shadow-blue-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            Semua Tahun
                        </a>
                        @foreach($tahunAjaran as $ta)
                            <a href="{{ route('home', ['tahun_ajaran_id' => $ta->id]) }}#timeline" class="px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request('tahun_ajaran_id') == $ta->id ? 'bg-primary text-white shadow-md shadow-blue-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                {{ $ta->tahun }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-3/4 relative">
                
                <div class="absolute left-[39px] sm:left-[79px] top-4 bottom-4 w-0.5 bg-slate-200 z-0"></div>

                <div class="space-y-8 relative z-10">
                    @forelse($prestasi as $item)
                    <div class="relative flex items-start group">
                        
                        <div class="flex flex-col items-center sm:items-end w-20 sm:w-24 flex-shrink-0 pt-5 pr-4 sm:pr-8 relative">
                            <div class="absolute right-[15px] sm:right-[-5px] top-6 w-3 h-3 rounded-full bg-primary ring-4 ring-white group-hover:scale-150 transition-transform duration-300"></div>
                            
                            <span class="text-xs font-medium text-slate-400 mb-0.5">{{ $item->tanggal->translatedFormat('M') }}</span>
                            <span class="text-sm font-bold text-slate-700">{{ $item->tanggal->format('Y') }}</span>
                        </div>

                        <div class="flex-1 ml-6 sm:ml-8 bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300">
                            <div class="flex flex-col sm:flex-row gap-5">
                                
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200 flex items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-user text-2xl"></i>
                                </div>

                                <div>
                                    <div class="flex gap-2 mb-2">
                                        <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">{{ $item->kategori->jenis_prestasi }} ({{ $item->kategori->nama_kategori }})</span>
                                        <span class="text-[10px] font-bold text-yellow-700 bg-yellow-100 px-2 py-0.5 rounded-md">{{ $item->tingkat->nama_tingkat }}</span>
                                    </div>
                                    <h4 class="text-lg font-bold text-slate-900 mb-1 leading-tight group-hover:text-primary transition-colors">{{ $item->nama_lomba }}</h4>
                                    <p class="text-sm text-slate-700 font-medium mb-3">{{ $item->siswa->nama }} <span class="text-slate-400 font-normal ml-1">&bull; Kelas {{ $item->siswa->kelas->nama_kelas ?? 'Alumni' }}</span></p>
                                    <p class="text-sm text-slate-500 leading-relaxed">{{ $item->deskripsi }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    @empty
                    <div class="pl-24 py-10">
                        <div class="bg-slate-50 rounded-2xl p-8 text-center border border-slate-200 border-dashed">
                            <i class="fa-regular fa-calendar-xmark text-4xl text-slate-300 mb-3"></i>
                            <h4 class="font-bold text-slate-600">Tidak ada jejak prestasi</h4>
                            <p class="text-sm text-slate-500 mt-1">Belum ada data prestasi pada tahun ajaran ini.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                <div class="mt-12 sm:pl-32 flex flex-col items-start gap-8">
                    @if($prestasi->hasPages())
                        <div class="w-full">{{ $prestasi->links() }}</div>
                    @endif
                    
                    <a href="{{ route('public.prestasi.index') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-slate-900 hover:bg-primary text-white font-bold rounded-xl transition-all shadow-md">
                        Lihat Seluruh Timeline <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>