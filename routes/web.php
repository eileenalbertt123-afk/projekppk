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


Route::get('/', function () {
    $user = \Illuminate\Support\Facades\Auth::user();

    if ($user) {
        if ($user->role === 'admin') {
            return redirect()->route('admin');
        }

        if ($user->role === 'petugas') {
            return redirect()->route('petugas.reservasi.dashboard');
        }
    }

    return redirect()->route('facilities.index');
})->name('home');

Route::get('/fasilitas', [FacilityController::class, 'index'])
    ->name('facilities.index');

Route::get('/fasilitas/{facility}', [FacilityController::class, 'availability'])
    ->name('facilities.availability');

// Riwayat Reservasi Pengguna

Route::get('/riwayat/reservasi', function (Request $request) {
    $userId = Auth::id();

    $urutan = $request->query('urutan', 'terbaru');
    $status = $request->query('status', 'semua');

    $activeReservations = Reservation::where('user_id', $userId)
        ->where('status', 'disetujui')
        ->count();

    $pendingReservations = Reservation::where('user_id', $userId)
        ->where('status', 'menunggu')
        ->count();

    $reservations = Reservation::where('user_id', $userId)
        ->with('details.facility')
        ->orderBy('created_at', $urutan === 'terlama' ? 'asc' : 'desc')
        ->get();

    $filteredReservations = $status === 'semua'
        ? $reservations
        : $reservations->where('status', $status)->values();

    if ($request->ajax()) {
        return view('pengguna.partials.daftar-reservasi', compact(
            'filteredReservations'
        ));
    }

    return view('pengguna.riwayat-reservasi', compact(
        'activeReservations',
        'pendingReservations',
        'reservations',
        'filteredReservations'
    ));
})
    ->middleware(['auth', 'account.status'])
    ->name('riwayat.reservasi');


// Riwayat Laporan Pengguna
Route::get('/riwayat/laporan', function (Request $request) {
    $userId = Auth::id();

    $urutan = $request->query('urutan', 'terbaru');
    $status = $request->query('status', 'semua');

    // Ringkasan jumlah laporan milik pengguna yang login.
    $laporanBaru = Report::where('user_id', $userId)
        ->whereIn('status', ['baru', 'menunggu'])
        ->count();

    $laporanDiproses = Report::where('user_id', $userId)
        ->where('status', 'diproses')
        ->count();

    $laporanDitolak = Report::where('user_id', $userId)
        ->where('status', 'ditolak')
        ->count();

    $laporanSelesai = Report::where('user_id', $userId)
        ->where('status', 'selesai')
        ->count();

    // Ambil laporan sesuai filter dan urutan.
    $query = Report::where('user_id', $userId)
        ->with('facility');

    if ($status === 'baru') {
        $query->whereIn('status', ['baru', 'menunggu']);
    } elseif (in_array($status, ['diproses', 'ditolak', 'selesai'])) {
        $query->where('status', $status);
    }

    $reports = $query
        ->orderBy('created_at', $urutan === 'terlama' ? 'asc' : 'desc')
        ->get();

    // AJAX hanya mengembalikan isi daftar laporan.
    if ($request->ajax()) {
        return view('pengguna.partials.daftar-laporan', compact('reports'));
    }

    return view('pengguna.riwayat-laporan', compact(
        'reports',
        'laporanBaru',
        'laporanDiproses',
        'laporanDitolak',
        'laporanSelesai'
    ));
})
    ->middleware(['auth', 'account.status'])
    ->name('riwayat.laporan');


// Route lama tetap tersedia
Route::get('/riwayat', function () {
    return redirect()->route('riwayat.reservasi');
})
    ->middleware(['auth', 'account.status'])
    ->name('riwayat');

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

// Admin - Tambah Petugas
Route::get('/admin/pengguna/tambah-petugas', [AdminController::class, 'createPetugas'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.pengguna.create.petugas');

Route::post('/admin/pengguna/tambah-petugas', [AdminController::class, 'storePetugas'])
    ->middleware(['auth', 'account.status', 'role:admin'])
    ->name('admin.pengguna.store.petugas');

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
    return redirect()->route('riwayat');
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

Route::get(
    '/reservasi/{reservation}/dokumen',
    [ReservationController::class, 'document']
)
    ->middleware(['auth', 'account.status'])
    ->name('reservations.document');

Route::get(
    '/laporan/{report}/foto',
    [ReportController::class, 'image']
)
    ->middleware(['auth', 'account.status'])
    ->name('reports.image');

Route::middleware(['auth', 'account.status', 'role:petugas'])->group(function () {

    Route::get(
        '/petugas/laporan/detail/{report}',
        [ReportController::class, 'show']
    )->name('petugas.laporan.detail');

    Route::post(
        '/petugas/laporan/{report}/process',
        [ReportController::class, 'process']
    )->name('petugas.laporan.process');

    Route::post(
        '/petugas/laporan/{report}/start-repair',
        [ReportController::class, 'startRepair']
    )->name('petugas.laporan.start-repair');

    Route::patch(
        '/petugas/laporan/{report}/reject',
        [ReportController::class, 'reject']
    )->name('petugas.laporan.reject');

    Route::patch(
        '/petugas/laporan/{report}/complete',
        [ReportController::class, 'complete']
    )->name('petugas.laporan.complete');
});

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

    Route::get(
        '/reservations/{reservation}/detail',
        [ReservationController::class, 'detail']
    )->name('reservations.detail');

    // --- Route Lapor Kerusakan User ---
    Route::get(
        '/reports',
        [ReportController::class, 'userIndex']
    )->name('reports.index');

    Route::get(
        '/reports/create',
        [ReportController::class, 'create']
    )->name('reports.create');

    Route::get(
        '/reports/{report}',
        [ReportController::class, 'userShow']
    )->name('reports.show');

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
