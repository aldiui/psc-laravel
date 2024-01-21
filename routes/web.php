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
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(['auth', 'checkRole:admin'])->group(function () {
    Route::get('' , [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.index');
    Route::redirect('coba', '/admin');
    Route::resource('kategori', App\Http\Controllers\Admin\KategoriController::class)->names('admin.kategori');
    Route::resource('unit', App\Http\Controllers\Admin\UnitController::class)->names('admin.unit');
    Route::resource('barang', App\Http\Controllers\Admin\BarangController::class)->names('admin.barang');
    Route::resource('karyawan', App\Http\Controllers\Admin\KaryawanController::class)->names('admin.karyawan');
    Route::match(['get', 'put'], 'user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user');
    Route::put('user/password', [App\Http\Controllers\Admin\UserController::class, 'updatePassword'])->name('admin.user.password');
    Route::resource('tim', App\Http\Controllers\Admin\TimController::class)->names('admin.tim');
    Route::resource('izin', App\Http\Controllers\Admin\IzinController::class)->names('admin.izin');
    Route::resource('detail-tim', App\Http\Controllers\Admin\DetailTimController::class)->names('admin.detail-tim');
    Route::match(['get', 'put'], 'pengaturan', [App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('admin.pengaturan');
});

Route::middleware(['auth', 'checkRole:user'])->group(function () {
    Route::get('/', [App\Http\Controllers\User\HomeController::class, 'index'])->name('home');
    Route::match(['get', 'put'], 'user', [App\Http\Controllers\User\UserController::class, 'index'])->name('user');
    Route::put('user/password', [App\Http\Controllers\User\UserController::class, 'updatePassword'])->name('user.password');
    Route::match(['get', 'post'], 'presensi', [App\Http\Controllers\User\PresensiController::class, 'index'])->name('presensi');
    Route::resource('izin', App\Http\Controllers\User\IzinController::class)->names('izin');
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
});