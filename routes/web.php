<?php

use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


Route::get('/', [FacilityController::class, 'index'])->name('home');

Route::get('/fasilitas', [FacilityController::class, 'index'])->name('facilities.index');

Route::get('/fasilitas/{facility}', [FacilityController::class, 'availability'])->name('facilities.availability');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'account.status'])->name('dashboard');

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'account.status', 'role:admin']) ->name('admin');

Route::get('/admin/rekap', [AdminController::class, 'rekap'])
    ->middleware(['auth', 'account.status', 'role:admin']) ->name('admin.rekap');

// Admin - Kelola Fasilitas
Route::get('/admin/fasilitas', [AdminController::class, 'fasilitas'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.facilities.index');

Route::get('/admin/fasilitas/create', [AdminController::class, 'createFasilitas'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.facilities.create');

Route::post('/admin/fasilitas', [AdminController::class, 'storeFasilitas'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.facilities.store');

Route::get('/admin/fasilitas/{id}/edit', [AdminController::class, 'editFasilitas'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.facilities.edit');

Route::put('/admin/fasilitas/{id}', [AdminController::class, 'updateFasilitas'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.facilities.update');

Route::put('/admin/fasilitas/{id}/nonaktifkan', [AdminController::class, 'nonaktifkanFasilitas'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.facilities.deactivate');

// Admin - Kelola Pengguna
Route::get('/admin/pengguna', [AdminController::class, 'pengguna'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.pengguna.index');

Route::put('/admin/pengguna/{id}/status', [AdminController::class, 'updateStatusPengguna'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.pengguna.status');

Route::put('/admin/pengguna/{id}/verifikasi', [AdminController::class, 'verifikasiPengguna'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.pengguna.verifikasi');

Route::put('/admin/pengguna/{id}/tolak', [AdminController::class, 'tolakPengguna'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.pengguna.tolak');
    
Route::get('/petugas', function () {
    return 'Halaman Petugas';
})->middleware(['auth', 'account.status', 'role:petugas,admin'])->name('petugas');

Route::get('/pengguna', function () {
    return 'Halaman Pengguna';
})->middleware(['auth', 'account.status', 'role:pengguna,admin'])->name('pengguna');

Route::get('/petugas/reservasi/dashboard', function () {
    return view('petugas.reservasi.dashboard');
})->name('petugas.reservasi.dashboard');

Route::get('/petugas/reservasi/daftar-reservasi', function () {
    return view('petugas.reservasi.daftar-reservasi');
})->name('petugas.reservasi.index');

Route::get('/petugas/reservasi/jadwal-reservasi', function () {
    return view('petugas.reservasi.jadwal-reservasi');
})->name('petugas.reservasi.jadwal');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';