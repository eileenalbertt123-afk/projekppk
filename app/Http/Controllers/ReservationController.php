<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Facility;
use App\Models\ReservationStatusHistory;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function dashboard(Request $request)
    {
        $now = Carbon::now();

        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();
        $reservationsThisMonth = Reservation::with([
            'user',
            'details.facility',
        ])
            ->whereBetween('start_time', [
                $startOfMonth,
                $endOfMonth,
            ])
            ->orderBy('start_time')
            ->get();
        $reservationsLastMonth = Reservation::whereBetween(
            'start_time',
            [
                $startOfLastMonth,
                $endOfLastMonth,
            ]
        )->get();

        $incomingReservations = Reservation::with([
            'user',
            'details.facility',
        ])
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'asc')
            ->limit(3)
            ->get();

        $totalIncomingReservations = Reservation::where(
            'status',
            'menunggu'
        )->count();

        $totalPeminjam = $reservationsThisMonth
            ->pluck('user_id')
            ->unique()
            ->count();

        $totalPeminjamLastMonth = $reservationsLastMonth
            ->pluck('user_id')
            ->unique()
            ->count();

        $persenPeminjam = $totalPeminjamLastMonth > 0
            ? round(
                (($totalPeminjam - $totalPeminjamLastMonth)
                    / $totalPeminjamLastMonth) * 100
            )
            : null;

        $totalReservasi = $reservationsThisMonth->count();

        $totalReservasiLastMonth = $reservationsLastMonth->count();

        $persenReservasi = $totalReservasiLastMonth > 0
            ? round(
                (($totalReservasi - $totalReservasiLastMonth)
                    / $totalReservasiLastMonth) * 100
            )
            : null;

        $rataRataMenitBulanIni = $reservationsThisMonth
            ->avg(function ($reservation) {

                return $reservation->start_time
                    ->diffInMinutes($reservation->end_time);
            }) ?? 0;

        $adaDataBulanLalu = $reservationsLastMonth->isNotEmpty();

        if ($adaDataBulanLalu) {

            $rataRataMenitBulanLalu = $reservationsLastMonth
                ->avg(function ($reservation) {

                    return $reservation->start_time
                        ->diffInMinutes($reservation->end_time);
                }) ?? 0;

            $selisihWaktuReservasi = round(
                $rataRataMenitBulanIni
                    - $rataRataMenitBulanLalu
            );
        } else {

            $selisihWaktuReservasi = null;
        }
        $rataRataWaktuReservasi = round(
            $rataRataMenitBulanIni / 60,
            1
        );

        $menungguBulanIni = $reservationsThisMonth
            ->where('status', 'menunggu')
            ->count();

        $disetujuiBulanIni = $reservationsThisMonth
            ->where('status', 'disetujui')
            ->count();

        $ditolakBulanIni = $reservationsThisMonth
            ->where('status', 'ditolak')
            ->count();

        $dibatalkanBulanIni = $reservationsThisMonth
            ->where('status', 'dibatalkan')
            ->count();

        $selesaiBulanIni = $reservationsThisMonth
            ->where('status', 'selesai')
            ->count();

        $ditolakDibatalkanBulanIni =
            $ditolakBulanIni + $dibatalkanBulanIni;


        $statusSummary = [
            [
                'key' => 'menunggu',
                'label' => 'Menunggu',
                'value' => $menungguBulanIni,
                'desc' => 'Perlu review',
            ],

            [
                'key' => 'disetujui',
                'label' => 'Disetujui',
                'value' => $disetujuiBulanIni,
                'desc' => 'Terkonfirmasi',
            ],

            [
                'key' => 'dibatalkan_ditolak',
                'label' => 'Dibatalkan/Ditolak',
                'value' => $ditolakDibatalkanBulanIni,
                'desc' => 'Tidak aktif',
            ],

            [
                'key' => 'selesai',
                'label' => 'Selesai',
                'value' => $selesaiBulanIni,
                'desc' => 'Reservasi selesai',
            ],
        ];

        $todaySchedule = $reservationsThisMonth
            ->filter(function ($reservation) {

                return $reservation->status === 'disetujui'
                    && $reservation->start_time->isToday();
            })
            ->sortBy('start_time')
            ->values();


        $scheduleDateLabel = Carbon::today()
            ->locale('id')
            ->translatedFormat('l, d F Y');

        $selectedMonth = $request->query('month');

        if ($selectedMonth) {

            $calendarDate = Carbon::createFromFormat(
                'Y-m',
                $selectedMonth
            )->startOfMonth();
        } else {

            $calendarDate = $now->copy()->startOfMonth();
        }
        $calendarMonthLabel = $calendarDate
            ->locale('id')
            ->translatedFormat('F Y');
        $previousMonth = $calendarDate
            ->copy()
            ->subMonth()
            ->format('Y-m');
        $nextMonth = $calendarDate
            ->copy()
            ->addMonth()
            ->format('Y-m');
        if ($calendarDate->isSameMonth($now)) {

            $calendarReservations = $reservationsThisMonth;
        } else {
            $calendarReservations = Reservation::whereBetween(
                'start_time',
                [
                    $calendarDate->copy()->startOfMonth(),
                    $calendarDate->copy()->endOfMonth(),
                ]
            )
                ->whereIn('status', [
                    'menunggu',
                    'disetujui',
                    'ditolak',
                    'dibatalkan',
                ])
                ->get();
        }

        $reservationsByDate = $calendarReservations
            ->groupBy(function ($reservation) {

                return $reservation->start_time
                    ->format('Y-m-d');
            });
        $calendarStart = $calendarDate
            ->copy()
            ->startOfMonth()
            ->startOfWeek(Carbon::SUNDAY);

        $calendarEnd = $calendarDate
            ->copy()
            ->endOfMonth()
            ->endOfWeek(Carbon::SATURDAY);
        $calendarWeeks = [];
        $currentDate = $calendarStart->copy();
        while ($currentDate <= $calendarEnd) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $dateKey = $currentDate->format('Y-m-d');
                $statuses = collect(
                    $reservationsByDate->get($dateKey, [])
                )
                    ->pluck('status')
                    ->map(function ($status) {

                        if (
                            in_array(
                                $status,
                                ['ditolak', 'dibatalkan']
                            )
                        ) {
                            return 'ditolak';
                        }

                        return $status;
                    })
                    ->unique()
                    ->values()
                    ->toArray();


                $week[] = [
                    'n' => $currentDate->day,

                    'muted' =>
                    $currentDate->month !==
                        $calendarDate->month,

                    'active' =>
                    $currentDate->isToday(),

                    'dots' => $statuses,
                ];


                $currentDate->addDay();
            }

            $calendarWeeks[] = $week;
        }

        return view(
            'petugas.reservasi.dashboard',
            compact(
                'incomingReservations',
                'totalIncomingReservations',

                'totalPeminjam',
                'persenPeminjam',

                'totalReservasi',
                'persenReservasi',

                'rataRataWaktuReservasi',
                'selisihWaktuReservasi',
                'adaDataBulanLalu',

                'statusSummary',

                'todaySchedule',
                'scheduleDateLabel',

                'calendarWeeks',
                'calendarMonthLabel',
                'previousMonth',
                'nextMonth'
            )


        );
    }

    public function index(Request $request)
    {
        $statusCounts = Reservation::selectRaw("
            COUNT(*) as total,
            SUM(status = 'menunggu') as menunggu,
            SUM(status = 'disetujui') as disetujui,
            SUM(status = 'ditolak') as ditolak,
            SUM(status = 'dibatalkan') as dibatalkan
        ")->first();

        $totalReservasi = (int) $statusCounts->total;
        $menungguCount = (int) $statusCounts->menunggu;
        $disetujuiCount = (int) $statusCounts->disetujui;
        $ditolakCount = (int) $statusCounts->ditolak;
        $dibatalkanCount = (int) $statusCounts->dibatalkan;

        $dibatalkanDitolakCount = $ditolakCount + $dibatalkanCount;

        // QUERY DAFTAR RESERVASI


        $query = Reservation::query()
            ->with([
                'user:id,name',
                'details:id,reservation_id,facility_id',
                'details.facility:id,name,type,location',
            ]);


        // SEARCH
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'reservation_code',
                    'like',
                    "%{$search}%"
                )

                    ->orWhereHas('user', function ($userQuery) use ($search) {

                        $userQuery->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    })

                    ->orWhereHas('details.facility', function ($facilityQuery) use ($search) {

                        $facilityQuery->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        // FILTER STATUS
        if (
            $request->filled('status') &&
            $request->status !== 'semua'
        ) {
            $query->where(
                'status',
                $request->status
            );
        }


        // SORTING
        $query->orderBy(
            'created_at',
            $request->sort === 'terlama'
                ? 'asc'
                : 'desc'
        );

        $reservations = $query
            ->paginate(10)
            ->withQueryString();


        // Tabel Reservasi
        // =========================


        return view('petugas.reservasi.daftar-reservasi', compact(
            'totalReservasi',
            'menungguCount',
            'disetujuiCount',
            'dibatalkanDitolakCount',
            'reservations'
        ));
    }


    public function show(Reservation $reservation)
    {
        $reservation->load([
            'user.userType',
            'details.facility',
            'statusHistories.changedBy'
        ]);

        $facilityIds = $reservation->details
            ->pluck('facility_id');

        $conflictingReservation = Reservation::with([
            'user',
            'details.facility',
        ])
            ->where('id', '!=', $reservation->id)
            ->where('status', 'disetujui')
            ->whereHas('details', function ($query) use ($facilityIds) {
                $query->whereIn('facility_id', $facilityIds);
            })
            ->where('start_time', '<', $reservation->end_time)
            ->where('end_time', '>', $reservation->start_time)
            ->orderBy('start_time')
            ->first();

        $hasConflict = $conflictingReservation !== null;

        $queueNumber = Reservation::where(
            'created_at',
            '<=',
            $reservation->created_at
        )->count();

        return view('petugas.reservasi.detail', compact(
            'reservation',
            'queueNumber',
            'hasConflict',
            'conflictingReservation'
        ));
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak,dibatalkan,selesai',
            'reason_category' => 'nullable|string|max:100',
            'reason' => 'nullable|string|max:1000',
            'verification' => 'nullable|array',
        ]);

        $oldStatus = $reservation->status;
        $newStatus = $validated['status'];

        if ($newStatus === 'disetujui') {

            $verification = $validated['verification'] ?? [];

            if (count($verification) < 3) {
                return back()
                    ->withErrors([
                        'verification' => 'Wajib memenuhi 3 kondisi.'
                    ])
                    ->withInput();
            }
        }

        // Validasi transisi status
        $allowedTransitions = [
            'menunggu' => ['disetujui', 'ditolak'],
            'disetujui' => ['dibatalkan', 'selesai'],
            'ditolak' => [],
            'dibatalkan' => [],
            'selesai' => [],
        ];

        if (! in_array($newStatus, $allowedTransitions[$oldStatus] ?? [])) {
            return back()->with('error', 'Perubahan status tidak diizinkan.');
        }

        // reason wajib untuk ditolak / dibatalkan
        if (
            in_array($newStatus, ['ditolak', 'dibatalkan']) &&
            empty($validated['reason'])
        ) {
            return back()
                ->withErrors([
                    'reason' => 'Alasan wajib diisi untuk status ini.'
                ])
                ->withInput();
        }

        DB::transaction(function () use (
            $reservation,
            $newStatus,
            $validated
        ) {
            // update status utama
            $reservation->update([
                'status' => $newStatus,
            ]);

            // simpan riwayat perubahan status
            ReservationStatusHistory::create([
                'reservation_id' => $reservation->id,
                'status' => $newStatus,
                'reason_category' => $validated['reason_category'] ?? null,
                'reason' => $validated['reason'] ?? null,
                'changed_by' => Auth::id(),
            ]);
        });

        return back()->with('success', 'Status reservasi berhasil diperbarui.');
    }

    public function schedule(Request $request)
    {
        $selectedDate = $request->filled('week')
            ? Carbon::parse($request->week)
            : Carbon::today();

        $weekStart = $selectedDate
            ->copy()
            ->startOfWeek(Carbon::MONDAY);

        $weekEnd = $selectedDate
            ->copy()
            ->endOfWeek(Carbon::SUNDAY);

        $previousWeek = $weekStart
            ->copy()
            ->subWeek()
            ->format('Y-m-d');

        $nextWeek = $weekStart
            ->copy()
            ->addWeek()
            ->format('Y-m-d');
        $selectedType = $request->query('type');
        $selectedFacility = $request->query('facility');

        $allFacilities = Facility::query()
            ->select([
                'id',
                'name',
                'type',
                'location',
            ])
            ->orderBy('name')
            ->get();

        $facilityTypes = $allFacilities
            ->pluck('type')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $facilities = $selectedType
            ? $allFacilities
            ->where('type', $selectedType)
            ->values()
            : $allFacilities;

        $reservations = Reservation::query()
            ->select([
                'id',
                'reservation_code',
                'user_id',
                'purpose',
                'status',
                'start_time',
                'end_time',
            ])
            ->with([
                'user:id,name',

                'facilities:id,name,type,location',
            ])
            ->whereIn('status', [
                'menunggu',
                'disetujui',
            ])
            ->where(
                'start_time',
                '<=',
                $weekEnd->copy()->endOfDay()
            )
            ->where(
                'end_time',
                '>=',
                $weekStart->copy()->startOfDay()
            )
            ->when(
                $selectedType,
                function ($query) use ($selectedType) {

                    $query->whereHas(
                        'facilities',
                        function ($facilityQuery) use ($selectedType) {

                            $facilityQuery->where(
                                'facilities.type',
                                $selectedType
                            );
                        }
                    );
                }
            )
            ->when(
                $selectedFacility,
                function ($query) use ($selectedFacility) {

                    $query->whereHas(
                        'facilities',
                        function ($facilityQuery) use ($selectedFacility) {

                            $facilityQuery->where(
                                'facilities.id',
                                $selectedFacility
                            );
                        }
                    );
                }
            )

            ->orderBy('start_time')

            ->get();

        $weekDays = collect(range(0, 6))
            ->map(function ($index) use ($weekStart) {

                $date = $weekStart->copy()->addDays($index);

                return [
                    'index' => $index,

                    'date' => $date->format('Y-m-d'),

                    'name' => $date
                        ->locale('id')
                        ->translatedFormat('l'),

                    'date_label' => $date
                        ->locale('id')
                        ->translatedFormat('j M'),

                    'is_today' => $date->isToday(),
                ];
            })
            ->toArray();

        $scheduleByDay = [];

        foreach ($reservations as $reservation) {

            // 0 = Senin, 6 = Minggu
            $dayIndex = $reservation->start_time->dayOfWeekIso - 1;

            foreach ($reservation->facilities as $facility) {

                $scheduleByDay[$dayIndex][] = [
                    'reservation_id' => $reservation->id,

                    'reservation_code' =>
                    $reservation->reservation_code,

                    'facility' =>
                    $facility->name,

                    'type' =>
                    $facility->type,

                    'start' =>
                    $reservation->start_time->format('H.i'),

                    'end' =>
                    $reservation->end_time->format('H.i'),

                    'borrower' =>
                    \Illuminate\Support\Str::title(
                        $reservation->user?->name ?? '-'
                    ),

                    'status' =>
                    $reservation->status,
                ];
            }
        }
        return view(
            'petugas.reservasi.jadwal-reservasi',
            compact(
                'weekStart',
                'weekEnd',
                'previousWeek',
                'nextWeek',

                'facilityTypes',
                'facilities',

                'selectedType',
                'selectedFacility',

                'reservations',
                'weekDays',
                'scheduleByDay',
            )
        );
    }
    public function create(Request $request)
    {
        $facility = Facility::findOrFail($request->query('facility_id'));
        $date = $request->query('date');
        $start = $request->query('start');
        $end = $request->query('end');

        return view(
            'reservations.create',
            compact('facility', 'date', 'start', 'end')
        );
    }
    public function store(Request $request)
    {
        $request->validate([
            'facility_id'          => 'required|exists:facilities,id',
            'date'                 => 'required|date|after_or_equal:today',
            'start_time'           => 'required|date_format:H:i',
            'end_time'             => 'required|date_format:H:i|after:start_time',
            'purpose'              => 'required|string|max:255',
            'activity_description' => 'nullable|string',
            'participant_count'    => 'nullable|integer|min:1',
            'document'             => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:2048',
        ]);

        $start = Carbon::parse(
            $request->date . ' ' . $request->start_time
        );

        $end = Carbon::parse(
            $request->date . ' ' . $request->end_time
        );

        $opStart = Carbon::parse(
            $request->date . ' 07:00'
        );

        $opEnd = Carbon::parse(
            $request->date . ' 20:00'
        );

        if ($start < $opStart || $end > $opEnd) {
            return back()->withInput()->withErrors([
                'time' => 'Waktu reservasi harus berada dalam jam operasional (07.00 - 20.00 WIB).'
            ]);
        }

        if ($start->minute % 30 !== 0 || $end->minute % 30 !== 0) {
            return back()->withInput()->withErrors([
                'time' => 'Waktu mulai dan selesai harus berupa kelipatan slot 30 menit (mis. 07.00, 07.30).'
            ]);
        }

        $conflict = Reservation::whereIn(
            'status',
            ['menunggu', 'disetujui']
        )
            ->whereHas('details', function ($q) use ($request) {
                $q->where(
                    'facility_id',
                    $request->facility_id
                );
            })
            ->where(function ($q) use ($start, $end) {
                $q->where('start_time', '<', $end)
                    ->where('end_time', '>', $start);
            })
            ->exists();

        if ($conflict) {
            return back()->withInput()->withErrors([
                'conflict' => 'Slot waktu pada rentang tersebut sudah dipesan oleh pengguna lain.'
            ]);
        }

        $documentPath = null;

        if ($request->hasFile('document')) {
            $documentPath = $request
                ->file('document')
                ->store('documents', 'public');
        }

        $lastCode = Reservation::orderBy(
            'id',
            'desc'
        )->value('reservation_code');

        $nextNumber = 1;

        if (
            $lastCode &&
            preg_match('/RV-(\d+)/', $lastCode, $matches)
        ) {
            $nextNumber = (int) $matches[1] + 1;
        }

        $reservationCode = 'RV-' .
            str_pad(
                $nextNumber,
                3,
                '0',
                STR_PAD_LEFT
            );

        $reservation = Reservation::create([
            'reservation_code'     => $reservationCode,
            'user_id'              => Auth::id(),
            'start_time'           => $start,
            'end_time'             => $end,
            'purpose'              => $request->purpose,
            'activity_description' => $request->activity_description,
            'participant_count'    => $request->participant_count ?? 1,
            'document'             => $documentPath,
            'status'               => 'menunggu',
        ]);

        $reservation->details()->create([
            'facility_id' => $request->facility_id,
        ]);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Pengajuan reservasi berhasil dikirim!'
            );
    }

    public function cancel(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array(
            $reservation->status,
            ['menunggu', 'disetujui']
        )) {
            return back()->withErrors([
                'cancel' => 'Reservasi ini sudah tidak bisa dibatalkan.'
            ]);
        }

        if (
            now()->addHours(24)
            ->greaterThan($reservation->start_time)
        ) {
            return back()->withErrors([
                'cancel' => 'Reservasi hanya bisa dibatalkan paling lambat 24 jam sebelum waktu mulai.'
            ]);
        }

        $reservation->update([
            'status' => 'dibatalkan'
        ]);

        return back()->with(
            'success',
            'Reservasi berhasil dibatalkan.'
        );
    }
}
