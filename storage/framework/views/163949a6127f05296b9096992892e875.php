<?php
    $pengaturan = \App\Models\Pengaturan::first();
?>

<footer class="bg-[#0b1120] text-slate-300 pt-16 pb-8 border-t border-slate-800">
    <div class="container mx-auto px-4 md:px-8 max-w-7xl">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8 mb-16">
            
            <div class="lg:col-span-4 space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-primary/20">
                        <?php if($pengaturan && $pengaturan->logo): ?>
                            <img src="<?php echo e(asset('storage/pengaturan/' . $pengaturan->logo)); ?>" alt="Logo" class="w-full h-full rounded-full object-cover">
                        <?php else: ?>
                            S1
                        <?php endif; ?>
                    </div>
                    <span class="text-xl font-bold text-white tracking-tight">SIP Prestasi</span>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed pr-4">
                    Sistem Informasi Prestasi Siswa & Alumni <?php echo e($pengaturan->nama_sekolah ?? 'SMP Negeri 1 Example'); ?>. Mendokumentasikan kebanggaan, menginspirasi generasi masa depan.
                </p>
            </div>

            <div class="lg:col-span-2">
                <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm">Navigasi</h4>
                <ul class="space-y-3 text-sm font-medium">
                    <li><a href="<?php echo e(route('home')); ?>" class="text-slate-400 hover:text-primary transition-colors flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Beranda</a></li>
                    <li><a href="<?php echo e(route('home')); ?>#timeline" class="text-slate-400 hover:text-primary transition-colors flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Timeline Prestasi</a></li>
                    <li><a href="<?php echo e(route('public.prestasi.unggulan')); ?>" class="text-slate-400 hover:text-primary transition-colors flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Prestasi Unggulan</a></li>
                    <li><a href="<?php echo e(route('home')); ?>#profil" class="text-slate-400 hover:text-primary transition-colors flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Profil Sekolah</a></li>
                </ul>
            </div>

            <div class="lg:col-span-2">
                <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm">Informasi</h4>
                <ul class="space-y-3 text-sm font-medium">
                    <li><a href="#" class="text-slate-400 hover:text-primary transition-colors flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Tentang Sistem</a></li>
                    <li><a href="#" class="text-slate-400 hover:text-primary transition-colors flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> PPDB <?php echo e(date('Y')); ?></a></li>
                    <li><a href="#" class="text-slate-400 hover:text-primary transition-colors flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Galeri Sekolah</a></li>
                    <li><a href="#" class="text-slate-400 hover:text-primary transition-colors flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Kebijakan Privasi</a></li>
                </ul>
            </div>

            <div class="lg:col-span-4">
                <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm">Kunjungi Kami</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot mt-1 text-slate-500 w-4 text-center"></i>
                        <span class="leading-relaxed"><?php echo e($pengaturan->alamat ?? 'Jl. Pendidikan No. 1, Kec. Pintar, Kota Pelajar, 12345'); ?></span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-phone text-slate-500 w-4 text-center"></i>
                        <span><?php echo e($pengaturan->telepon ?? '(021) 555-0123'); ?></span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope text-slate-500 w-4 text-center"></i>
                        <a href="mailto:<?php echo e($pengaturan->email ?? 'info@smpn1example.sch.id'); ?>" class="hover:text-primary transition-colors">
                            <?php echo e($pengaturan->email ?? 'info@smpn1example.sch.id'); ?>

                        </a>
                    </li>
                </ul>
                
                <!-- Social Media Dinamis -->
                <div class="flex gap-3 mt-6">
                    <?php if($pengaturan && $pengaturan->facebook): ?>
                        <a href="<?php echo e($pengaturan->facebook); ?>" target="_blank" class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 hover:text-white hover:-translate-y-1 transition-all duration-300"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                    <?php endif; ?>
                    
                    <?php if($pengaturan && $pengaturan->instagram): ?>
                        <a href="<?php echo e($pengaturan->instagram); ?>" target="_blank" class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center hover:bg-pink-600 hover:text-white hover:-translate-y-1 transition-all duration-300"><i class="fa-brands fa-instagram text-sm"></i></a>
                    <?php endif; ?>
                    
                    <?php if($pengaturan && $pengaturan->tiktok): ?>
                        <a href="<?php echo e($pengaturan->tiktok); ?>" target="_blank" class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center hover:bg-black hover:text-white hover:-translate-y-1 transition-all duration-300"><i class="fa-brands fa-tiktok text-sm"></i></a>
                    <?php endif; ?>
                    
                    <?php if($pengaturan && $pengaturan->youtube): ?>
                        <a href="<?php echo e($pengaturan->youtube); ?>" target="_blank" class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center hover:bg-red-600 hover:text-white hover:-translate-y-1 transition-all duration-300"><i class="fa-brands fa-youtube text-sm"></i></a>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <div class="pt-8 border-t border-slate-800/80 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500 font-medium">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e($pengaturan->nama_sekolah ?? 'SMP Negeri 1 Example'); ?>. Hak Cipta Dilindungi.</p>
            <p class="flex items-center gap-1">
                Dibuat dengan <i class="fa-solid fa-heart text-red-500 animate-pulse"></i> untuk generasi berprestasi
            </p>
        </div>

    </div>
</footer><?php /**PATH D:\prestasi-siswa\resources\views/layouts/partials/footer.blade.php ENDPATH**/ ?>