<!-- Sidebar Kepala Sekolah -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-blue-200 shadow-sm flex flex-col h-full border-r border-gray-100 transform -translate-x-full lg:relative lg:translate-x-0 transition-transform duration-300 ease-in-out">
    
    <div class="h-16 flex items-center justify-between px-6 border-b border-gray-50">
        <div class="flex items-center gap-3 text-primary">
            <i class="fa-solid fa-medal text-2xl"></i>
            <div>
                <h1 class="font-bold text-sm leading-tight text-gray-800">Prestasi</h1>
                <p class="text-[10px] text-gray-500">Siswa & Alumni</p>
            </div>
        </div>
        <!-- Tombol Tutup Sidebar Khusus Mobile -->
        <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-red-500">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <div class="p-4 mx-4 mt-4 bg-gray-50 rounded-lg flex items-center gap-3">
        <img src="https://ui-avatars.com/api/?name=Kepala+Sekolah&background=eff6ff&color=3b82f6" alt="User Avatar" class="w-10 h-10 rounded-full">
        <div class="overflow-hidden">
            <p class="text-sm font-semibold text-gray-800 truncate">Kepala Sekolah</p>
            <p class="text-xs text-gray-500 truncate">Validator Utama</p>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto mt-4 px-4 pb-4 space-y-1">
        <a href="<?php echo e(route('kepsek.dashboard')); ?>" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                  <?php echo e(request()->routeIs('kepsek.dashboard') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary'); ?>">
            <i class="fa-solid fa-house w-5 text-center"></i> Dashboard
        </a>

        <?php $pendingCount = \App\Models\Prestasi::where('status', 'pending')->count(); ?>
        
        <a href="<?php echo e(route('kepsek.verifikasi.index')); ?>" 
           class="flex justify-between items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                  <?php echo e(request()->routeIs('kepsek.verifikasi.*') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary'); ?>">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-clipboard-check w-5 text-center"></i> Verifikasi Data
            </div>
            <?php if($pendingCount > 0): ?>
                <span class="bg-orange-100 text-orange-600 py-0.5 px-2 rounded-full text-[10px] font-bold"><?php echo e($pendingCount); ?></span>
            <?php endif; ?>
        </a>

       <a href="<?php echo e(route('kepsek.prestasi.index')); ?>" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                  <?php echo e(request()->routeIs('kepsek.prestasi.*') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary'); ?>">
            <i class="fa-solid fa-trophy w-5 text-center"></i> Data Prestasi
        </a>

    

        <div class="pt-4 mt-4 border-t border-gray-100 space-y-1">
            <?php $unreadCountKepsek = auth()->user()->unreadNotifications->count(); ?>
            <a href="<?php echo e(route('kepsek.notifikasi.index')); ?>" 
               class="flex justify-between items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      <?php echo e(request()->routeIs('kepsek.notifikasi.*') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary'); ?>">
                <div class="flex items-center gap-3">
                    <i class="fa-regular fa-bell w-5 text-center"></i> Notifikasi
                </div>
                <?php if($unreadCountKepsek > 0): ?>
                    <span class="bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-[10px] font-bold"><?php echo e($unreadCountKepsek); ?></span>
                <?php endif; ?>
            </a>
            
            <form id="logout-form-kepsek" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden"><?php echo csrf_field(); ?></form>
            <button onclick="event.preventDefault(); document.getElementById('logout-form-kepsek').submit();" class="w-full flex items-center gap-3 px-3 py-2.5 text-red-600 hover:bg-red-50 rounded-lg text-sm font-medium transition-colors mt-2">
                <i class="fa-solid fa-sign-out-alt w-5 text-center"></i> Keluar
            </button>
        </div>
    </nav>
</aside><?php /**PATH D:\prestasi-siswa\resources\views/layouts/partials/sidebar-kepsek.blade.php ENDPATH**/ ?>