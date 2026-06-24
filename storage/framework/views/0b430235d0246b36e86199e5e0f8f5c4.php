<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Sistem Manajemen Data Prestasi'); ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Poppins', sans-serif;
            --color-primary: #3B82F6; /* Biru muda / Blue 500 */
            --color-primary-light: #eff6ff; /* Background aktif menu */
            --color-surface: #f5f9fe; /* Background utama aplikasi */
        }
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-surface text-gray-800 antialiased overflow-hidden">

    <!-- Global Loader -->
    <div id="global-loader" class="fixed inset-0 z-[9999] bg-white bg-opacity-80 backdrop-blur-sm flex-col items-center justify-center hidden">
        <div class="w-12 h-12 border-4 border-gray-200 border-t-primary rounded-full animate-spin"></div>
        <p class="mt-4 text-primary font-medium text-sm">Memuat data...</p>
    </div>

    <!-- Main Wrapper -->
    <div class="flex h-screen w-full relative">
        
        <!-- Overlay Gelap untuk Mobile (Klik untuk menutup) -->
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity"></div>

        <!-- Pemanggilan Sidebar -->
        <?php if(auth()->check() && auth()->user()->role == 'admin'): ?>
            <?php echo $__env->make('layouts.partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif(auth()->check() && auth()->user()->role == 'kepala_sekolah'): ?>
            <?php echo $__env->make('layouts.partials.sidebar-kepsek', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

        <!-- Konten Utama -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Pastikan di file topbar.blade.php kamu menambahkan onclick="toggleSidebar()" pada tombol hamburger -->
            <?php echo $__env->make('layouts.partials.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-surface p-4 md:p-6">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <script>
        // Fungsi Toggle Sidebar Responsive
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar && overlay) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        }

        // Tampilkan loading saat form disubmit
        document.querySelectorAll('form:not(#logout-form-admin):not(#logout-form-kepsek)').forEach(form => {
            form.addEventListener('submit', function() {
                document.getElementById('global-loader').classList.remove('hidden');
                document.getElementById('global-loader').classList.add('flex');
            });
        });

        // SweetAlert Global Notifications
        <?php if(session('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?php echo e(session('success')); ?>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        <?php endif; ?>

        <?php if(session('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?php echo e(session('error')); ?>',
                confirmButtonColor: '#3b82f6'
            });
        <?php endif; ?>
    </script>
</body>
</html><?php /**PATH D:\prestasi-siswa\resources\views/layouts/app.blade.php ENDPATH**/ ?>