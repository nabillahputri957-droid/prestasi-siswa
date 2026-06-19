<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\TingkatController;
use App\Http\Controllers\Admin\ModulPrestasiController;
use App\Http\Controllers\Admin\ValidasiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\NotifikasiController;
use App\Http\Controllers\Kepsek\DashboardController as KepsekDashboardController;
use App\Http\Controllers\Kepsek\VerifikasiController;
use App\Http\Controllers\Kepsek\PrestasiController as KepsekPrestasiController;
use App\Http\Controllers\Kepsek\LaporanController as KepsekLaporanController;
use App\Http\Controllers\Kepsek\NotifikasiController as KepsekNotifikasiController;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\Pengunjung\PrestasiController as PublicPrestasiController;
use App\Http\Controllers\Admin\PengaturanController;




//Route awal halaman home 
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/prestasi', [PublicPrestasiController::class, 'index'])->name('public.prestasi.index');
Route::get('/prestasi-unggulan', [PublicPrestasiController::class, 'unggulan'])->name('public.prestasi.unggulan');

// Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Area Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/siswa/search', [SiswaController::class, 'searchByNisn'])->name('siswa.search');
    Route::resource('siswa', SiswaController::class);
    Route::post('tahun-ajaran/{id}/set-aktif', [TahunAjaranController::class, 'setAktif'])->name('tahun-ajaran.set-aktif');
    Route::resource('tahun-ajaran', TahunAjaranController::class);
    Route::resource('kelas', KelasController::class)->except(['create', 'edit', 'show']);
    Route::get('/modul-prestasi', [ModulPrestasiController::class, 'index'])->name('modul-prestasi.index');
    Route::resource('kategori', KategoriController::class)->except(['create', 'edit', 'show', 'index']);
    Route::resource('tingkat', TingkatController::class)->except(['create', 'edit', 'show', 'index']);
    Route::get('/kategori', function () { return redirect()->route('admin.modul-prestasi.index'); });
    Route::get('/tingkat', function () { return redirect()->route('admin.modul-prestasi.index'); });
    Route::resource('prestasi', App\Http\Controllers\Admin\PrestasiController::class);
    Route::get('/validasi-status', [ValidasiController::class, 'index'])->name('validasi.index');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('/notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.read-all');
    Route::delete('/notifikasi/{id}', [NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan/update', [PengaturanController::class, 'update'])->name('pengaturan.update');
});

// Area Kepala Sekolah
Route::middleware(['auth', 'role:kepala_sekolah'])->prefix('kepsek')->name('kepsek.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::get('/verifikasi/{id}', [VerifikasiController::class, 'show'])->name('verifikasi.show');
    Route::post('/verifikasi/{id}/validasi', [VerifikasiController::class, 'validasi'])->name('verifikasi.validasi');
    Route::get('/prestasi', [KepsekPrestasiController::class, 'index'])->name('prestasi.index');
    Route::get('/laporan', [KepsekLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [KepsekLaporanController::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('/laporan/excel', [KepsekLaporanController::class, 'exportExcel'])->name('laporan.excel');
    Route::get('/notifikasi', [KepsekNotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{id}/read', [KepsekNotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('/notifikasi/read-all', [KepsekNotifikasiController::class, 'markAllAsRead'])->name('notifikasi.read-all');
    Route::delete('/notifikasi/{id}', [KepsekNotifikasiController::class, 'destroy'])->name('notifikasi.destroy');
});
