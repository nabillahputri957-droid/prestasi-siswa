<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Data Prestasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <!-- Tailwind CSS -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>


    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Poppins', sans-serif; }
        body { font-family:'Poppins',sans-serif; }
    </style>
</head>
<body class="bg-[#dbeafe] text-gray-800 antialiased flex items-center justify-center min-h-screen relative p-5">

    <!-- Loading Screen -->
    <div id="loading-screen"class="fixed inset-0 z-[9999] bg-white bg-opacity-80 backdrop-blur-sm flex-col items-center justify-center hidden">
        <div class="w-12 h-12 border-4 border-gray-200 border-t-blue-500 rounded-full animate-spin"></div>
        <p class="mt-4 text-blue-500 font-medium">Memproses data...</p>
    </div>

    <!-- Login Card -->
    <div class="w-full max-w-4xl bg-[#fffaf0] rounded-3xl shadow-xl overflow-hidden flex">

        <!-- Lottie Animation -->
        <div class="w-1/2 bg-[#bfdbfe] flex items-center justify-center p-8">
            <lottie-player
                src="<?php echo e(asset('Student.json')); ?>"
                background="transparent"
                speed="1"
                style="width:220px;height:220px"
                loop
                autoplay>
            </lottie-player>
        </div>

    <!-- Form Login -->
    <div class="w-1/2 p-8">
    <div class="text-center mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Selamat Datang</h1>
    <p class="text-sm text-gray-500 mt-1">Sistem Manajemen Data Prestasi Siswa</p>
    </div>

    <form action="<?php echo e(route('login.process')); ?>" method="POST" id="main-form">
        <?php echo csrf_field(); ?>

        <!-- Input Email -->
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-regular fa-envelope text-blue-400"></i>
                </div>
                <input type="email" name="email" class="w-full pl-10 pr-4 py-2.5 bg-white border border-blue-100 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 outline-none transition-all text-sm <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="admin@sekolah.com" required value="<?php echo e(old('email')); ?>">
            </div>
            <!-- Error Handling Email -->
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> <?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Input Password -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-lock text-blue-400"></i>
                </div>
                <input type="password" name="password" class="w-full pl-10 pr-4 py-2.5 bg-white border border-blue-100 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 outline-none transition-all text-sm <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="••••••••" required>
            </div>
            <!-- Error Handling Password -->
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> <?php echo e($message); ?></span>
             <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="w-full bg-blue-200 hover:bg-blue-300 text-black font-medium py-2.5 rounded-lg transition shadow-md border border-gray-200">
            Masuk ke Sistem
        </button>
    </form>
</div>

<script>
       // Form Submit Loading
       document.getElementById('main-form').addEventListener('submit', function() {
           document.getElementById('loading-screen').classList.remove('hidden');
           document.getElementById('loading-screen').classList.add('flex');
       });

       // SweetAlert Handling
       <?php if(session('error')): ?>
           Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: '<?php echo e(session('error')); ?>',
              confirmButtonColor: '#3b82f6'
           });
       <?php endif; ?>

       <?php if(session('success')): ?>
           Swal.fire({
               icon: 'success',
               title: 'Berhasil!',
               text: '<?php echo e(session('success')); ?>',
               confirmButtonColor: '#3b82f6',
               timer:2000,
               showConfirmButton:false
               });
        <?php endif; ?>
    </script>
</body>
</html><?php /**PATH D:\prestasi-siswa\resources\views/auth/login.blade.php ENDPATH**/ ?>