<section id="unggulan" class="py-20 bg-slate-50 border-t border-slate-100">
    <div class="container mx-auto px-4 md:px-8 max-w-7xl">
        
        <div class="text-center max-w-2xl mx-auto mb-14">
            <h2 class="text-3xl font-bold text-slate-900 mb-4">Prestasi Unggulan</h2>
            <p class="text-slate-500">Pencapaian tertinggi yang membawa harum nama sekolah di tingkat regional maupun nasional.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @forelse($unggulans as $index => $item)
            @php
                // Variasi warna border bawah untuk estetika
                $colors = ['border-blue-500', 'border-pink-500', 'border-purple-500', 'border-green-500', 'border-rose-500'];
                $borderColor = $colors[$index % count($colors)];
            @endphp
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden group hover:shadow-xl transition-all duration-300 relative flex flex-col">
                
                <div class="h-48 bg-slate-50 p-6 relative flex items-center justify-center border-b-[3px] {{ $borderColor }}">
                    @php $ext = pathinfo($item->file_bukti, PATHINFO_EXTENSION); @endphp
                    @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/bukti_prestasi/' . $item->file_bukti) }}" alt="Trophy" class="w-full h-full object-contain drop-shadow-md group-hover:scale-110 transition-transform duration-500">
                    @else
                        <i class="fa-solid fa-trophy text-6xl text-yellow-400 drop-shadow-md group-hover:scale-110 transition-transform duration-500"></i>
                    @endif

                    <div class="absolute top-3 right-3 bg-yellow-400 text-yellow-900 text-[10px] font-bold px-2.5 py-1 rounded-md shadow-sm flex items-center gap-1.5 z-10">
                        <i class="fa-solid fa-trophy"></i> Juara
                    </div>
                </div>

                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-[10px] font-medium text-slate-500">{{ $item->kategori->jenis_prestasi }} ({{ $item->kategori->nama_kategori }})</span>
                        <span class="text-[10px] font-medium text-slate-400">{{ $item->tanggal->format('M Y') }}</span>
                    </div>
                    <h4 class="text-sm font-bold text-slate-900 mb-2 leading-snug line-clamp-2 group-hover:text-primary transition-colors">{{ $item->nama_lomba }}</h4>
                    <p class="text-xs text-slate-500 mt-auto pt-2">{{ $item->siswa->nama }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full py-10 text-center text-slate-500 italic">Belum ada data prestasi unggulan.</div>
            @endforelse
        </div>

        @if($unggulans->count() > 0)
        <div class="mt-12 text-center">
            <a href="{{ route('public.prestasi.unggulan') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-white border border-slate-200 hover:border-primary hover:text-primary text-slate-600 font-bold rounded-xl transition-all shadow-sm">
                Lihat Semua Unggulan <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        @endif

    </div>
</section>