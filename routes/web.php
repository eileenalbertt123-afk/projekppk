<?php

use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReportController;

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
    return redirect()->route('petugas.reservasi.dashboard');
})
->middleware(['auth', 'account.status', 'role:petugas'])
->name('petugas');

Route::get('/pengguna', function () {
    return 'Halaman Pengguna';
})->middleware(['auth', 'account.status', 'role:pengguna,admin'])->name('pengguna');

Route::get('/petugas/reservasi/dashboard',
    [ReservationController::class, 'dashboard']
)->name('petugas.reservasi.dashboard');

Route::get('/petugas/reservasi/daftar-reservasi',
    [ReservationController::class, 'index']
)->name('petugas.reservasi.index');

Route::get('/petugas/reservasi/jadwal-reservasi',
    [ReservationController::class, 'schedule']
)
->middleware(['auth', 'account.status', 'role:petugas'])
->name('petugas.reservasi.jadwal');

Route::get(
    '/petugas/reservasi/detail-reservasi/{reservation}',
    [ReservationController::class, 'show']
)->name('petugas.reservasi.detail');

Route::patch(
    '/petugas/reservasi/{reservation}/status',
    [ReservationController::class, 'updateStatus']
)
->middleware(['auth', 'account.status', 'role:petugas,admin'])
->name('petugas.reservasi.update-status');

Route::get('/petugas/laporan/dashboard', [ReportController::class, 'dashboard'])
    ->middleware(['auth', 'account.status', 'role:petugas'])
    ->name('petugas.laporan.dashboard');

Route::get('/petugas/laporan/daftar-laporan',
    [ReportController::class, 'index']
)->name('petugas.laporan.index');

Route::post('/laporan',
    [ReportController::class, 'store']
)
->middleware(['auth', 'account.status'])
->name('laporan.store');

Route::get('/petugas/fasilitas', [FacilityController::class, 'list'])
    ->middleware(['auth', 'account.status', 'role:petugas'])
    ->name('petugas.fasilitas.index');

Route::get(
    '/petugas/laporan/detail/{report}',
    [ReportController::class, 'show']
)
->middleware(['auth', 'account.status', 'role:petugas'])
->name('petugas.laporan.detail');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';