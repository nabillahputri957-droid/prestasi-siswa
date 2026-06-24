<?php $__env->startSection('title', 'Manajemen Tahun Ajaran'); ?>
<?php $__env->startSection('header_title', 'Manajemen Tahun Ajaran'); ?>
<?php $__env->startSection('header_subtitle', 'Kelola data tahun ajaran sekolah'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-50 flex justify-between items-center">
        <h3 class="text-gray-800 font-medium">Daftar Tahun Ajaran</h3>
        <a href="<?php echo e(route('admin.tahun-ajaran.create')); ?>" class="bg-blue-200 hover:bg-blue-300 text-gray px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Tahun Ajaran
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium w-16">No</th>
                    <th class="px-6 py-4 font-medium">Tahun Ajaran</th>
                    <th class="px-6 py-4 font-medium text-center">Status</th>
                    <th class="px-6 py-4 font-medium text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php $__empty_1 = true; $__currentLoopData = $tahunAjaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-500"><?php echo e($tahunAjaran->firstItem() + $index); ?></td>
                    <td class="px-6 py-4 font-medium text-gray-800"><?php echo e($ta->tahun); ?></td>
                    <td class="px-6 py-4 text-center">
                        <?php if($ta->status == 'aktif'): ?>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold"><i class="fa-solid fa-check mr-1"></i> Aktif</span>
                        <?php else: ?>
                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <?php if($ta->status == 'nonaktif'): ?>
                            <form action="<?php echo e(route('admin.tahun-ajaran.set-aktif', $ta->id)); ?>" method="POST" class="inline-block">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-green-500 hover:text-green-700 transition-colors text-xs font-medium bg-green-50 px-2 py-1 rounded border border-green-100" title="Set sebagai Tahun Ajaran Aktif">
                                    Set Aktif
                                </button>
                            </form>
                            <?php endif; ?>

                            <a href="<?php echo e(route('admin.tahun-ajaran.edit', $ta->id)); ?>" class="text-blue-500 hover:text-blue-700 transition-colors" title="Edit">
                                <i class="fa-regular fa-pen-to-square text-lg"></i>
                            </a>

                            <form action="<?php echo e(route('admin.tahun-ajaran.destroy', $ta->id)); ?>" method="POST" class="delete-form inline-block">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="button" class="text-red-500 hover:text-red-700 transition-colors btn-delete" title="Hapus">
                                    <i class="fa-regular fa-trash-can text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data tahun ajaran.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="p-5 border-t border-gray-50">
        <?php echo e($tahunAjaran->links()); ?>

    </div>
</div>

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: 'Hapus Tahun Ajaran?',
                text: "Data ini tidak bisa dihapus jika sedang terhubung dengan data siswa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('global-loader').classList.remove('hidden');
                    document.getElementById('global-loader').classList.add('flex');
                    form.submit();
                }
            })
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\prestasi-siswa\resources\views/admin/tahun_ajaran/index.blade.php ENDPATH**/ ?>