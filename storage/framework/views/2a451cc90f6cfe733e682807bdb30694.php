<?php $__env->startSection('title', isset($prestasi) ? 'Edit Prestasi' : 'Tambah Prestasi'); ?>
<?php $__env->startSection('header_title', isset($prestasi) ? 'Edit Prestasi' : 'Tambah Prestasi'); ?>
<?php $__env->startSection('header_subtitle', 'Form input data prestasi siswa'); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(isset($prestasi) ? route('admin.prestasi.update', $prestasi->id) : route('admin.prestasi.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php if(isset($prestasi)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="text-primary font-semibold mb-6 flex items-center gap-2">
                <i class="fa-solid fa-trophy"></i> Informasi Prestasi
            </h4>

            <div class="space-y-5">
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lomba</label>
                        <input type="text" name="nama_lomba" value="<?php echo e(old('nama_lomba', $prestasi->nama_lomba ?? '')); ?>" placeholder="Masukkan nama lomba" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Juara Ke-</label>
                        <select name="juara" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none text-sm">
                            <option value="">Pilih Juara</option>
                            <?php
                                $options = ['Juara 1', 'Juara 2', 'Juara 3', 'Harapan 1', 'Harapan 2', 'Harapan 3', 'Peserta/Finalis', 'Lainnya'];
                            ?>
                            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($opt); ?>" <?php echo e(old('juara', $prestasi->juara ?? '') == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="kategori_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none text-sm">
                            <option value="">Pilih kategori</option>
                            <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($k->id); ?>" <?php echo e(old('kategori_id', $prestasi->kategori_id ?? '') == $k->id ? 'selected' : ''); ?>><?php echo e($k->jenis_prestasi); ?> (<?php echo e($k->nama_kategori); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat</label>
                        <select name="tingkat_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none text-sm">
                            <option value="">Pilih tingkat</option>
                            <?php $__currentLoopData = $tingkat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($t->id); ?>" <?php echo e(old('tingkat_id', $prestasi->tingkat_id ?? '') == $t->id ? 'selected' : ''); ?>><?php echo e($t->nama_tingkat); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="w-1/2 pr-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="tanggal" value="<?php echo e(old('tanggal', isset($prestasi) ? $prestasi->tanggal->format('Y-m-d') : '')); ?>" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" placeholder="Masukkan deskripsi prestasi..." required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none text-sm"><?php echo e(old('deskripsi', $prestasi->deskripsi ?? '')); ?></textarea>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h4 class="text-primary font-semibold mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-user-graduate"></i> Informasi Siswa
                </h4>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari NISN Siswa</label>
                    <div class="relative">
                        <input type="text" id="search_nisn" placeholder="Ketik NISN..." value="<?php echo e(isset($prestasi) ? $prestasi->siswa->nisn : ''); ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none text-sm">
                        <div id="search-loading" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
                            <i class="fa-solid fa-spinner fa-spin text-primary"></i>
                        </div>
                    </div>
                    <p id="nisn-error" class="text-xs text-red-500 mt-1 hidden">Siswa tidak ditemukan!</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Siswa</label>
                    <input type="text" id="display_nama" readonly value="<?php echo e(isset($prestasi) ? $prestasi->siswa->nama : ''); ?>" class="w-full px-4 py-2.5 bg-gray-100 border border-gray-200 rounded-lg text-sm text-gray-500 cursor-not-allowed">
                    <input type="hidden" name="siswa_id" id="siswa_id" value="<?php echo e(isset($prestasi) ? $prestasi->siswa_id : ''); ?>" required>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Prestasi</label>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition-colors relative cursor-pointer" onclick="document.getElementById('file_upload').click()">
                        <i class="fa-solid fa-cloud-arrow-up text-4xl text-primary mb-3"></i>
                        <p class="text-sm font-medium text-gray-700">Upload bukti (sertifikat/foto)</p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, PDF maksimal 5MB</p>
                        <input type="file" name="file_bukti" id="file_upload" class="hidden" accept=".png,.jpg,.jpeg,.pdf" <?php echo e(isset($prestasi) ? '' : 'required'); ?> onchange="updateFileName(this)">
                    </div>
                    <p id="file-name" class="text-xs text-green-600 mt-2 font-medium"></p>
                    <?php if(isset($prestasi)): ?>
                        <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah bukti lama.</p>
                    <?php endif; ?>
                </div>

                <hr class="border-gray-100 my-5">

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Prestasi Unggulan</p>
                        <p class="text-xs text-gray-400">Jadikan prestasi ini sebagai unggulan</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="unggulan" value="1" class="sr-only peer" <?php echo e(old('unggulan', $prestasi->unggulan ?? false) ? 'checked' : ''); ?>>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="<?php echo e(route('admin.prestasi.index')); ?>" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-8 py-2.5 bg-primary hover:bg-blue-200 text-white rounded-lg text-sm font-semibold shadow-md shadow-blue-200 transition-all">Simpan</button>
            </div>

        </div>
    </div>
</form>

<script>
    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : '';
        document.getElementById('file-name').innerText = fileName ? 'File terpilih: ' + fileName : '';
    }
    
    // Auto-fill Siswa based on NISN
    const searchNisn = document.getElementById('search_nisn');
    const displayNama = document.getElementById('display_nama');
    const siswaId = document.getElementById('siswa_id');
    const loading = document.getElementById('search-loading');
    const errorMsg = document.getElementById('nisn-error');

    let timeout = null;
    searchNisn.addEventListener('input', function() {
        clearTimeout(timeout);
        const nisn = this.value.trim();
        
        if (nisn.length < 3) {
            displayNama.value = '';
            siswaId.value = '';
            errorMsg.classList.add('hidden');
            return;
        }

        loading.classList.remove('hidden');
        errorMsg.classList.add('hidden');

        timeout = setTimeout(() => {
            fetch(`/admin/siswa/search?nisn=${nisn}`)
                .then(res => res.json())
                .then(data => {
                    loading.classList.add('hidden');
                    if (data.success) {
                        displayNama.value = data.data.nama;
                        siswaId.value = data.data.id;
                        errorMsg.classList.add('hidden');
                    } else {
                        displayNama.value = '';
                        siswaId.value = '';
                        errorMsg.classList.remove('hidden');
                    }
                })
                .catch(() => {
                    loading.classList.add('hidden');
                    errorMsg.classList.remove('hidden');
                    errorMsg.innerText = 'Terjadi kesalahan jaringan!';
                });
        }, 500); // 500ms debounce
    });

    // Error Handling SweetAlert
    <?php if($errors->any()): ?>
        Swal.fire({ icon: 'error', title: 'Periksa kembali inputan Anda', text: '<?php echo e($errors->first()); ?>', confirmButtonColor: '#3b82f6' });
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\prestasi-siswa\resources\views/admin/prestasi/form.blade.php ENDPATH**/ ?>