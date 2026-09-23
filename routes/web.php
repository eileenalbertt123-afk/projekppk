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
Route::get('/', [FacilityController::class, 'index'])->name('home');

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


// --- RUTE PENGGUNA TERINTEGRASI (AUTH) ---
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


    // --- Route Lapor Kerusakan ---
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    Route::get('/reports/create', [ReportController::class, 'create'])
        ->name('reports.create');

    Route::post('/reports', [ReportController::class, 'store'])
        ->name('reports.store');
});


require __DIR__.'/auth.php';


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