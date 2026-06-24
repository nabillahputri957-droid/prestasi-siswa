<?php $__env->startSection('title', 'Validasi Status Data'); ?>
<?php $__env->startSection('header_title', 'Validasi Status Data'); ?>
<?php $__env->startSection('header_subtitle', 'Pantau dan kelola status data prestasi secara komprehensif'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
    <div class="border-b border-gray-100 flex overflow-x-auto hide-scrollbar">
        <a href="<?php echo e(route('admin.validasi.index', array_merge(request()->query(), ['status' => 'semua']))); ?>" 
           class="px-6 py-4 text-sm font-semibold whitespace-nowrap transition-colors flex items-center gap-2 border-b-2 <?php echo e($currentStatus == 'semua' ? 'border-blue-400 text-blue-400' : 'border-transparent text-gray-500 hover:text-blue-500'); ?>">
           Semua <span class="bg-blue-50 text-blue-600 py-0.5 px-2 rounded-full text-xs"><?php echo e($counts['semua']); ?></span>
        </a>
        
        <a href="<?php echo e(route('admin.validasi.index', array_merge(request()->query(), ['status' => 'pending']))); ?>" 
           class="px-6 py-4 text-sm font-semibold whitespace-nowrap transition-colors flex items-center gap-2 border-b-2 <?php echo e($currentStatus == 'pending' ? 'border-orange-500 text-orange-500' : 'border-transparent text-gray-500 hover:text-orange-500'); ?>">
           Pending <span class="bg-orange-50 text-orange-600 py-0.5 px-2 rounded-full text-xs"><?php echo e($counts['pending']); ?></span>
        </a>

        <a href="<?php echo e(route('admin.validasi.index', array_merge(request()->query(), ['status' => 'disetujui']))); ?>" 
           class="px-6 py-4 text-sm font-semibold whitespace-nowrap transition-colors flex items-center gap-2 border-b-2 <?php echo e($currentStatus == 'disetujui' ? 'border-green-500 text-green-500' : 'border-transparent text-gray-500 hover:text-green-500'); ?>">
           Disetujui <span class="bg-green-50 text-green-600 py-0.5 px-2 rounded-full text-xs"><?php echo e($counts['disetujui']); ?></span>
        </a>

        <a href="<?php echo e(route('admin.validasi.index', array_merge(request()->query(), ['status' => 'ditolak']))); ?>" 
           class="px-6 py-4 text-sm font-semibold whitespace-nowrap transition-colors flex items-center gap-2 border-b-2 <?php echo e($currentStatus == 'ditolak' ? 'border-red-500 text-red-500' : 'border-transparent text-gray-500 hover:text-red-500'); ?>">
           Ditolak <span class="bg-red-50 text-red-600 py-0.5 px-2 rounded-full text-xs"><?php echo e($counts['ditolak']); ?></span>
        </a>
    </div>

    <div class="p-5 border-b border-gray-50 bg-gray-50/30">
        <form action="<?php echo e(route('admin.validasi.index')); ?>" method="GET" class="flex flex-wrap gap-4 items-center">
            <input type="hidden" name="status" value="<?php echo e($currentStatus); ?>">

            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama lomba atau siswa..." 
                       class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
            </div>

            <select name="kategori_id" onchange="this.form.submit()" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none min-w-[150px] cursor-pointer text-gray-600">
                <option value="">Semua Kategori</option>
                <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k->id); ?>" <?php echo e(request('kategori_id') == $k->id ? 'selected' : ''); ?>><?php echo e($k->jenis_prestasi); ?> (<?php echo e($k->nama_kategori); ?>)</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="tingkat_id" onchange="this.form.submit()" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none min-w-[150px] cursor-pointer text-gray-600">
                <option value="">Semua Tingkat</option>
                <?php $__currentLoopData = $tingkat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($t->id); ?>" <?php echo e(request('tingkat_id') == $t->id ? 'selected' : ''); ?>><?php echo e($t->nama_tingkat); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="tahun_ajaran_id" onchange="this.form.submit()" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none min-w-[150px] cursor-pointer text-gray-600">
                <option value="">Semua Tahun</option>
                <?php $__currentLoopData = $tahunAjaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ta->id); ?>" <?php echo e(request('tahun_ajaran_id') == $ta->id ? 'selected' : ''); ?>><?php echo e($ta->tahun); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <?php if(request('search') || request('kategori_id') || request('tingkat_id') || request('tahun_ajaran_id')): ?>
                <a href="<?php echo e(route('admin.validasi.index', ['status' => $currentStatus])); ?>" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition-colors" title="Reset Filter">
                    <i class="fa-solid fa-rotate-right"></i>
                </a>
            <?php endif; ?>
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
                <?php $__empty_1 = true; $__currentLoopData = $prestasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50 transition-colors <?php echo e($item->status == 'ditolak' ? 'bg-red-50/20' : ''); ?>">
                    <td class="px-6 py-4 text-gray-500"><?php echo e($prestasi->firstItem() + $index); ?></td>
                    <td class="px-6 py-4 font-medium text-gray-800"><?php echo e($item->nama_lomba); ?></td>
                    <td class="px-6 py-4 text-gray-600"><?php echo e($item->siswa->nama); ?></td>
                    <td class="px-6 py-4 text-center text-gray-600"><?php echo e($item->kategori->jenis_prestasi); ?> (<?php echo e($item->kategori->nama_kategori); ?>)</td>
                    <td class="px-6 py-4 text-center text-gray-600"><?php echo e($item->tingkat->nama_tingkat); ?></td>
                    <td class="px-6 py-4 text-center text-gray-600"><?php echo e($item->tanggal->format('d M Y')); ?></td>
                    <td class="px-6 py-4 text-center">
                        <?php if($item->status == 'pending'): ?>
                            <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded text-xs font-semibold">Pending</span>
                        <?php elseif($item->status == 'disetujui'): ?>
                            <span class="bg-green-100 text-green-600 px-3 py-1 rounded text-xs font-semibold">Disetujui</span>
                        <?php else: ?>
                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded text-xs font-semibold">Ditolak</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <a href="<?php echo e(route('admin.prestasi.show', $item->id)); ?>" class="text-gray-400 hover:text-gray-800 transition-colors" title="Lihat Detail"><i class="fa-regular fa-eye text-lg"></i></a>
                            
                            <a href="<?php echo e(route('admin.prestasi.edit', $item->id)); ?>" class="<?php echo e($item->status == 'ditolak' ? 'text-red-500 hover:text-red-700' : 'text-gray-400 hover:text-blue-500'); ?> transition-colors" title="Edit Data">
                                <i class="fa-regular fa-pen-to-square text-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-3xl mb-3 text-gray-300 block"></i>
                        Data prestasi tidak ditemukan.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="p-5 border-t border-gray-50">
        <?php echo e($prestasi->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\prestasi-siswa\resources\views/admin/validasi/index.blade.php ENDPATH**/ ?>