<?php
    // Memanggil data pengaturan baris pertama langsung dari database
    $pengaturan = \App\Models\Pengaturan::first();
?>

<nav class="fixed top-0 z-50 w-full border-b border-slate-200/60 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/70">
    <div class="container mx-auto px-4 md:px-8 h-16 flex items-center justify-between max-w-7xl relative z-20 bg-transparent">
        
        <!-- Area Logo dan Nama Sekolah Dinamis -->
        <div class="flex gap-3 items-center">
            <?php if($pengaturan && $pengaturan->logo): ?>
                <!-- Memanggil gambar via symlink public_html/storage -->
                <img src="<?php echo e(asset('storage/pengaturan/' . $pengaturan->logo)); ?>" alt="Logo Sekolah" class="w-9 h-9 rounded-full object-cover shadow-sm border border-slate-100 bg-white">
            <?php else: ?>
                <!-- Fallback jika belum upload logo -->
                <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-white shadow-sm">
                    <i class="fa-solid fa-school text-sm"></i>
                </div>
            <?php endif; ?>
            
            <!-- Ditampilkan di semua layar, namun di HP dibatasi lebarnya agar tidak nabrak -->
            <a href="<?php echo e(route('home')); ?>" class="font-bold text-lg text-slate-900 tracking-tight truncate max-w-[150px] sm:max-w-[200px] lg:max-w-[300px]">
                <?php echo e($pengaturan->nama_sekolah ?? 'Prestasi Sekolah'); ?>

            </a>
        </div>
        
        <!-- Menu Tengah (Hanya tampil di Desktop/Tablet besar) -->
        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-500">
            <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'text-primary' : 'transition-colors hover:text-primary'); ?>">Beranda</a>
            <a href="<?php echo e(route('public.prestasi.index')); ?>" class="<?php echo e(request()->routeIs('public.prestasi.index') ? 'text-primary' : 'transition-colors hover:text-primary'); ?>">Prestasi</a>
            <a href="<?php echo e(route('public.prestasi.unggulan')); ?>" class="<?php echo e(request()->routeIs('public.prestasi.unggulan') ? 'text-primary' : 'transition-colors hover:text-primary'); ?>">Unggulan</a>
            <a href="<?php echo e(route('home')); ?>#profil" class="transition-colors hover:text-primary">Profil</a>
        </div>
        
        <!-- Area Kanan (Pencarian & Login Desktop + Tombol Toggle Mobile) -->
        <div class="flex items-center gap-3 sm:gap-4">
            <!-- Search Bar Desktop -->
            <div class="relative hidden sm:block w-40 lg:w-64">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="search" placeholder="Cari prestasi..." class="w-full bg-slate-100/80 rounded-full pl-9 pr-4 h-9 text-sm border border-transparent focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition" />
            </div>

            <!-- Tombol Login Desktop -->
            <a href="<?php echo e(route('login')); ?>" class="hidden md:flex items-center justify-center w-9 h-9 rounded-full bg-slate-100 text-slate-600 hover:text-primary hover:bg-blue-50 transition-colors" title="Login Sistem">
                <i class="fa-solid fa-user"></i>
            </a>

            <!-- Tombol Hamburger Mobile -->
            <button id="mobile-menu-button" class="md:hidden w-9 h-9 inline-flex items-center justify-center rounded-md hover:bg-slate-100 text-slate-700 transition" aria-label="Menu">
                <i class="fa-solid fa-bars text-lg transition-transform duration-300"></i>
            </button>
        </div>
    </div>

    <!-- Area Menu Mobile (Tersembunyi secara default, akan turun saat tombol diklik) -->
    <div id="mobile-menu" class="hidden md:hidden absolute top-16 left-0 w-full bg-white border-b border-slate-200 shadow-xl z-10 origin-top transform transition-all duration-300">
        <div class="px-4 pt-4 pb-6 space-y-5">
            
            <!-- Search Bar Mobile -->
            <div class="relative w-full sm:hidden">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="search" placeholder="Cari prestasi..." class="w-full bg-slate-50 rounded-full pl-10 pr-4 py-3 text-sm border border-slate-200 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition" />
            </div>

            <!-- Link Menu Mobile -->
            <div class="flex flex-col space-y-2">
                <a href="<?php echo e(route('home')); ?>" class="block px-4 py-3 rounded-xl text-base font-medium <?php echo e(request()->routeIs('home') ? 'text-primary bg-blue-50' : 'text-slate-600 hover:text-primary hover:bg-slate-50'); ?>">
                    <i class="fa-solid fa-house w-6 text-center mr-2"></i> Beranda
                </a>
                <a href="<?php echo e(route('public.prestasi.index')); ?>" class="block px-4 py-3 rounded-xl text-base font-medium <?php echo e(request()->routeIs('public.prestasi.index') ? 'text-primary bg-blue-50' : 'text-slate-600 hover:text-primary hover:bg-slate-50'); ?>">
                    <i class="fa-solid fa-medal w-6 text-center mr-2"></i> Prestasi Reguler
                </a>
                <a href="<?php echo e(route('public.prestasi.unggulan')); ?>" class="block px-4 py-3 rounded-xl text-base font-medium <?php echo e(request()->routeIs('public.prestasi.unggulan') ? 'text-primary bg-blue-50' : 'text-slate-600 hover:text-primary hover:bg-slate-50'); ?>">
                    <i class="fa-solid fa-star w-6 text-center mr-2 text-yellow-500"></i> Prestasi Unggulan
                </a>
                <a href="<?php echo e(route('home')); ?>#profil" class="block px-4 py-3 rounded-xl text-base font-medium text-slate-600 hover:text-primary hover:bg-slate-50">
                    <i class="fa-solid fa-building w-6 text-center mr-2"></i> Profil Sekolah
                </a>
            </div>

            <!-- Tombol Login Mobile -->
            <div class="pt-2 border-t border-slate-100">
                <a href="<?php echo e(route('login')); ?>" class="flex items-center justify-center w-full gap-2 px-4 py-3.5 rounded-xl bg-primary text-white font-medium hover:bg-blue-600 transition-colors shadow-sm">
                    <i class="fa-solid fa-right-to-bracket"></i> Login ke Sistem
                </a>
            </div>

        </div>
    </div>
</nav>

<!-- Script untuk Toggle Mobile Menu -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const icon = mobileMenuButton.querySelector('i');

        mobileMenuButton.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
            
            if (mobileMenu.classList.contains('hidden')) {
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            } else {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            }
        });
    });
</script><?php /**PATH D:\prestasi-siswa\resources\views/layouts/partials/navbar.blade.php ENDPATH**/ ?>