<?php $__env->startSection('title', 'Beranda - Prestasi Siswa & Alumni'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('pengunjung.home.partials.hero', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('pengunjung.home.partials.about', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('pengunjung.home.partials.unggulan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('pengunjung.home.partials.timeline', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('pengunjung.home.partials.features', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('pengunjung.home.partials.cta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\prestasi-siswa\resources\views/pengunjung/home/index.blade.php ENDPATH**/ ?>