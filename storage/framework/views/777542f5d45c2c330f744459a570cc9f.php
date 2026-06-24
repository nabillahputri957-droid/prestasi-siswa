<?php $__env->startSection('title', $title . ' - SEKOLAH DASAR NEGERI 31'); ?>

<?php $__env->startSection('content'); ?>

<div class="pt-28 pb-16 bg-slate-50 border-b border-slate-200">
    <div class="container mx-auto px-4 md:px-8 max-w-7xl text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4 flex items-center justify-center gap-3">
            <?php if($isUnggulan): ?>
                <i class="fa-solid fa-star text-yellow-400"></i>
            <?php else: ?>
                <i class="fa-solid fa-medal text-primary"></i>
            <?php endif; ?>
            <?php echo e($title); ?>

        </h1>
        <p class="text-slate-500 max-w-2xl mx-auto">
            Jelajahi seluruh rekam jejak pencapaian siswa kami. Gunakan fitur pencarian untuk menemukan data yang lebih spesifik.
        </p>
    </div>
</div>

<section class="py-12 bg-white min-h-screen">
    <div class="container mx-auto px-4 md:px-8 max-w-7xl">
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-10">
            <form action="<?php echo e($isUnggulan ? route('public.prestasi.unggulan') : route('public.prestasi.index')); ?>" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama lomba atau siswa..." 
                           class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-transparent rounded-xl focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-sm font-medium">
                </div>
                <div class="flex-1">
                    <select name="kategori_id" class="w-full px-4 py-3 bg-slate-50 border border-transparent rounded-xl focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-sm font-medium text-slate-600">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($k->id); ?>" <?php echo e(request('kategori_id') == $k->id ? 'selected' : ''); ?>><?php echo e($k->jenis_prestasi); ?> (<?php echo e($k->nama_kategori); ?>)</option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="flex-1">
                    <select name="tingkat_id" class="w-full px-4 py-3 bg-slate-50 border border-transparent rounded-xl focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-sm font-medium text-slate-600">
                        <option value="">Semua Tingkat</option>
                        <?php $__currentLoopData = $tingkat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($t->id); ?>" <?php echo e(request('tingkat_id') == $t->id ? 'selected' : ''); ?>><?php echo e($t->nama_tingkat); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="flex-1">
                    <select name="juara" class="w-full px-4 py-3 bg-slate-50 border border-transparent rounded-xl focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-sm font-medium text-slate-600">
                        <option value="">Semua Juara</option>
                        <?php $__currentLoopData = $juaraOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($opt); ?>" <?php echo e(request('juara') == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="flex-1">
                    <select name="tahun_ajaran_id" class="w-full px-4 py-3 bg-slate-50 border border-transparent rounded-xl focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-sm font-medium text-slate-600">
                        <option value="">Semua Tahun</option>
                        <?php $__currentLoopData = $tahunAjaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($ta->id); ?>" <?php echo e(request('tahun_ajaran_id') == $ta->id ? 'selected' : ''); ?>><?php echo e($ta->tahun); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit" class="bg-primary hover:bg-blue-600 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-md shadow-blue-500/20 whitespace-nowrap">
                    Cari Data
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php $__empty_1 = true; $__currentLoopData = $prestasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group flex flex-col">
                <div class="h-48 bg-slate-100 relative overflow-hidden">
                    <?php $ext = pathinfo($item->file_bukti, PATHINFO_EXTENSION); ?>
                    <?php if(in_array(strtolower($ext), ['jpg','jpeg','png'])): ?>
                        <img src="<?php echo e(asset('storage/bukti_prestasi/' . $item->file_bukti)); ?>" alt="Bukti" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-blue-50 text-blue-300 group-hover:scale-105 transition-transform duration-500">
                            <i class="fa-solid fa-file-pdf text-5xl"></i>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($item->unggulan): ?>
                        <div class="absolute top-4 right-4 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1">
                            <i class="fa-solid fa-star"></i> Unggulan
                        </div>
                    <?php endif; ?>
                </div>

                <div class="p-6 flex flex-col flex-1">
                    <div class="flex gap-2 mb-3 flex-wrap">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 bg-blue-100 px-2.5 py-1 rounded-md"><?php echo e($item->juara); ?></span>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-primary bg-blue-50 px-2.5 py-1 rounded-md"><?php echo e($item->kategori->jenis_prestasi); ?> (<?php echo e($item->kategori->nama_kategori); ?>)</span>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md"><?php echo e($item->tingkat->nama_tingkat); ?></span>
                    </div>
                    
                    <h3 class="font-bold text-lg text-slate-900 mb-1 leading-tight"><?php echo e($item->nama_lomba); ?></h3>
                    <p class="text-slate-500 text-sm mb-4 line-clamp-2"><?php echo e($item->deskripsi); ?></p>
                    
                    <div class="mt-auto pt-4 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-sm">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-slate-800"><?php echo e($item->siswa->nama); ?></p>
                            <p class="text-xs text-slate-500">Kelas <?php echo e($item->siswa->kelas->nama_kelas ?? 'Alumni'); ?> • <?php echo e($item->tanggal->format('d M Y')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full py-20 text-center bg-slate-50 rounded-2xl border border-slate-200 border-dashed">
                <i class="fa-solid fa-folder-open text-5xl text-slate-300 mb-4 block"></i>
                <h3 class="text-xl font-bold text-slate-700">Tidak Ada Data Ditemukan</h3>
                <p class="text-slate-500 mt-2">Data prestasi yang Anda cari tidak tersedia. Silakan ubah filter pencarian.</p>
                <a href="<?php echo e($isUnggulan ? route('public.prestasi.unggulan') : route('public.prestasi.index')); ?>" class="inline-block mt-6 bg-white border border-slate-200 text-slate-600 px-6 py-2 rounded-lg font-medium hover:bg-slate-50 transition-colors shadow-sm">
                    Reset Filter
                </a>
            </div>
            <?php endif; ?>
        </div>

        <?php if($prestasi->hasPages()): ?>
        <div class="mt-12 flex justify-center">
            <?php echo e($prestasi->links()); ?>

        </div>
        <?php endif; ?>

    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\prestasi-siswa\resources\views/pengunjung/prestasi/index.blade.php ENDPATH**/ ?>