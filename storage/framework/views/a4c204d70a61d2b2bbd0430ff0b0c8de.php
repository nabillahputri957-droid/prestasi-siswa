<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Prestasi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; padding: 0; }
        .header p { margin: 5px 0 0 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; text-transform: uppercase; font-size: 10px; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <?php
        $pengaturan = \App\Models\Pengaturan::first();
    ?>

    <div class="kop-surat" style="text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px;">
        <table style="width: 100%; border: none; margin: 0; padding: 0;">
            <tr>
                <td style="width: 80px; border: none; text-align: center; vertical-align: middle;">
                    <?php if($pengaturan && $pengaturan->logo_kop): ?>
                        <?php 
                            $path = public_path('storage/pengaturan/' . $pengaturan->logo_kop);
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            if (file_exists($path)) {
                                $data = file_get_contents($path);
                                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                echo '<img src="'.$base64.'" style="max-width: 80px; max-height: 80px;">';
                            }
                        ?>
                    <?php endif; ?>
                </td>
                <td style="border: none; text-align: center; vertical-align: middle; line-height: 1.2;">
                    <span style="font-size: 14px; text-transform: uppercase; color: #333;"><?php echo e($pengaturan->kop_baris_1 ?? 'PEMERINTAH KABUPATEN BATU BARA'); ?></span><br>
                    <span style="font-size: 15px; font-weight: bold; text-transform: uppercase; color: #111;"><?php echo e($pengaturan->kop_baris_2 ?? 'DINAS PENDIDIKAN'); ?></span><br>
                    <span style="font-size: 18px; font-weight: bold; text-transform: uppercase; color: #000;"><?php echo e($pengaturan->kop_baris_3 ?? 'UPT. SD NEGERI 31 TANAH TINGGI'); ?></span><br>
                    <span style="font-size: 11px; color: #444;"><?php echo e($pengaturan->kop_baris_4 ?? 'Jln Tanah Lapang Dusun VII Desa Tanah Tinggi Kecamatan Air Putih'); ?></span><br>
                    <span style="font-size: 11px; color: #444;"><?php echo e($pengaturan->kop_baris_5 ?? 'NPSN 10204282 Kode Pos 21256'); ?></span>
                </td>
                <td style="width: 80px; border: none;"></td> <!-- Spacer to balance layout -->
            </tr>
        </table>
    </div>

    <div class="header" style="text-align: center; margin-bottom: 15px;">
        <h3 style="margin:0;">LAPORAN DATA PRESTASI SISWA</h3>
        <p style="margin:5px 0 0 0; font-size: 11px; color:#555;">Dicetak pada: <?php echo e(date('d F Y H:i')); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="15%">Nama Siswa</th>
                <th width="10%">Kelas</th>
                <th width="20%">Nama Lomba</th>
                <th width="10%">Juara</th>
                <th width="12%">Kategori</th>
                <th width="12%">Tingkat</th>
                <th width="8%">Tanggal</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $prestasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td><?php echo e($item->siswa->nama); ?></td>
                <td class="text-center"><?php echo e($item->siswa->kelas->nama_kelas ?? 'Alumni'); ?></td>
                <td><?php echo e($item->nama_lomba); ?></td>
                <td class="text-center"><?php echo e($item->juara); ?></td>
                <td><?php echo e($item->kategori->jenis_prestasi); ?><br>(<?php echo e($item->kategori->nama_kategori); ?>)</td>
                <td><?php echo e($item->tingkat->nama_tingkat); ?></td>
                <td class="text-center"><?php echo e($item->tanggal->format('d/m/Y')); ?></td>
                <td class="text-center"><?php echo e(ucfirst($item->status)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

</body>
</html><?php /**PATH D:\prestasi-siswa\resources\views/admin/laporan/pdf.blade.php ENDPATH**/ ?>