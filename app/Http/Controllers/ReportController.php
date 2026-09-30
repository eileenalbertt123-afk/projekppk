<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Report;
use App\Models\Facility;
use App\Models\Reservation;
use App\Models\ReportStatusHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD LAPORAN
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $now = now();


        $startMonth = $now->copy()->startOfMonth();
        $endMonth = $now->copy()->endOfMonth();


        /*
        |--------------------------------------------------------------------------
        | STATUS SUMMARY
        |--------------------------------------------------------------------------
        */

        $statusCounts = Report::query()
            ->whereBetween('created_at', [
                $startMonth,
                $endMonth
            ])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');



        /*
        |--------------------------------------------------------------------------
        | TOTAL LAPORAN
        |--------------------------------------------------------------------------
        */

        $totalLaporan = Report::count();


        $laporanBaruCount =
            $statusCounts->get('baru', 0);


        /*
        |--------------------------------------------------------------------------
        | GROWTH BULAN LALU
        |--------------------------------------------------------------------------
        */

        $startLastMonth = $now->copy()
            ->subMonth()
            ->startOfMonth();


        $endLastMonth = $now->copy()
            ->subMonth()
            ->endOfMonth();


        $totalLastMonth = Report::query()
            ->whereBetween('created_at', [
                $startLastMonth,
                $endLastMonth
            ])
            ->count();


        $laporanGrowth = null;


        if ($totalLastMonth > 0) {

            $laporanGrowth = round(
                (
                    ($totalLaporan - $totalLastMonth)
                    /
                    $totalLastMonth
                ) * 100,
                1
            );

        }
        
            /*
        |--------------------------------------------------------------------------
        | INCOMING REPORTS
        |--------------------------------------------------------------------------
        */

        $incomingReports = Report::query()
            ->with([
                'user:id,name',
                'facility:id,name'
            ])
            ->whereIn('status', [
                'baru',
                'diproses'
            ])
            ->latest('created_at')
            ->limit(3)
            ->get();



        /*
        |--------------------------------------------------------------------------
        | THIS MONTH SUMMARY
        |--------------------------------------------------------------------------
        */

        $statusSummary = [

            [
                'key' => 'baru',
                'label' => 'BARU',
                'value' => $statusCounts->get('baru',0),
                'desc' => 'Menunggu verifikasi'
            ],

            [
                'key' => 'diproses',
                'label' => 'DIPROSES',
                'value' => $statusCounts->get('diproses',0),
                'desc' => 'Sedang ditangani'
            ],

            [
                'key' => 'selesai',
                'label' => 'SELESAI',
                'value' => $statusCounts->get('selesai',0),
                'desc' => 'Perbaikan selesai'
            ],

            [
                'key' => 'ditolak',
                'label' => 'DITOLAK',
                'value' => $statusCounts->get('ditolak',0),
                'desc' => 'Tidak dapat ditindak'
            ],

        ];



        /*
        |--------------------------------------------------------------------------
        | FASILITAS DALAM PERBAIKAN
        |--------------------------------------------------------------------------
        */

        $facilitiesUnderRepair = Facility::query()
            ->where(
                'status',
                'dalam_perbaikan'
            )
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'status'
            ]);



        return view(
            'petugas.laporan.dashboard',
            compact(
                'totalLaporan',
                'laporanBaruCount',
                'laporanGrowth',
                'incomingReports',
                'statusSummary',
                'facilitiesUnderRepair'
            )
        );
    }




    /*
    |--------------------------------------------------------------------------
    | DAFTAR LAPORAN
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | KPI
        |--------------------------------------------------------------------------
        */

        $statusCounts = Report::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total','status');


        $totalLaporan =
            $statusCounts->sum();


        $baruCount =
            $statusCounts->get('baru',0);


        $diprosesCount =
            $statusCounts->get('diproses',0);


        $selesaiCount =
            $statusCounts->get('selesai',0);


        $ditolakCount =
            $statusCounts->get('ditolak',0);



        /*
        |--------------------------------------------------------------------------
        | QUERY LAPORAN
        |--------------------------------------------------------------------------
        */

        $query = Report::query()
            ->select([
                'id',
                'report_code',
                'user_id',
                'facility_id',
                'category',
                'status',
                'created_at',
            ])
            ->with([
                'user:id,name',
                'facility:id,name',
            ]);

            // FILTER FACILITY
            $query->when(
                $request->filled('facility_id'),
                function ($q) use ($request) {

                    $q->where(
                        'facility_id',
                        $request->facility_id
                    );

                }
            );

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('search'),
            function ($query) use ($request) {

                $search =
                    strtoupper(
                        trim($request->search)
                    );


                $idSearch =
                    str_replace(
                        'LP-',
                        '',
                        $search
                    );


                $query->where(function($q) use ($search,$idSearch){

                    if(is_numeric($idSearch)){

                        $q->where(
                            'id',
                            intval($idSearch)
                        );

                    }


                    $q->orWhere(
                        'report_code',
                        'like',
                        "%{$search}%"
                    );


                    $q->orWhereHas(
                        'user',
                        function($user) use ($search){

                            $user->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );

                        }
                    );


                    $q->orWhereHas(
                        'facility',
                        function($facility) use ($search){

                            $facility->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );

                        }
                    );


                });

            }
        );



        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('status')
            &&
            $request->status !== 'semua',

            function($query) use ($request){

                $query->where(
                    'status',
                    $request->status
                );

            }
        );



        /*
        |--------------------------------------------------------------------------
        | FILTER CATEGORY
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('category')
            &&
            $request->category !== 'semua',

            function($query) use ($request){

                $query->where(
                    'category',
                    $request->category
                );

            }
        );



        $reports = $query
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();



        return view(
            'petugas.laporan.daftar-laporan',
            compact(
                'reports',
                'totalLaporan',
                'baruCount',
                'diprosesCount',
                'selesaiCount',
                'ditolakCount'
            )
        );

    }

    /*
    |--------------------------------------------------------------------------
    | CREATE LAPORAN
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

        $request->validate([

            'facility_id'
                => 'required',

            'category'
                => 'required',

            'description'
                => 'required',

        ]);



        Report::create([

            'user_id'
                => $request->user()->id,

            'facility_id'
                => $request->facility_id,

            'category'
                => $request->category,

            'description'
                => $request->description,

            'status'
                => 'baru',

        ]);



        return back()
            ->with(
                'success',
                'Laporan berhasil dibuat'
            );

    }

    public function show(Report $report)
    {
        $report->load([
            'user',
            'facility',
        ]);

        $affectedReservations = [];

        if ($report->facility) {

            $affectedReservations = Reservation::whereHas('reservationDetail', function ($query) use ($report) {
                    $query->where('facility_id', $report->facility->id);
                })
                ->where('status', 'disetujui')
                ->whereDate('start_time', '>=', now())
                ->get()
                ->map(function ($reservation) {

                    return [
                        'id' => $reservation->reservation_code ?? $reservation->id,
                        'status' => 'Approved',
                        'date' => $reservation->start_time,
                        'time' => $reservation->start_time . ' - ' . $reservation->end_time,
                    ];

                });

        }
        $rejectedHistory = $report->statusHistories()
            ->with('changedBy')
            ->where('status', 'ditolak')
            ->latest('created_at')
            ->first();

        $completedHistory = $report->statusHistories()
            ->with('changedBy')
            ->where('status', 'selesai')
            ->latest('created_at')
            ->first();
        
        $isRepairReady = false;

        if ($report->status === 'diproses') {
            $isRepairReady = true;
        }

        return view('petugas.laporan.detail', compact(
            'report',
            'rejectedHistory',
            'completedHistory',
            'isRepairReady',
            'affectedReservations'
        ));
    }

    public function process(Report $report)
    {
        abort_unless($report->status === 'baru', 422);

        DB::transaction(function () use ($report) {

            $affected = Report::whereKey($report->id)
                ->where('status', 'baru')
                ->update([
                    'status' => 'diproses',
                ]);

            abort_unless($affected === 1, 422);


            // ubah fasilitas menjadi dalam perbaikan
            $report->facility?->update([
                'status' => 'dalam_perbaikan',
            ]);


            ReportStatusHistory::create([
                'report_id' => $report->id,
                'status' => 'diproses',
                'changed_by' => Auth::id(),
                'reason' => null,
            ]);

        });


        return redirect()
            ->route('petugas.laporan.detail', $report)
            ->with('success', 'Laporan mulai diproses.');
    }

    public function startRepair(Report $report)
    {
        abort_unless($report->status === 'diproses', 422);

        DB::transaction(function () use ($report) {

            $report->facility?->update([
                'status' => 'dalam_perbaikan',
            ]);
        });

        return redirect()
            ->route('petugas.laporan.detail', $report)
            ->with('success', 'Fasilitas telah ditandai dalam perbaikan.');
    }

    public function reject(Request $request, Report $report)
    {
        abort_unless($report->status === 'baru', 422);

        $validated = $request->validate([
            'rejection_category' => [
                'required',
                'in:bukti_tidak_memadai,laporan_tidak_valid,duplikat_laporan,bukan_kerusakan_fasilitas,informasi_tidak_lengkap,fasilitas_tidak_sesuai,lainnya',
            ],
            'rejection_reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        DB::transaction(function () use ($report, $validated) {

            $report->update([
                'status' => 'ditolak',
            ]);

            ReportStatusHistory::create([
                'report_id' => $report->id,
                'status' => 'ditolak',
                'changed_by' => Auth::id(),
                'reason_category' => $validated['rejection_category'],
                'reason' => $validated['rejection_reason'],
            ]);
        });

        return redirect()
            ->route('petugas.laporan.detail', $report)
            ->with('success', 'Laporan berhasil ditolak.');
    }

    public function complete(Request $request, Report $report)
    {
        abort_unless($report->status === 'diproses', 422);

        $validated = $request->validate([
            'completion_note' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        DB::transaction(function () use ($report, $validated) {

            $report->update([
                'status' => 'selesai',
            ]);

            $report->facility?->update([
                'status' => 'Tersedia',
            ]);

            ReportStatusHistory::create([
                'report_id' => $report->id,
                'status' => 'selesai',
                'changed_by' => Auth::id(),
                'reason' => $validated['completion_note'] ?? null,
            ]);
        });

        return redirect()
            ->route('petugas.laporan.detail', $report)
            ->with('success', 'Laporan berhasil diselesaikan.');
    }
}