@php
    $pengaturan = \App\Models\Pengaturan::first();
@endphp

<!-- ========== HERO SECTION ========== -->
<section class="relative overflow-hidden bg-white pt-24 pb-20 md:pt-32 md:pb-28">
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] z-0"></div>

    <div class="container relative z-10 mx-auto px-4 md:px-8 max-w-7xl">
        <div class="grid gap-12 lg:grid-cols-2 lg:gap-8 items-center">
            
            <div class="flex flex-col justify-center space-y-8">
                <div class="space-y-4">
                    <span class="inline-flex w-fit items-center rounded-full border border-blue-200 bg-blue-50 text-blue-700 px-4 py-1.5 text-xs font-bold tracking-widest shadow-sm uppercase">
                        <i class="fa-solid fa-school mr-2"></i> {{ $pengaturan->nama_sekolah ?? 'SMP NEGERI 1 EXAMPLE' }}
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight text-slate-900 leading-[1.15]">
                        Bangga dengan <br />
                        <span class="text-primary">Prestasi Siswa</span>
                    </h1>
                    <p class="text-lg text-slate-600 max-w-[600px] leading-relaxed">
                        Jejak prestasi, bukti nyata. Bersama, kita ciptakan generasi berprestasi dan membanggakan untuk masa depan yang lebih cerah.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <div class="rounded-2xl border border-slate-100 bg-white/70 backdrop-blur-md shadow-lg shadow-slate-200/40 hover:-translate-y-1 transition-transform">
                        <div class="p-6 flex items-center gap-5">
                            <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100">
                                <i class="fa-solid fa-trophy text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-3xl font-black text-slate-900">{{ number_format($totalPrestasi ?? 0, 0, ',', '.') }}</p>
                                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Total Prestasi</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="rounded-2xl border border-slate-100 bg-white/70 backdrop-blur-md shadow-lg shadow-slate-200/40 hover:-translate-y-1 transition-transform">
                        <div class="p-6 flex items-center gap-5">
                            <div class="w-14 h-14 rounded-full bg-green-50 flex items-center justify-center text-green-600 border border-green-100">
                                <i class="fa-solid fa-user-graduate text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-3xl font-black text-slate-900">{{ number_format($totalSiswa ?? 0, 0, ',', '.') }}</p>
                                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Siswa &amp; Alumni</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative lg:ml-auto w-full max-w-[600px] mx-auto mt-8 lg:mt-0">
                <div class="absolute -inset-4 bg-gradient-to-tr from-blue-100 to-white rounded-3xl blur-2xl opacity-70"></div>
                <div class="relative aspect-[4/3] sm:aspect-[16/9] lg:aspect-square overflow-hidden rounded-3xl shadow-2xl ring-1 ring-slate-900/5 bg-slate-100 flex items-center justify-center group">
                    
                    <!-- Pengecekan Gambar Dinamis via Symlink -->
                    @if($pengaturan && $pengaturan->hero_image)
                        <img src="{{ asset('storage/pengaturan/' . $pengaturan->hero_image) }}" alt="Hero Image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    @else
                        <div class="text-center text-slate-400 group-hover:scale-105 transition-transform duration-700">
                            <i class="fa-solid fa-image text-6xl mb-3"></i>
                            <p class="font-medium">Gambar Hero Anda</p>
                        </div>
                    @endif

                </div>
                <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-yellow-300 rounded-full mix-blend-multiply filter blur-2xl opacity-60 animate-floatY"></div>
                <div class="absolute -top-8 -right-8 w-40 h-40 bg-blue-300 rounded-full mix-blend-multiply filter blur-2xl opacity-60 animate-floatYRev"></div>
            </div>
        </div>
    </div>
</section>