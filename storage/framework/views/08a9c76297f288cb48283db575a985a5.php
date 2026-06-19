<?php $__env->startSection('title', 'Manajemen Prestasi'); ?>
<?php $__env->startSection('header_title', 'Data Prestasi Siswa'); ?>
<?php $__env->startSection('header_subtitle', 'Kelola data prestasi dan pantau status validasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-50 flex justify-between items-center">
        <h3 class="text-gray-800 font-medium">Daftar Prestasi</h3>
        <a href="<?php echo e(route('admin.prestasi.create')); ?>" class="bg-primary hover:bg-blue-200 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
            <i class="fa-solid fa-plus mr-2"></i>Tambah Prestasi
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium">No</th>
                    <th class="px-6 py-4 font-medium">Nama Lomba</th>
                    <th class="px-6 py-4 font-medium">Siswa</th>
                    <th class="px-6 py-4 font-medium text-center">Kategori & Tingkat</th>
                    <th class="px-6 py-4 font-medium text-center">Status</th>
                    <th class="px-6 py-4 font-medium text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php $__empty_1 = true; $__currentLoopData = $prestasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-500"><?php echo e($prestasi->firstItem() + $index); ?></td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800"><?php echo e($item->nama_lomba); ?></p>
                        <p class="text-xs text-blue-600 font-semibold mb-1"><?php echo e($item->juara); ?></p>
                        <?php if($item->unggulan): ?> <span class="text-[10px] bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full font-bold"><i class="fa-solid fa-star text-yellow-500 mr-1"></i>Unggulan</span> <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-gray-600"><?php echo e($item->siswa->nama); ?></td>
                    <td class="px-6 py-4 text-center">
                        <span class="block text-gray-800 font-medium"><?php echo e($item->kategori->jenis_prestasi); ?> (<?php echo e($item->kategori->nama_kategori); ?>)</span>
                        <span class="block text-xs text-gray-500"><?php echo e($item->tingkat->nama_tingkat); ?></span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <?php if($item->status == 'pending'): ?>
                            <span class="bg-yellow-50 text-yellow-600 border border-yellow-200 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                        <?php elseif($item->status == 'disetujui'): ?>
                            <span class="bg-green-50 text-green-600 border border-green-200 px-3 py-1 rounded-full text-xs font-semibold">Disetujui</span>
                        <?php else: ?>
                            <span class="bg-red-50 text-red-600 border border-red-200 px-3 py-1 rounded-full text-xs font-semibold" title="Lihat detail untuk catatan penolakan">Ditolak</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <a href="<?php echo e(route('admin.prestasi.show', $item->id)); ?>" class="text-gray-500 hover:text-gray-800 transition-colors" title="Detail"><i class="fa-regular fa-eye text-lg"></i></a>
                            <a href="<?php echo e(route('admin.prestasi.edit', $item->id)); ?>" class="text-blue-500 hover:text-blue-700 transition-colors" title="Edit"><i class="fa-regular fa-pen-to-square text-lg"></i></a>
                            <form action="<?php echo e(route('admin.prestasi.destroy', $item->id)); ?>" method="POST" class="delete-form inline-block">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="button" class="text-red-500 hover:text-red-700 btn-delete"><i class="fa-regular fa-trash-can text-lg"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data prestasi.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-gray-50"><?php echo e($prestasi->links()); ?></div>
</div>

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({ title: 'Hapus Data?', text: "File bukti juga akan ikut terhapus!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#9ca3af', confirmButtonText: 'Ya, Hapus!'
            }).then((result) => { if (result.isConfirmed) form.submit(); })
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\prestasi-siswa\resources\views/admin/prestasi/index.blade.php ENDPATH**/ ?>