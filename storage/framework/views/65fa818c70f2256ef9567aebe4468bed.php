<?php $__env->startSection('title', 'Notifikasi Sistem'); ?>
<?php $__env->startSection('header_title', 'Notifikasi'); ?>
<?php $__env->startSection('header_subtitle', 'Informasi dan pengingat sistem terbaru'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
    
    <div class="p-5 border-b border-gray-50 flex justify-between items-center bg-white sticky top-0 z-10">
        <div class="flex gap-4">
            <h3 class="text-gray-800 font-medium">Semua Notifikasi</h3>
            <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
                <span class="bg-red-100 text-red-600 py-0.5 px-2.5 rounded-full text-xs font-bold"><?php echo e(auth()->user()->unreadNotifications->count()); ?> Baru</span>
            <?php endif; ?>
        </div>
        
        <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
        <form action="<?php echo e(route('admin.notifikasi.read-all')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="text-sm text-primary hover:text-blue-700 font-medium transition-colors">
                <i class="fa-solid fa-check-double mr-1"></i> Tandai Semua Dibaca
            </button>
        </form>
        <?php endif; ?>
    </div>

    <div class="divide-y divide-gray-50">
        <?php $__empty_1 = true; $__currentLoopData = $notifikasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php 
                $isUnread = is_null($notif->read_at); 
                // Default fallback jika data belum diset dari Kepsek nanti
                $warna = $notif->data['warna'] ?? 'text-blue-500 bg-blue-50';
                $icon = $notif->data['icon'] ?? 'fa-solid fa-bell';
                $judul = $notif->data['judul'] ?? 'Notifikasi Baru';
                $pesan = $notif->data['pesan'] ?? 'Anda memiliki pembaruan sistem.';
            ?>

            <div class="p-5 flex gap-4 transition-colors <?php echo e($isUnread ? 'bg-blue-50/30' : 'hover:bg-gray-50'); ?>">
                
                <div class="w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center <?php echo e($warna); ?> shadow-sm">
                    <i class="<?php echo e($icon); ?> text-lg"></i>
                </div>
                
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="text-sm font-bold <?php echo e($isUnread ? 'text-gray-900' : 'text-gray-700'); ?>"><?php echo e($judul); ?></h4>
                        <span class="text-[11px] text-gray-400 whitespace-nowrap"><i class="fa-regular fa-clock mr-1"></i><?php echo e($notif->created_at->diffForHumans()); ?></span>
                    </div>
                    <p class="text-sm <?php echo e($isUnread ? 'text-gray-700' : 'text-gray-500'); ?> leading-relaxed"><?php echo e($pesan); ?></p>
                    
                    <div class="mt-3 flex gap-3">
                        <?php if($isUnread): ?>
                            <form action="<?php echo e(route('admin.notifikasi.read', $notif->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-xs font-medium text-primary hover:underline">Tandai Dibaca</button>
                            </form>
                        <?php endif; ?>

                        <?php if(isset($notif->data['url'])): ?>
                            <a href="<?php echo e($notif->data['url']); ?>" class="text-xs font-medium text-gray-500 hover:text-gray-800 underline">Lihat Detail</a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="pl-2">
                    <form action="<?php echo e(route('admin.notifikasi.destroy', $notif->id)); ?>" method="POST" class="delete-form">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="button" class="text-gray-300 hover:text-red-500 transition-colors btn-delete" title="Hapus Notifikasi">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="p-12 text-center flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-regular fa-bell-slash text-3xl text-gray-300"></i>
                </div>
                <h4 class="text-gray-800 font-medium mb-1">Belum ada notifikasi</h4>
                <p class="text-sm text-gray-500">Anda akan melihat pembaruan sistem di sini.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if($notifikasis->hasPages()): ?>
    <div class="p-5 border-t border-gray-50 bg-gray-50">
        <?php echo e($notifikasis->links()); ?>

    </div>
    <?php endif; ?>
</div>

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            Swal.fire({
                title: 'Hapus Notifikasi?',
                text: "Notifikasi ini akan dihapus dari riwayat Anda.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) this.closest('form').submit();
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\prestasi-siswa\resources\views/admin/notifikasi/index.blade.php ENDPATH**/ ?>