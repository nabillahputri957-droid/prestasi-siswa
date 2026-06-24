<?php $__env->startSection('title', 'Pengaturan Website - Admin'); ?>
<?php $__env->startSection('header_title', 'Pengaturan Website'); ?>
<?php $__env->startSection('header_subtitle', 'Kelola identitas sekolah dan tampilan halaman pengunjung'); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('admin.pengaturan.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-5xl pb-10">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Info & Sosmed -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Card 1: Informasi Umum -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50 flex items-center gap-2">
                    <i class="fa-solid fa-building text-primary"></i>
                    <h3 class="font-semibold text-gray-800">Informasi Sekolah</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah</label>
                        <input type="text" name="nama_sekolah" value="<?php echo e(old('nama_sekolah', $pengaturan->nama_sekolah)); ?>" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none transition-all">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Sekolah</label>
                            <input type="email" name="email" value="<?php echo e(old('email', $pengaturan->email)); ?>" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="text" name="telepon" value="<?php echo e(old('telepon', $pengaturan->telepon)); ?>" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none transition-all"><?php echo e(old('alamat', $pengaturan->alamat)); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Card 2: Media Sosial -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50 flex items-center gap-2">
                    <i class="fa-solid fa-hashtag text-primary"></i>
                    <h3 class="font-semibold text-gray-800">Tautan Media Sosial</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1 uppercase"><i class="fa-brands fa-instagram mr-1 text-pink-600"></i> Instagram URL</label>
                        <input type="url" name="instagram" value="<?php echo e(old('instagram', $pengaturan->instagram)); ?>" placeholder="https://instagram.com/..." class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1 uppercase"><i class="fa-brands fa-facebook mr-1 text-blue-600"></i> Facebook URL</label>
                        <input type="url" name="facebook" value="<?php echo e(old('facebook', $pengaturan->facebook)); ?>" placeholder="https://facebook.com/..." class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1 uppercase"><i class="fa-brands fa-tiktok mr-1 text-black"></i> TikTok URL</label>
                        <input type="url" name="tiktok" value="<?php echo e(old('tiktok', $pengaturan->tiktok)); ?>" placeholder="https://tiktok.com/@..." class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1 uppercase"><i class="fa-brands fa-youtube mr-1 text-red-600"></i> YouTube URL</label>
                        <input type="url" name="youtube" value="<?php echo e(old('youtube', $pengaturan->youtube)); ?>" placeholder="https://youtube.com/..." class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                    </div>
                </div>
            </div>

            <!-- Card 3: Kop Laporan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50 flex items-center gap-2">
                    <i class="fa-solid fa-file-contract text-primary"></i>
                    <h3 class="font-semibold text-gray-800">Kop Surat (Laporan)</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-8">
                        <!-- Form Inputs -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Baris 1 (Instansi Utama)</label>
                                <input type="text" name="kop_baris_1" id="input_kop_baris_1" value="<?php echo e(old('kop_baris_1', $pengaturan->kop_baris_1)); ?>" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Baris 2 (Dinas/Unit)</label>
                                <input type="text" name="kop_baris_2" id="input_kop_baris_2" value="<?php echo e(old('kop_baris_2', $pengaturan->kop_baris_2)); ?>" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Baris 3 (Nama Sekolah)</label>
                                <input type="text" name="kop_baris_3" id="input_kop_baris_3" value="<?php echo e(old('kop_baris_3', $pengaturan->kop_baris_3)); ?>" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Baris 4 (Alamat Kop)</label>
                                <input type="text" name="kop_baris_4" id="input_kop_baris_4" value="<?php echo e(old('kop_baris_4', $pengaturan->kop_baris_4)); ?>" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Baris 5 (Kontak/NPSN)</label>
                                <input type="text" name="kop_baris_5" id="input_kop_baris_5" value="<?php echo e(old('kop_baris_5', $pengaturan->kop_baris_5)); ?>" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Logo Kop Surat</label>
                                <input type="file" name="logo_kop" id="input_logo_kop" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-primary hover:file:bg-blue-100">
                            </div>
                        </div>

                        <!-- Live Preview -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Live Preview (Kop Surat)</label>
                            <div class="border border-gray-300 p-4 pb-8 rounded-lg bg-white relative overflow-hidden flex items-center justify-center min-h-[150px] shadow-sm">
                                <div class="flex items-center w-full gap-4 relative z-10">
                                    <!-- Logo Box -->
                                    <div class="w-20 flex-shrink-0 flex items-center justify-center aspect-square">
                                        <img id="preview_logo_kop" src="<?php echo e($pengaturan->logo_kop ? asset('storage/pengaturan/' . $pengaturan->logo_kop) : ''); ?>" class="<?php echo e($pengaturan->logo_kop ? '' : 'hidden'); ?> max-w-full max-h-full object-contain">
                                        <?php if(!$pengaturan->logo_kop): ?>
                                            <div id="preview_logo_placeholder" class="w-full h-full border-2 border-dashed border-gray-300 flex items-center justify-center text-gray-400 text-xs">Logo</div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Text Box -->
                                    <div class="flex-grow flex flex-col items-center justify-center leading-snug">
                                        <span id="preview_baris_1" class="text-[14px] text-gray-700 uppercase text-center"><?php echo e($pengaturan->kop_baris_1 ?: 'PEMERINTAH KABUPATEN BATU BARA'); ?></span>
                                        <span id="preview_baris_2" class="text-[15px] font-semibold text-gray-800 uppercase text-center"><?php echo e($pengaturan->kop_baris_2 ?: 'DINAS PENDIDIKAN'); ?></span>
                                        <span id="preview_baris_3" class="text-[18px] font-bold text-black uppercase text-center"><?php echo e($pengaturan->kop_baris_3 ?: 'UPT. SD NEGERI 31 TANAH TINGGI'); ?></span>
                                        <span id="preview_baris_4" class="text-[11px] text-gray-600 text-center"><?php echo e($pengaturan->kop_baris_4 ?: 'Jln Tanah Lapang Dusun VII Desa Tanah Tinggi Kecamatan Air Putih'); ?></span>
                                        <span id="preview_baris_5" class="text-[11px] text-gray-600 text-center"><?php echo e($pengaturan->kop_baris_5 ?: 'NPSN 10204282 Kode Pos 21256'); ?></span>
                                    </div>
                                </div>
                                <!-- Double Line Bottom -->
                                <div class="absolute bottom-3 left-4 right-4 border-b-[4px] border-black border-double"></div>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2 text-center">Tampilan kop surat ini akan digunakan pada file PDF laporan yang dicetak.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Gambar & Logo -->
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50 flex items-center gap-2">
                    <i class="fa-solid fa-image text-primary"></i>
                    <h3 class="font-semibold text-gray-800">Aset Visual</h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Upload Logo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo Sekolah</label>
                        <div class="mb-3 w-24 h-24 rounded-lg border border-gray-200 p-2 flex items-center justify-center bg-gray-50">
                            <?php if($pengaturan->logo): ?>
                                <img src="<?php echo e(asset('storage/pengaturan/' . $pengaturan->logo)); ?>" class="max-w-full max-h-full object-contain">
                            <?php else: ?>
                                <i class="fa-solid fa-school text-3xl text-gray-300"></i>
                            <?php endif; ?>
                        </div>
                        <input type="file" name="logo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-primary hover:file:bg-blue-100">
                        <p class="text-[10px] text-gray-400 mt-1">Format: JPG, PNG. Maks: 2MB.</p>
                    </div>

                    <hr class="border-gray-100">

                    <!-- Upload Hero Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Hero (Beranda)</label>
                        <div class="mb-3 w-full aspect-video rounded-lg border border-gray-200 flex items-center justify-center bg-gray-50 overflow-hidden">
                            <?php if($pengaturan->hero_image): ?>
                                <img src="<?php echo e(asset('storage/pengaturan/' . $pengaturan->hero_image)); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <i class="fa-solid fa-image text-3xl text-gray-300"></i>
                            <?php endif; ?>
                        </div>
                        <input type="file" name="hero_image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-primary hover:file:bg-blue-100">
                        <p class="text-[10px] text-gray-400 mt-1">Rasio disarankan 4:3 atau 16:9. Maks: 5MB.</p>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="w-full py-3.5 bg-blue-200 hover:bg-blue-300 text-gray font-bold rounded-xl shadow-md shadow-blue-500/20 transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan
            </button>

        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Live Preview Kop Surat Text
        const inputs = ['kop_baris_1', 'kop_baris_2', 'kop_baris_3', 'kop_baris_4', 'kop_baris_5'];
        inputs.forEach(id => {
            const inputEl = document.getElementById('input_' + id);
            const previewEl = document.getElementById('preview_' + id.replace('kop_', ''));
            if (inputEl && previewEl) {
                inputEl.addEventListener('input', function() {
                    previewEl.innerText = this.value;
                });
            }
        });

        // Live Preview Logo
        const logoInput = document.getElementById('input_logo_kop');
        const logoPreview = document.getElementById('preview_logo_kop');
        const logoPlaceholder = document.getElementById('preview_logo_placeholder');
        
        if (logoInput) {
            logoInput.addEventListener('change', function(event) {
                if (event.target.files && event.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        logoPreview.src = e.target.result;
                        logoPreview.classList.remove('hidden');
                        if (logoPlaceholder) logoPlaceholder.style.display = 'none';
                    }
                    reader.readAsDataURL(event.target.files[0]);
                }
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\prestasi-siswa\resources\views/admin/pengaturan/index.blade.php ENDPATH**/ ?>