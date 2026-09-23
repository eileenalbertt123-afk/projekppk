<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Facility;

class ReportController extends Controller
{
    public function dashboard()
    {
        /*
        |--------------------------------------------------------------------------
        | PERIODE
        |--------------------------------------------------------------------------
        */

        $now = now();

        $startMonth = $now->copy()->startOfMonth();
        $endMonth = $now->copy()->endOfMonth();

        $startLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endLastMonth = $now->copy()->subMonth()->endOfMonth();


        /*
        |--------------------------------------------------------------------------
        | STATUS SUMMARY BULAN INI
        |--------------------------------------------------------------------------
        */

        $countsThisMonth = Report::query()
            ->whereBetween('created_at', [$startMonth, $endMonth])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');


        /*
        |--------------------------------------------------------------------------
        | KPI TOTAL LAPORAN
        |--------------------------------------------------------------------------
        */

        $totalLaporan = Report::count();

        $laporanBaruCount = (int) $countsThisMonth->get('baru', 0);


        /*
        |--------------------------------------------------------------------------
        | GROWTH BULAN INI VS BULAN LALU
        |--------------------------------------------------------------------------
        */

        $totalThisMonth = $countsThisMonth->sum();

        $totalLastMonth = Report::query()
            ->whereBetween('created_at', [
                $startLastMonth,
                $endLastMonth,
            ])
            ->count();

        $laporanGrowth = null;

        if ($totalLastMonth > 0) {
            $laporanGrowth = round(
                (($totalThisMonth - $totalLastMonth)
                    / $totalLastMonth) * 100,
                1
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RATA-RATA WAKTU PERBAIKAN BULAN INI
        |--------------------------------------------------------------------------
        |
        | Pakai resolved_at karena itu yang ada di tabel reports.
        |
        */

        $avgSeconds = Report::query()
            ->where('status', 'selesai')
            ->whereNotNull('resolved_at')
            ->whereBetween('resolved_at', [
                $startMonth,
                $endMonth,
            ])
            ->selectRaw(
                'AVG(TIMESTAMPDIFF(SECOND, created_at, resolved_at)) as avg_seconds'
            )
            ->value('avg_seconds');

        $rataRataPerbaikan = $avgSeconds
            ? round($avgSeconds / 3600, 1)
            : 0;


        /*
        |--------------------------------------------------------------------------
        | RATA-RATA BULAN LALU
        |--------------------------------------------------------------------------
        */

        $avgSecondsLastMonth = Report::query()
            ->where('status', 'selesai')
            ->whereNotNull('resolved_at')
            ->whereBetween('resolved_at', [
                $startLastMonth,
                $endLastMonth,
            ])
            ->selectRaw(
                'AVG(TIMESTAMPDIFF(SECOND, created_at, resolved_at)) as avg_seconds'
            )
            ->value('avg_seconds');


        $perbaikanComparison = null;

        if ($avgSecondsLastMonth !== null && $avgSeconds !== null) {
            $perbaikanComparison = round(
                ($avgSeconds - $avgSecondsLastMonth) / 3600,
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
                'facility:id,name',
            ])
            ->whereIn('status', [
                'baru',
                'diproses',
            ])
            ->orderBy('created_at', 'desc')
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
                'value' => (int) $countsThisMonth->get('baru', 0),
                'desc' => 'Menunggu verifikasi',
            ],
            [
                'key' => 'diproses',
                'label' => 'DIPROSES',
                'value' => (int) $countsThisMonth->get('diproses', 0),
                'desc' => 'Sedang ditangani',
            ],
            [
                'key' => 'selesai',
                'label' => 'SELESAI',
                'value' => (int) $countsThisMonth->get('selesai', 0),
                'desc' => 'Perbaikan selesai',
            ],
            [
                'key' => 'ditolak',
                'label' => 'DITOLAK',
                'value' => (int) $countsThisMonth->get('ditolak', 0),
                'desc' => 'Tidak dapat ditindak',
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | FASILITAS DALAM PERBAIKAN
        |--------------------------------------------------------------------------
        */

        $facilitiesUnderRepair = Facility::query()
            ->where('status', 'dalam_perbaikan')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'status',
            ]);


        return view(
            'petugas.laporan.dashboard',
            compact(
                'totalLaporan',
                'laporanBaruCount',
                'laporanGrowth',
                'rataRataPerbaikan',
                'perbaikanComparison',
                'incomingReports',
                'statusSummary',
                'facilitiesUnderRepair'
            )
        );
    }

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | KPI STATUS (1 QUERY SAJA)
        |--------------------------------------------------------------------------
        */

        $statusCounts = Report::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');


        $totalLaporan = $statusCounts->sum();

        $baruCount = $statusCounts->get('baru', 0);

        $diprosesCount = $statusCounts->get('diproses', 0);

        $selesaiCount = $statusCounts->get('selesai', 0);

        $ditolakCount = $statusCounts->get('ditolak', 0);



        /*
        |--------------------------------------------------------------------------
        | QUERY DAFTAR LAPORAN
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



        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = strtoupper(trim($request->search));


            $query->where(function ($q) use ($search) {


                /*
                |--------------------------------------------------------------------------
                | SEARCH ID LAPORAN
                |--------------------------------------------------------------------------
                */

                $idSearch = str_replace('LP', '', $search);


                if (is_numeric($idSearch)) {

                    $q->where(
                        'id',
                        intval($idSearch)
                    );

                }



                /*
                |--------------------------------------------------------------------------
                | SEARCH USER
                |--------------------------------------------------------------------------
                */

                $q->orWhereHas('user', function ($user) use ($search) {

                    $user->where(
                        'name',
                        'like',
                        "%{$search}%"
                    );

                });



                /*
                |--------------------------------------------------------------------------
                | SEARCH FACILITY
                |--------------------------------------------------------------------------
                */

                $q->orWhereHas('facility', function ($facility) use ($search) {

                    $facility->where(
                        'name',
                        'like',
                        "%{$search}%"
                    );

                });


            });

        }



        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('status')
            && $request->status !== 'semua',

            function ($q) use ($request) {

                $q->where(
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
            && $request->category !== 'semua',

            function ($q) use ($request) {

                $q->where(
                    'category',
                    $request->category
                );

            }
        );



        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $reports = $query
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        $statusCount = Facility::selectRaw(
        'status, COUNT(*) as total'
        )
        ->groupBy('status')
        ->pluck('total','status');


        $totalFasilitas = $statusCount->sum();

        $tersediaCount = $statusCount->get('tersedia',0);

        $maintenanceCount = $statusCount->get('dalam_perbaikan',0);

        $nonaktifCount = $statusCount->get('nonaktif',0);



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

public function store(Request $request)
{
    dd([
        'masuk_store' => true,
        'data' => $request->all(),
        'user' => auth()->id(),
    ]);


    Report::create([
        'user_id' => auth()->id(),
        'facility_id' => $request->facility_id,
        'category' => $request->category,
        'description' => $request->description,
        'status' => 'baru',
    ]);
}
}