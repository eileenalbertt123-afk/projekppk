<?php

namespace App\Http\Controllers;

use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Facility;
use App\Models\Report;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index()
    {
        $totalFasilitas = Facility::count();
        $fasilitasAktif = Facility::where('status', 'tersedia')->count();
        $fasilitasPerbaikan = Facility::where('status', 'dalam_perbaikan')->count();
        $totalPengguna = User::count();
        $menungguVerifikasi = User::where('status_verifikasi', 'menunggu')->count();

        return view('admin.dashboard', compact(
            'totalFasilitas',
            'fasilitasAktif',
            'fasilitasPerbaikan',
            'totalPengguna',
            'menungguVerifikasi'
        ));
    }

    public function rekap(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;

        $rekap = Facility::withCount([
            'reservationDetails as jumlah_penggunaan' => function ($query) use ($tanggalMulai, $tanggalAkhir) {
                $query->whereHas('reservation', function ($q) use ($tanggalMulai, $tanggalAkhir) {
                    $q->where('status', 'disetujui');
                    if ($tanggalMulai) $q->whereDate('start_time', '>=', $tanggalMulai);
                    if ($tanggalAkhir) $q->whereDate('start_time', '<=', $tanggalAkhir);
                });
            }
        ])->get();

        $rekapKerusakan = Report::with(['facility', 'user'])
            ->when($tanggalMulai, fn($q) => $q->whereDate('created_at', '>=', $tanggalMulai))
            ->when($tanggalAkhir, fn($q) => $q->whereDate('created_at', '<=', $tanggalAkhir))
            ->get()
            ->groupBy(fn($report) => $report->facility_id)
            ->map(function ($reports) {
                $reportPertama = $reports->first();
                return (object) [
                    'facility_id'     => $reportPertama->facility_id,
                    'nama_fasilitas'  => $reportPertama->facility?->name ?? '-',
                    'lokasi'          => $reportPertama->facility?->location ?? '-',
                    'jumlah_kerusakan' => $reports->count(),
                    'laporan'         => $reports->values(),
                ];
            })
            ->values();

        return view('admin.rekap', compact('rekap', 'rekapKerusakan', 'tanggalMulai', 'tanggalAkhir'));
    }

    public function exportRekapExcel(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;

        $rekap = Facility::withCount([
            'reservationDetails as jumlah_penggunaan' => function ($query) use ($tanggalMulai, $tanggalAkhir) {
                $query->whereHas('reservation', function ($q) use ($tanggalMulai, $tanggalAkhir) {
                    $q->where('status', 'disetujui');
                    if ($tanggalMulai) $q->whereDate('start_time', '>=', $tanggalMulai);
                    if ($tanggalAkhir) $q->whereDate('start_time', '<=', $tanggalAkhir);
                });
            }
        ])->get();

        $data = [];
        foreach ($rekap as $fasilitas) {
            $data[] = [
                'Nama Fasilitas'  => $fasilitas->name,
                'Tipe'            => $fasilitas->type,
                'Lokasi'          => $fasilitas->location,
                'Kapasitas'       => $fasilitas->capacity,
                'Status'          => $fasilitas->status,
                'Jumlah Penggunaan' => $fasilitas->jumlah_penggunaan,
            ];
        }

        return (new FastExcel(collect($data)))->download('rekap-fasilitas.xlsx');
    }

    public function exportRekapCsv(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;

        $rekap = Facility::withCount([
            'reservationDetails as jumlah_penggunaan' => function ($query) use ($tanggalMulai, $tanggalAkhir) {
                $query->whereHas('reservation', function ($q) use ($tanggalMulai, $tanggalAkhir) {
                    $q->where('status', 'disetujui');
                    if ($tanggalMulai) $q->whereDate('start_time', '>=', $tanggalMulai);
                    if ($tanggalAkhir) $q->whereDate('start_time', '<=', $tanggalAkhir);
                });
            }
        ])->get();

        $rekapKerusakan = Report::with(['facility', 'user'])
            ->when($tanggalMulai, fn($q) => $q->whereDate('created_at', '>=', $tanggalMulai))
            ->when($tanggalAkhir, fn($q) => $q->whereDate('created_at', '<=', $tanggalAkhir))
            ->get()
            ->groupBy('facility_id')
            ->map(function ($reports) {
                $reportPertama = $reports->first();
                return [
                    'nama_fasilitas'   => $reportPertama->facility?->name ?? '-',
                    'lokasi'           => $reportPertama->facility?->location ?? '-',
                    'jumlah_kerusakan' => $reports->count(),
                ];
            })
            ->values();

        return response()->streamDownload(function () use ($rekap, $rekapKerusakan) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['REKAP PENGGUNAAN FASILITAS']);
            fputcsv($handle, ['Nama Fasilitas', 'Tipe', 'Lokasi', 'Kapasitas', 'Status', 'Jumlah Penggunaan']);
            foreach ($rekap as $fasilitas) {
                fputcsv($handle, [$fasilitas->name, $fasilitas->type, $fasilitas->location, $fasilitas->capacity, $fasilitas->status, $fasilitas->jumlah_penggunaan]);
            }

            fputcsv($handle, []);
            fputcsv($handle, ['REKAP FREKUENSI KERUSAKAN FASILITAS']);
            fputcsv($handle, ['Nama Fasilitas', 'Lokasi', 'Frekuensi Kerusakan']);
            foreach ($rekapKerusakan as $kerusakan) {
                fputcsv($handle, [$kerusakan['nama_fasilitas'], $kerusakan['lokasi'], $kerusakan['jumlah_kerusakan']]);
            }

            fclose($handle);
        }, 'rekap-fasilitas.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function exportRekapPdf(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;

        $rekap = Facility::withCount([
            'reservationDetails as jumlah_penggunaan' => function ($query) use ($tanggalMulai, $tanggalAkhir) {
                $query->whereHas('reservation', function ($q) use ($tanggalMulai, $tanggalAkhir) {
                    $q->where('status', 'disetujui');
                    if ($tanggalMulai) $q->whereDate('start_time', '>=', $tanggalMulai);
                    if ($tanggalAkhir) $q->whereDate('start_time', '<=', $tanggalAkhir);
                });
            }
        ])->get();

        $rekapKerusakan = Report::with(['facility', 'user'])
            ->when($tanggalMulai, fn($q) => $q->whereDate('created_at', '>=', $tanggalMulai))
            ->when($tanggalAkhir, fn($q) => $q->whereDate('created_at', '<=', $tanggalAkhir))
            ->get()
            ->groupBy(fn($report) => $report->facility_id)
            ->map(function ($reports) {
                $reportPertama = $reports->first();
                return (object) [
                    'facility_id'      => $reportPertama->facility_id,
                    'nama_fasilitas'   => $reportPertama->facility?->name ?? '-',
                    'lokasi'           => $reportPertama->facility?->location ?? '-',
                    'jumlah_kerusakan' => $reports->count(),
                    'laporan'          => $reports->values(),
                ];
            })
            ->values();

        $pdf = Pdf::loadView('admin.rekap-pdf', compact('rekap', 'rekapKerusakan', 'tanggalMulai', 'tanggalAkhir'));
        return $pdf->download('rekap-fasilitas.pdf');
    }

    public function fasilitas()
    {
        $fasilitas = Facility::orderBy('name')->get();
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function createFasilitas()
    {
        return view('admin.fasilitas.create');
    }

    public function storeFasilitas(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'type'        => 'required',
            'location'    => 'required',
            'capacity'    => 'required|integer',
            'status'      => 'required|in:tersedia,dalam_perbaikan,nonaktif',
            'description' => 'nullable',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $namaFoto = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $response = \Illuminate\Support\Facades\Http::withBasicAuth(
                env('CLOUDINARY_API_KEY'),
                env('CLOUDINARY_API_SECRET')
            )->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
                ->post('https://api.cloudinary.com/v1_1/' . env('CLOUDINARY_CLOUD_NAME') . '/image/upload', [
                    'folder' => 'facilities',
                ]);
            $namaFoto = $response->json()['secure_url'];
        }

        Facility::create([
            'name'        => $request->name,
            'type'        => $request->type,
            'location'    => $request->location,
            'capacity'    => $request->capacity,
            'status'      => $request->status,
            'description' => $request->description,
            'image'       => $namaFoto,
        ]);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function editFasilitas($id)
    {
        $fasilitas = Facility::findOrFail($id);
        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    public function updateFasilitas(Request $request, $id)
    {
        $fasilitas = Facility::findOrFail($id);

        $request->validate([
            'name'        => 'required',
            'type'        => 'required|in:ruangan,laboratorium,area_olahraga,peralatan_presentasi,audio_multimedia,lainnya',
            'location'    => 'required',
            'capacity'    => 'required|integer',
            'status'      => 'required|in:tersedia,dalam_perbaikan,nonaktif',
            'description' => 'nullable',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name'        => $request->name,
            'type'        => $request->type,
            'location'    => $request->location,
            'capacity'    => $request->capacity,
            'status'      => $request->status,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $response = \Illuminate\Support\Facades\Http::withBasicAuth(
                env('CLOUDINARY_API_KEY'),
                env('CLOUDINARY_API_SECRET')
            )->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
                ->post('https://api.cloudinary.com/v1_1/' . env('CLOUDINARY_CLOUD_NAME') . '/image/upload', [
                    'folder' => 'facilities',
                ]);
            $data['image'] = $response->json()['secure_url'];
        }

        $fasilitas->update($data);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function nonaktifkanFasilitas($id)
    {
        $fasilitas = Facility::findOrFail($id);
        $fasilitas->update(['status' => 'nonaktif']);
        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil dinonaktifkan.');
    }

    public function pengguna()
    {
        $pengguna = User::with('userType')->orderBy('name')->get();
        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function createPetugas()
    {
        return view('admin.pengguna.create-petugas');
    }

    public function storePetugas(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'               => $request->name,
            'email'              => $request->email,
            'password'           => Hash::make($request->password),
            'role'               => 'petugas',
            'status_akun'        => 'aktif',
            'status_verifikasi'  => 'diverifikasi',
        ]);

        return redirect()->route('admin.pengguna.index')->with('success', 'Akun petugas berhasil dibuat.');
    }

    public function updateStatusPengguna(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);
        $request->validate(['status_akun' => 'required|in:aktif,nonaktif']);
        $pengguna->update(['status_akun' => $request->status_akun]);
        return redirect()->route('admin.pengguna.index')->with('success', 'Status akun berhasil diperbarui.');
    }

    public function verifikasiPengguna($id)
    {
        $pengguna = User::findOrFail($id);
        $pengguna->update(['status_verifikasi' => 'diverifikasi', 'status_akun' => 'aktif']);
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil diverifikasi.');
    }

    public function tolakPengguna($id)
    {
        $pengguna = User::findOrFail($id);
        $pengguna->update(['status_verifikasi' => 'ditolak', 'status_akun' => 'nonaktif']);
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna ditolak.');
    }
}
