<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Prestasi Siswa & Alumni'); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Poppins', sans-serif;
            --color-primary: #3b82f6;
        }
        body { font-family: 'Poppins', sans-serif; }
        
        /* Keyframes dari desainmu */
        @keyframes floatY {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes floatYRev {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(10px); }
        }
        .animate-floatY { animation: floatY 4s ease-in-out infinite; }
        .animate-floatYRev { animation: floatYRev 5s ease-in-out infinite; }
    </style>
</head>
<body class="font-sans bg-white text-slate-900 antialiased overflow-x-hidden">

    <?php echo $__env->make('layouts.partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="min-h-screen">
        <?php echo $__env->yieldContent('content'); ?>
    </main>


    <?php echo $__env->make('layouts.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </body>
</html><?php /**PATH D:\prestasi-siswa\resources\views/layouts/public.blade.php ENDPATH**/ ?>