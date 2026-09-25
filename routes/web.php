<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Models\Report;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// --- RUTE PUBLIK ---
Route::get('/', [FacilityController::class, 'index'])
    ->name('home');

Route::get('/fasilitas', [FacilityController::class, 'index'])
    ->name('facilities.index');

Route::get('/fasilitas/{facility}', [FacilityController::class, 'availability'])
    ->name('facilities.availability');

// --- RUTE DASHBOARD USER (PENGGUNA) ---
Route::get('/dashboard', function () {
    $userId = Auth::id();

    $activeReservations = Reservation::where('user_id', $userId)
        ->where('status', 'disetujui')
        ->count();

    $pendingReservations = Reservation::where('user_id', $userId)
        ->where('status', 'menunggu')
        ->count();

    $reportsCount = Report::where('user_id', $userId)
        ->count();

    $reservations = Reservation::where('user_id', $userId)
        ->with('details.facility')
        ->latest('start_time')
        ->get();

    $reports = Report::where('user_id', $userId)
        ->with('facility')
        ->latest()
        ->get();

    return view('dashboard', compact(
        'activeReservations',
        'pendingReservations',
        'reportsCount',
        'reservations',
        'reports'
    ));
})
    ->middleware(['auth', 'account.status'])
    ->name('dashboard');

// --- RUTE ADMIN ---
Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin');

Route::get('/admin/rekap', [AdminController::class, 'rekap'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.rekap');

// --- ADMIN - EXPORT REKAP ---
Route::get('/admin/rekap/export-excel', [AdminController::class, 'exportRekapExcel'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.rekap.export.excel');

Route::get('/admin/rekap/export-csv', [AdminController::class, 'exportRekapCsv'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.rekap.export.csv');

Route::get('/admin/rekap/export-pdf', [AdminController::class, 'exportRekapPdf'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.rekap.export.pdf');

// --- ADMIN - KELOLA FASILITAS ---
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

// --- ADMIN - KELOLA PENGGUNA ---
Route::get('/admin/pengguna', [AdminController::class, 'pengguna'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.pengguna.index');

Route::put('/admin/pengguna/{id}/status', [AdminController::class, 'updateStatusPengguna'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.pengguna.status');

// --- ADMIN - VERIFIKASI PENGGUNA ---
Route::put('/admin/pengguna/{id}/verifikasi', [AdminController::class, 'verifikasiPengguna'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.pengguna.verifikasi');

Route::put('/admin/pengguna/{id}/tolak', [AdminController::class, 'tolakPengguna'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.pengguna.tolak');

// --- RUTE PETUGAS ---
Route::get('/petugas', function () {
    return redirect()->route('petugas.reservasi.dashboard');
})
    ->middleware(['auth', 'account.status', 'role:petugas'])
    ->name('petugas');

Route::get(
    '/petugas/reservasi/dashboard',
    [ReservationController::class, 'dashboard']
)
    ->middleware(['auth', 'account.status', 'role:petugas'])
    ->name('petugas.reservasi.dashboard');

Route::get(
    '/petugas/reservasi/daftar-reservasi',
    [ReservationController::class, 'index']
)
    ->middleware(['auth', 'account.status', 'role:petugas'])
    ->name('petugas.reservasi.index');

Route::get(
    '/petugas/reservasi/jadwal-reservasi',
    [ReservationController::class, 'schedule']
)
    ->middleware(['auth', 'account.status', 'role:petugas'])
    ->name('petugas.reservasi.jadwal');

Route::get(
    '/petugas/reservasi/detail-reservasi/{reservation}',
    [ReservationController::class, 'show']
)
    ->middleware(['auth', 'account.status', 'role:petugas'])
    ->name('petugas.reservasi.detail');

Route::patch(
    '/petugas/reservasi/{reservation}/status',
    [ReservationController::class, 'updateStatus']
)
    ->middleware(['auth', 'account.status', 'role:petugas,admin'])
    ->name('petugas.reservasi.update-status');

// --- RUTE PENGGUNA ---
Route::get('/pengguna', function () {
    return redirect()->route('dashboard');
})
    ->middleware(['auth', 'account.status', 'role:pengguna'])
    ->name('pengguna');

// --- RUTE LAPORAN PETUGAS ---
Route::get(
    '/petugas/laporan/dashboard',
    [ReportController::class, 'dashboard']
)
    ->middleware(['auth', 'account.status', 'role:petugas'])
    ->name('petugas.laporan.dashboard');

Route::get(
    '/petugas/laporan/daftar-laporan',
    [ReportController::class, 'index']
)
    ->middleware(['auth', 'account.status', 'role:petugas'])
    ->name('petugas.laporan.index');

Route::get(
    '/petugas/laporan/detail/{report}',
    [ReportController::class, 'show']
)
    ->middleware(['auth', 'account.status', 'role:petugas'])
    ->name('petugas.laporan.detail');
    
Route::post(
    '/laporan',
    [ReportController::class, 'store']
)
    ->middleware(['auth', 'account.status'])
    ->name('laporan.store');

Route::get(
    '/petugas/fasilitas',
    [FacilityController::class, 'list']
)
    ->middleware(['auth', 'account.status', 'role:petugas'])
    ->name('petugas.fasilitas.index');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // --- Route Reservasi ---
    Route::get(
        '/reservations/create',
        [ReservationController::class, 'create']
    )->name('reservations.create');

    Route::post(
        '/reservations',
        [ReservationController::class, 'store']
    )->name('reservations.store');

    Route::patch(
        '/reservations/{reservation}/cancel',
        [ReservationController::class, 'cancel']
    )->name('reservations.cancel');

    // --- Route Lapor Kerusakan User ---
    Route::get(
        '/reports',
        [ReportController::class, 'userIndex']
    )->name('reports.index');

    Route::get(
        '/reports/create',
        [ReportController::class, 'create']
    )->name('reports.create');

    Route::post(
        '/reports',
        [ReportController::class, 'userStore']
    )->name('reports.store');
});

require __DIR__ . '/auth.php';

// --- API AJAX (FETCH SLOT INSTAN) ---
Route::get(
    '/api/facilities/{facility}/slots',
    function (Request $request, \App\Models\Facility $facility) {

        $date = $request->query(
            'date',
            \Carbon\Carbon::today('Asia/Jakarta')->toDateString()
        );

        $slots = app(FacilityController::class)
            ->getSlotsForDate($facility, $date);

        return response()->json([
            'date' => $date,
            'formatted_date' => \Carbon\Carbon::parse($date)
                ->translatedFormat('l, d F Y'),
            'slots' => $slots,
        ]);
    }
)->name('api.facilities.slots');