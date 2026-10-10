<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Report;
use App\Models\Reservation;
use App\Models\ReportStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function dashboard()
    {
        $now = now();
        $startMonth = $now->copy()->startOfMonth();
        $endMonth = $now->copy()->endOfMonth();

        $statusCounts = Report::query()
            ->whereBetween('created_at', [$startMonth, $endMonth])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalLaporan = Report::count();
        $laporanBaruCount = $statusCounts->get('baru', 0);
        $laporanTerlambatCount = Report::query()
            ->where('status', 'baru')
            ->where('created_at', '<=', now()->subWeeks(3))
            ->count();

        $startLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endLastMonth = $now->copy()->subMonth()->endOfMonth();
        $totalLastMonth = Report::query()
            ->whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->count();

        $laporanGrowth = null;
        if ($totalLastMonth > 0) {
            $laporanGrowth = round((($totalLaporan - $totalLastMonth) / $totalLastMonth) * 100, 1);
        }

        $incomingReports = Report::query()
            ->with(['user:id,name', 'facility:id,name'])
            ->whereIn('status', ['baru', 'diproses'])
            ->latest('created_at')
            ->limit(3)
            ->get();

        $statusSummary = [
            ['key' => 'baru',     'label' => 'BARU',     'value' => $statusCounts->get('baru', 0),     'desc' => 'Menunggu verifikasi'],
            ['key' => 'diproses', 'label' => 'DIPROSES', 'value' => $statusCounts->get('diproses', 0), 'desc' => 'Sedang ditangani'],
            ['key' => 'selesai',  'label' => 'SELESAI',  'value' => $statusCounts->get('selesai', 0),  'desc' => 'Perbaikan selesai'],
            ['key' => 'ditolak',  'label' => 'DITOLAK',  'value' => $statusCounts->get('ditolak', 0),  'desc' => 'Tidak dapat ditindak'],
        ];

        $facilitiesUnderRepair = Facility::query()
            ->where('status', 'dalam_perbaikan')
            ->orderBy('name')
            ->get(['id', 'name', 'status']);

        return view('petugas.laporan.dashboard', compact(
            'totalLaporan',
            'laporanBaruCount',
            'laporanTerlambatCount',
            'laporanGrowth',
            'incomingReports',
            'statusSummary',
            'facilitiesUnderRepair'
        ));
    }

    public function index(Request $request)
    {
        $statusCounts = Report::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalLaporan = $statusCounts->sum();
        $baruCount    = $statusCounts->get('baru', 0);
        $diprosesCount = $statusCounts->get('diproses', 0);
        $selesaiCount  = $statusCounts->get('selesai', 0);
        $ditolakCount  = $statusCounts->get('ditolak', 0);

        $query = Report::query()
            ->select(['id', 'report_code', 'user_id', 'facility_id', 'category', 'status', 'created_at'])
            ->with(['user:id,name', 'facility:id,name']);

        $query->when($request->filled('facility_id'), fn($q) => $q->where('facility_id', $request->facility_id));

        $query->when($request->filled('search'), function ($query) use ($request) {
            $search   = strtoupper(trim($request->search));
            $idSearch = str_replace('LP-', '', $search);
            $query->where(function ($q) use ($search, $idSearch) {
                if (is_numeric($idSearch)) $q->where('id', intval($idSearch));
                $q->orWhere('report_code', 'like', "%{$search}%");
                $q->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
                $q->orWhereHas('facility', fn($f) => $f->where('name', 'like', "%{$search}%"));
            });
        });

        $query->when(
            $request->filled('status') && $request->status !== 'semua',
            fn($q) => $q->where('status', $request->status)
        );

        $query->when($request->boolean('terlambat'), fn($q) => $q->where('status', 'baru')->where('created_at', '<=', now()->subWeeks(3)));

        $query->when(
            $request->filled('category') && $request->category !== 'semua',
            fn($q) => $q->where('category', $request->category)
        );

        $sort = $request->get('sort', 'terbaru');
        $sort === 'terlama' ? $query->orderBy('created_at', 'asc') : $query->orderBy('created_at', 'desc');

        $reports = $query->paginate(10)->withQueryString();

        return view('petugas.laporan.daftar-laporan', compact(
            'reports',
            'totalLaporan',
            'baruCount',
            'diprosesCount',
            'selesaiCount',
            'ditolakCount'
        ));
    }

    public function userIndex()
    {
        $reports = Report::where('user_id', Auth::id())
            ->with('facility')
            ->latest()
            ->get();

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        $facilities = Facility::all();
        return view('reports.create', compact('facilities'));
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'category'    => 'required|string|max:100',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $response = \Illuminate\Support\Facades\Http::withBasicAuth(
                env('CLOUDINARY_API_KEY'),
                env('CLOUDINARY_API_SECRET')
            )->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
                ->post('https://api.cloudinary.com/v1_1/' . env('CLOUDINARY_CLOUD_NAME') . '/image/upload', [
                    'folder' => 'reports',
                ]);
            $imagePath = $response->json()['secure_url'];
        }

        Report::create([
            'user_id'     => Auth::id(),
            'facility_id' => $request->facility_id,
            'category'    => $request->category,
            'description' => $request->description,
            'image_path'  => $imagePath,
            'status'      => 'baru',
        ]);

        return redirect()->route('reports.index')->with('success', 'Laporan kerusakan berhasil dikirim!');
    }

    public function userShow(Report $report)
    {
        $report->load(['user', 'facility']);
        return view('reports.show', [
            'report'   => $report,
            'facility' => $report->facility,
            'user'     => $report->user,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'facility_id' => 'required',
            'category'    => 'required',
            'description' => 'required',
        ]);

        Report::create([
            'user_id'     => $request->user()->id,
            'facility_id' => $request->facility_id,
            'category'    => $request->category,
            'description' => $request->description,
            'status'      => 'baru',
        ]);

        return back()->with('success', 'Laporan berhasil dibuat');
    }

    public function show(Report $report)
    {
        $report->load(['user', 'facility']);

        $affectedReservations = [];
        if ($report->facility) {
            $affectedReservations = Reservation::whereHas('reservationDetail', function ($query) use ($report) {
                $query->where('facility_id', $report->facility->id);
            })
                ->where('status', 'disetujui')
                ->whereDate('start_time', '>=', now())
                ->get()
                ->map(fn($reservation) => [
                    'reservation_id' => $reservation->id,
                    'id'     => $reservation->reservation_code ?? $reservation->id,
                    'status' => 'Approved',
                    'date'   => $reservation->start_time,
                    'time'   => $reservation->start_time . ' - ' . $reservation->end_time,
                ]);
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

        $isRepairReady = $report->status === 'diproses';

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
            $affected = Report::whereKey($report->id)->where('status', 'baru')->update(['status' => 'diproses']);
            abort_unless($affected === 1, 422);
            $report->facility?->update(['status' => 'dalam_perbaikan']);
            ReportStatusHistory::create([
                'report_id'  => $report->id,
                'status'     => 'diproses',
                'changed_by' => Auth::id(),
                'reason'     => null,
            ]);
        });

        return redirect()->route('petugas.laporan.detail', $report)->with('success', 'Laporan mulai diproses.');
    }

    public function startRepair(Report $report)
    {
        abort_unless($report->status === 'diproses', 422);

        DB::transaction(function () use ($report) {
            $report->facility?->update(['status' => 'dalam_perbaikan']);
        });

        return redirect()->route('petugas.laporan.detail', $report)->with('success', 'Fasilitas telah ditandai dalam perbaikan.');
    }

    public function reject(Request $request, Report $report)
    {
        abort_unless($report->status === 'baru', 422);

        $validated = $request->validate([
            'rejection_category' => ['required', 'in:bukti_tidak_memadai,laporan_tidak_valid,duplikat_laporan,bukan_kerusakan_fasilitas,informasi_tidak_lengkap,fasilitas_tidak_sesuai,lainnya'],
            'rejection_reason'   => ['required', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($report, $validated) {
            $report->update(['status' => 'ditolak']);
            ReportStatusHistory::create([
                'report_id'       => $report->id,
                'status'          => 'ditolak',
                'changed_by'      => Auth::id(),
                'reason_category' => $validated['rejection_category'],
                'reason'          => $validated['rejection_reason'],
            ]);
        });

        return redirect()->route('petugas.laporan.detail', $report)->with('success', 'Laporan berhasil ditolak.');
    }

    public function complete(Request $request, Report $report)
    {
        abort_unless($report->status === 'diproses', 422);

        $validated = $request->validate([
            'completion_note' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($report, $validated) {
            $report->update(['status' => 'selesai']);
            $report->facility?->update(['status' => 'Tersedia']);
            ReportStatusHistory::create([
                'report_id'  => $report->id,
                'status'     => 'selesai',
                'changed_by' => Auth::id(),
                'reason'     => $validated['completion_note'] ?? null,
            ]);
        });

        return redirect()->route('petugas.laporan.detail', $report)->with('success', 'Laporan berhasil diselesaikan.');
    }

    public function image(Report $report)
    {
        $user = Auth::user();
        if (!$user) abort(401);
        if ($user->role === 'pengguna' && $report->user_id !== $user->id) abort(403);
        if (!in_array($user->role, ['pengguna', 'petugas', 'admin'])) abort(403);
        if (!$report->image_path) abort(404);
        return redirect($report->image_path);
    }
}
