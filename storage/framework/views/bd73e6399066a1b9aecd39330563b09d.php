<?php $__env->startSection('title', 'Data Prestasi - Kepala Sekolah'); ?>
<?php $__env->startSection('header_title', 'Data Prestasi'); ?>
<?php $__env->startSection('header_subtitle', 'Lihat seluruh data prestasi (hanya dapat melihat)'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
    <div class="p-5 border-b border-gray-50 bg-white">
        <form action="<?php echo e(route('kepsek.prestasi.index')); ?>" method="GET" class="flex flex-wrap gap-4 items-center w-full">
            
            <div class="relative flex-1 min-w-[250px]">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari lomba, nama siswa, atau NISN..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none transition-all">
            </div>

            <select name="kategori_id" onchange="this.form.submit()" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none min-w-[140px] text-gray-600">
                <option value="">Semua Kategori</option>
                <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k->id); ?>" <?php echo e(request('kategori_id') == $k->id ? 'selected' : ''); ?>><?php echo e($k->jenis_prestasi); ?> (<?php echo e($k->nama_kategori); ?>)</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="tingkat_id" onchange="this.form.submit()" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none min-w-[140px] text-gray-600">
                <option value="">Semua Tingkat</option>
                <?php $__currentLoopData = $tingkat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($t->id); ?>" <?php echo e(request('tingkat_id') == $t->id ? 'selected' : ''); ?>><?php echo e($t->nama_tingkat); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="tahun_ajaran_id" onchange="this.form.submit()" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none min-w-[140px] text-gray-600">
                <option value="">Semua Tahun</option>
                <?php $__currentLoopData = $tahunAjaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ta->id); ?>" <?php echo e(request('tahun_ajaran_id') == $ta->id ? 'selected' : ''); ?>><?php echo e($ta->tahun); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none min-w-[140px] text-gray-600">
                <option value="">Semua Status</option>
                <option value="disetujui" <?php echo e(request('status') == 'disetujui' ? 'selected' : ''); ?>>Disetujui</option>
                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="ditolak" <?php echo e(request('status') == 'ditolak' ? 'selected' : ''); ?>>Ditolak</option>
            </select>

            <button type="submit" class="bg-white border border-gray-200 text-gray-600 px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 flex items-center gap-2">
                <i class="fa-solid fa-filter"></i> Filter
            </button>

            <?php if(request()->anyFilled(['search', 'kategori_id', 'tingkat_id', 'tahun_ajaran_id', 'status'])): ?>
                <a href="<?php echo e(route('kepsek.prestasi.index')); ?>" class="px-3 py-2.5 text-gray-400 hover:text-red-500 transition-colors" title="Reset Filter">
                    <i class="fa-solid fa-rotate-right"></i>
                </a>
            <?php endif; ?>
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
                <?php $__empty_1 = true; $__currentLoopData = $prestasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-400"><?php echo e($prestasi->firstItem() + $index); ?></td>
                    <td class="px-6 py-4 font-bold text-gray-800"><?php echo e($item->nama_lomba); ?></td>
                    <td class="px-6 py-4 text-gray-600"><?php echo e($item->siswa->nama); ?></td>
                    <td class="px-6 py-4 text-gray-600"><?php echo e($item->kategori->jenis_prestasi); ?> (<?php echo e($item->kategori->nama_kategori); ?>)</td>
                    <td class="px-6 py-4 text-gray-600"><?php echo e($item->tingkat->nama_tingkat); ?></td>
                    <td class="px-6 py-4 text-gray-600"><?php echo e($item->tanggal->format('d M Y')); ?></td>
                    <td class="px-6 py-4 text-center text-gray-600"><?php echo e($item->tahunAjaran->tahun); ?></td>
                    <td class="px-6 py-4 text-center">
                        <?php if($item->status == 'pending'): ?>
                            <span class="bg-orange-50 text-orange-600 border border-orange-200 px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider">Pending</span>
                        <?php elseif($item->status == 'disetujui'): ?>
                            <span class="bg-green-50 text-green-600 border border-green-200 px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider">Disetujui</span>
                        <?php else: ?>
                            <span class="bg-red-50 text-red-600 border border-red-200 px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider">Ditolak</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-3xl mb-3 text-gray-300 block"></i>
                        Tidak ada data prestasi yang sesuai dengan filter.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="p-5 border-t border-gray-50 flex justify-between items-center text-sm text-gray-500">
        <div>
            Menampilkan <?php echo e($prestasi->firstItem() ?? 0); ?> - <?php echo e($prestasi->lastItem() ?? 0); ?> dari <?php echo e($prestasi->total()); ?> data
        </div>
        <div>
            <?php echo e($prestasi->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\prestasi-siswa\resources\views/kepsek/prestasi/index.blade.php ENDPATH**/ ?>