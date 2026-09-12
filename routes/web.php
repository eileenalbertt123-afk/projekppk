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

Route::get('/petugas', function () {
    return 'Halaman Petugas';
})->middleware(['auth', 'account.status', 'role:petugas,admin'])->name('petugas');

Route::get('/pengguna', function () {
    return 'Halaman Pengguna';
})->middleware(['auth', 'account.status', 'role:pengguna,admin'])->name('pengguna');

Route::get('/petugas/reservasi/dashboard', function () {
    return view('petugas.reservasi.dashboard');
})->name('petugas.reservasi.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';