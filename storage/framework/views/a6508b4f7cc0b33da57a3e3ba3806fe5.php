<?php $__env->startSection('title', 'Notifikasi - Kepala Sekolah'); ?>
<?php $__env->startSection('header_title', 'Notifikasi'); ?>
<?php $__env->startSection('header_subtitle', 'Pemberitahuan data masuk dan pembaruan sistem'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-white sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <h3 class="text-gray-800 font-bold">Pemberitahuan</h3>
            <?php $unreadCount = auth()->user()->unreadNotifications->count(); ?>
            <?php if($unreadCount > 0): ?>
                <span class="bg-orange-100 text-orange-600 py-0.5 px-3 rounded-full text-[10px] font-black uppercase tracking-wider"><?php echo e($unreadCount); ?> Baru</span>
            <?php endif; ?>
        </div>
        
        <?php if($unreadCount > 0): ?>
        <form action="<?php echo e(route('kepsek.notifikasi.read-all')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="text-xs font-bold text-primary hover:text-blue-700 transition-colors uppercase tracking-widest">
                Tandai Semua Dibaca
            </button>
        </form>
        <?php endif; ?>
    </div>

    <div class="divide-y divide-gray-50">
        <?php $__empty_1 = true; $__currentLoopData = $notifikasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php 
                $isUnread = is_null($notif->read_at); 
                $data = $notif->data;
            ?>
            <div class="p-6 flex gap-5 transition-all <?php echo e($isUnread ? 'bg-blue-50/20' : 'opacity-70 hover:opacity-100 hover:bg-gray-50'); ?>">
                <div class="w-12 h-12 rounded-2xl flex-shrink-0 flex items-center justify-center <?php echo e($data['warna'] ?? 'bg-blue-50 text-blue-500'); ?> shadow-sm">
                    <i class="<?php echo e($data['icon'] ?? 'fa-solid fa-bell'); ?> text-xl"></i>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start">
                        <h4 class="text-sm font-bold <?php echo e($isUnread ? 'text-gray-900' : 'text-gray-600'); ?> truncate pr-4">
                            <?php echo e($data['judul'] ?? 'Pemberitahuan Baru'); ?>

                        </h4>
                        <span class="text-[10px] font-medium text-gray-400 whitespace-nowrap uppercase tracking-tighter">
                            <?php echo e($notif->created_at->diffForHumans()); ?>

                        </span>
                    </div>
                    <p class="text-sm mt-1 <?php echo e($isUnread ? 'text-gray-700' : 'text-gray-500'); ?> leading-relaxed">
                        <?php echo e($data['pesan'] ?? 'Ada informasi terbaru untuk Anda tinjau.'); ?>

                    </p>

                    <div class="mt-4 flex gap-4">
                        <?php if($isUnread): ?>
                            <form action="<?php echo e(route('kepsek.notifikasi.read', $notif->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline">Baca Sekarang</button>
                            </form>
                        <?php endif; ?>
                        
                        <?php if(isset($data['url'])): ?>
                            <a href="<?php echo e($data['url']); ?>" class="text-[10px] font-black text-gray-400 hover:text-gray-800 uppercase tracking-widest underline decoration-gray-200">Lihat Detail</a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="flex-shrink-0">
                    <form action="<?php echo e(route('kepsek.notifikasi.destroy', $notif->id)); ?>" method="POST" class="form-delete">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="button" class="btn-delete text-gray-300 hover:text-red-500 transition-colors">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="p-20 text-center flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-gray-50 text-gray-200 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-bell-slash text-2xl"></i>
                </div>
                <p class="text-gray-400 text-sm font-medium">Kotak masuk kosong. Tidak ada pemberitahuan baru.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="p-6 bg-gray-50/50 border-t border-gray-50">
        <?php echo e($notifikasis->links()); ?>

    </div>
</div>

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            Swal.fire({
                title: 'Hapus Notifikasi?',
                text: "Riwayat pemberitahuan ini akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) this.closest('form').submit();
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\prestasi-siswa\resources\views/kepsek/notifikasi/index.blade.php ENDPATH**/ ?>