<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::match(['get', 'post'], '/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/forgot-password', [App\Http\Controllers\AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\AuthController::class, 'resetPassword'])->name('password.update');
Route::put('/fcm-token', [App\Http\Controllers\AuthController::class, 'updateFCMToken'])->name('fcm-token');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(['auth', 'checkRole:admin,super admin'])->group(function () {
    Route::get('', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.index');
    Route::resource('kategori', App\Http\Controllers\Admin\KategoriController::class)->names('admin.kategori');
    Route::resource('unit', App\Http\Controllers\Admin\UnitController::class)->names('admin.unit');
    Route::resource('barang', App\Http\Controllers\Admin\BarangController::class)->names('admin.barang');
    Route::resource('barang-bawah', App\Http\Controllers\Admin\BarangBawahController::class)->names('admin.barang-bawah');
    Route::match(['get', 'put'], 'profil', [App\Http\Controllers\Admin\ProfilController::class, 'index'])->name('admin.profil');
    Route::put('profil/password', [App\Http\Controllers\Admin\ProfilController::class, 'updatePassword'])->name('admin.profil.password');
    Route::resource('stok', App\Http\Controllers\Admin\StokController::class)->names('admin.stok');
    Route::resource('detail-stok', App\Http\Controllers\Admin\DetailStokController::class)->names('admin.detail-stok');
});

Route::prefix('admin')->middleware(['auth', 'checkRole:super admin'])->group(function () {
    Route::resource('karyawan', App\Http\Controllers\Admin\KaryawanController::class)->names('admin.karyawan');
    Route::resource('izin', App\Http\Controllers\Admin\IzinController::class)->names('admin.izin');
    Route::resource('presensi', App\Http\Controllers\Admin\PresensiController::class)->names('admin.presensi');
    Route::get('rekap-presensi', [App\Http\Controllers\Admin\PresensiController::class, 'rekapPresensi'])->name('admin.presensi.rekap');
    Route::match(['get', 'put'], 'pengaturan', [App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('admin.pengaturan');
});

Route::middleware(['auth', 'checkRole:user,admin,super admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\User\HomeController::class, 'index'])->name('home');
    Route::match(['get', 'put'], 'profil', [App\Http\Controllers\User\ProfilController::class, 'index'])->name('profil');
    Route::put('profil/password', [App\Http\Controllers\User\ProfilController::class, 'updatePassword'])->name('profil.password');
    Route::match(['get', 'post'], 'presensi', [App\Http\Controllers\User\PresensiController::class, 'index'])->name('presensi');
    Route::resource('izin', App\Http\Controllers\User\IzinController::class)->names('izin');
    Route::resource('stok', App\Http\Controllers\User\StokController::class)->names('stok');
    Route::get('barang-bawah', [App\Http\Controllers\User\BarangBawahController::class, 'index'])->name('barang-bawah');
    Route::get('rekap-presensi', [App\Http\Controllers\User\PresensiController::class, 'rekapPresensi'])->name('rekap-presensi');
    Route::resource('detail-stok', App\Http\Controllers\User\DetailStokController::class)->names('detail-stok');
    Route::resource('notifikasi', App\Http\Controllers\User\NotifikasiController::class)->names('notifikasi');
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
});
