<?php

namespace App\Http\Controllers;

use App\Exports\FacilityRecapExport;
use App\Models\Facility;
use App\Models\Report;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index()
    {
        $totalFasilitas = Facility::count();

        $fasilitasAktif = Facility::where(
            'status',
            'tersedia'
        )->count();

        $fasilitasPerbaikan = Facility::where(
            'status',
            'dalam_perbaikan'
        )->count();

        $totalPengguna = User::count();

        $menungguVerifikasi = User::where(
            'status_verifikasi',
            'menunggu'
        )->count();

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

        /*
         * Rekap penggunaan fasilitas
         */
        $rekap = Facility::withCount([
            'reservationDetails as jumlah_penggunaan' => function ($query) use (
                $tanggalMulai,
                $tanggalAkhir
            ) {
                $query->whereHas('reservation', function ($q) use (
                    $tanggalMulai,
                    $tanggalAkhir
                ) {
                    $q->where('status', 'disetujui');

                    if ($tanggalMulai) {
                        $q->whereDate(
                            'start_time',
                            '>=',
                            $tanggalMulai
                        );
                    }

                    if ($tanggalAkhir) {
                        $q->whereDate(
                            'start_time',
                            '<=',
                            $tanggalAkhir
                        );
                    }
                });
            }
        ])->get();

        /*
         * Rekap frekuensi laporan kerusakan/masalah fasilitas
         *
         * Semua kategori laporan dihitung.
         */
        $rekapKerusakan = Report::with('facility')
            ->when($tanggalMulai, function ($query) use ($tanggalMulai) {
                $query->whereDate(
                    'created_at',
                    '>=',
                    $tanggalMulai
                );
            })
            ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                $query->whereDate(
                    'created_at',
                    '<=',
                    $tanggalAkhir
                );
            })
            ->get()
            ->groupBy(function ($report) {
                return $report->facility_id;
            })
            ->map(function ($reports) {
                $reportPertama = $reports->first();

                return (object) [
                    'facility_id' => $reportPertama->facility_id,
                    'nama_fasilitas' =>
                        $reportPertama->facility?->name ?? '-',
                    'lokasi' =>
                        $reportPertama->facility?->location ?? '-',
                    'jumlah_kerusakan' => $reports->count(),
                ];
            })
            ->values();

        return view('admin.rekap', compact(
            'rekap',
            'rekapKerusakan',
            'tanggalMulai',
            'tanggalAkhir'
        ));
    }

    public function exportRekapExcel(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;

        return Excel::download(
            new FacilityRecapExport(
                $tanggalMulai,
                $tanggalAkhir
            ),
            'rekap-fasilitas.xlsx'
        );
    }

    public function exportRekapCsv(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;

        /*
         * Rekap penggunaan fasilitas
         */
        $rekap = Facility::withCount([
            'reservationDetails as jumlah_penggunaan' => function ($query) use (
                $tanggalMulai,
                $tanggalAkhir
            ) {
                $query->whereHas('reservation', function ($q) use (
                    $tanggalMulai,
                    $tanggalAkhir
                ) {
                    $q->where('status', 'disetujui');

                    if ($tanggalMulai) {
                        $q->whereDate(
                            'start_time',
                            '>=',
                            $tanggalMulai
                        );
                    }

                    if ($tanggalAkhir) {
                        $q->whereDate(
                            'start_time',
                            '<=',
                            $tanggalAkhir
                        );
                    }
                });
            }
        ])->get();

        /*
         * Rekap frekuensi laporan kerusakan/masalah fasilitas
         *
         * Semua kategori laporan dihitung.
         */
        $rekapKerusakan = Report::with('facility')
            ->when($tanggalMulai, function ($query) use ($tanggalMulai) {
                $query->whereDate(
                    'created_at',
                    '>=',
                    $tanggalMulai
                );
            })
            ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                $query->whereDate(
                    'created_at',
                    '<=',
                    $tanggalAkhir
                );
            })
            ->get()
            ->groupBy('facility_id')
            ->map(function ($reports) {
                $reportPertama = $reports->first();

                return [
                    'nama_fasilitas' =>
                        $reportPertama->facility?->name ?? '-',
                    'lokasi' =>
                        $reportPertama->facility?->location ?? '-',
                    'jumlah_kerusakan' => $reports->count(),
                ];
            })
            ->values();

        return response()->streamDownload(
            function () use ($rekap, $rekapKerusakan) {

                $handle = fopen('php://output', 'w');

                /*
                 * BOM supaya karakter Indonesia terbaca
                 * dengan baik ketika dibuka di Excel.
                 */
                fwrite($handle, "\xEF\xBB\xBF");

                /*
                 * =========================
                 * REKAP PENGGUNAAN
                 * =========================
                 */

                fputcsv($handle, [
                    'REKAP PENGGUNAAN FASILITAS'
                ]);

                fputcsv($handle, [
                    'Nama Fasilitas',
                    'Tipe',
                    'Lokasi',
                    'Kapasitas',
                    'Status',
                    'Jumlah Penggunaan',
                ]);

                foreach ($rekap as $fasilitas) {
                    fputcsv($handle, [
                        $fasilitas->name,
                        $fasilitas->type,
                        $fasilitas->location,
                        $fasilitas->capacity,
                        $fasilitas->status,
                        $fasilitas->jumlah_penggunaan,
                    ]);
                }

                /*
                 * Baris kosong sebagai pemisah
                 */
                fputcsv($handle, []);

                /*
                 * =========================
                 * REKAP KERUSAKAN
                 * =========================
                 */

                fputcsv($handle, [
                    'REKAP FREKUENSI KERUSAKAN FASILITAS'
                ]);

                fputcsv($handle, [
                    'Nama Fasilitas',
                    'Lokasi',
                    'Frekuensi Kerusakan',
                ]);

                foreach ($rekapKerusakan as $kerusakan) {
                    fputcsv($handle, [
                        $kerusakan['nama_fasilitas'],
                        $kerusakan['lokasi'],
                        $kerusakan['jumlah_kerusakan'],
                    ]);
                }

                fclose($handle);
            },
            'rekap-fasilitas.csv',
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]
        );
    }

    public function exportRekapPdf(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;

        /*
         * Rekap penggunaan fasilitas
         */
        $rekap = Facility::withCount([
            'reservationDetails as jumlah_penggunaan' => function ($query) use (
                $tanggalMulai,
                $tanggalAkhir
            ) {
                $query->whereHas('reservation', function ($q) use (
                    $tanggalMulai,
                    $tanggalAkhir
                ) {
                    $q->where('status', 'disetujui');

                    if ($tanggalMulai) {
                        $q->whereDate(
                            'start_time',
                            '>=',
                            $tanggalMulai
                        );
                    }

                    if ($tanggalAkhir) {
                        $q->whereDate(
                            'start_time',
                            '<=',
                            $tanggalAkhir
                        );
                    }
                });
            }
        ])->get();

        /*
         * Rekap frekuensi laporan kerusakan/masalah fasilitas
         *
         * Semua kategori laporan dihitung.
         */
        $rekapKerusakan = Report::with('facility')
            ->when($tanggalMulai, function ($query) use ($tanggalMulai) {
                $query->whereDate(
                    'created_at',
                    '>=',
                    $tanggalMulai
                );
            })
            ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                $query->whereDate(
                    'created_at',
                    '<=',
                    $tanggalAkhir
                );
            })
            ->get()
            ->groupBy(function ($report) {
                return $report->facility_id;
            })
            ->map(function ($reports) {
                $reportPertama = $reports->first();

                return (object) [
                    'facility_id' => $reportPertama->facility_id,
                    'nama_fasilitas' =>
                        $reportPertama->facility?->name ?? '-',
                    'lokasi' =>
                        $reportPertama->facility?->location ?? '-',
                    'jumlah_kerusakan' => $reports->count(),
                ];
            })
            ->values();

        $pdf = Pdf::loadView(
            'admin.rekap-pdf',
            compact(
                'rekap',
                'rekapKerusakan',
                'tanggalMulai',
                'tanggalAkhir'
            )
        );

        return $pdf->download('rekap-fasilitas.pdf');
    }

    public function fasilitas()
    {
        $fasilitas = Facility::orderBy('name')->get();

        return view(
            'admin.fasilitas.index',
            compact('fasilitas')
        );
    }

    public function createFasilitas()
    {
        return view('admin.fasilitas.create');
    }

    public function storeFasilitas(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'location' => 'required',
            'capacity' => 'required|integer',
            'status' => 'required|in:tersedia,dalam_perbaikan,nonaktif',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $namaFoto = null;

        if ($request->hasFile('image')) {
            $namaFoto = $request
                ->file('image')
                ->store('facilities', 'public');
        }

        Facility::create([
            'name' => $request->name,
            'type' => $request->type,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'status' => $request->status,
            'description' => $request->description,
            'image' => $namaFoto,
        ]);

        return redirect()
            ->route('admin.facilities.index')
            ->with(
                'success',
                'Fasilitas berhasil ditambahkan.'
            );
    }

    public function editFasilitas($id)
    {
        $fasilitas = Facility::findOrFail($id);

        return view(
            'admin.fasilitas.edit',
            compact('fasilitas')
        );
    }

    public function updateFasilitas(
        Request $request,
        $id
    ) {
        $fasilitas = Facility::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'type' => 'required|in:ruangan,laboratorium,area_olahraga,peralatan_presentasi,audio_multimedia,lainnya',
            'location' => 'required',
            'capacity' => 'required|integer',
            'status' => 'required|in:tersedia,dalam_perbaikan,nonaktif',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'type' => $request->type,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'status' => $request->status,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('facilities', 'public');
        }

        $fasilitas->update($data);

        return redirect()
            ->route('admin.facilities.index')
            ->with(
                'success',
                'Fasilitas berhasil diperbarui.'
            );
    }

    public function nonaktifkanFasilitas($id)
    {
        $fasilitas = Facility::findOrFail($id);

        $fasilitas->update([
            'status' => 'nonaktif',
        ]);

        return redirect()
            ->route('admin.facilities.index')
            ->with(
                'success',
                'Fasilitas berhasil dinonaktifkan.'
            );
    }

    public function pengguna()
    {
        $pengguna = User::with('userType')
            ->orderBy('name')
            ->get();

        return view(
            'admin.pengguna.index',
            compact('pengguna')
        );
    }

    public function updateStatusPengguna(
        Request $request,
        $id
    ) {
        $pengguna = User::findOrFail($id);

        $request->validate([
            'status_akun' => 'required|in:aktif,nonaktif',
        ]);

        $pengguna->update([
            'status_akun' => $request->status_akun,
        ]);

        return redirect()
            ->route('admin.pengguna.index')
            ->with(
                'success',
                'Status akun berhasil diperbarui.'
            );
    }

    public function verifikasiPengguna($id)
    {
        $pengguna = User::findOrFail($id);

        $pengguna->update([
            'status_verifikasi' => 'diverifikasi',
            'status_akun' => 'aktif',
        ]);

        return redirect()
            ->route('admin.pengguna.index')
            ->with(
                'success',
                'Pengguna berhasil diverifikasi.'
            );
    }

    public function tolakPengguna($id)
    {
        $pengguna = User::findOrFail($id);

        $pengguna->update([
            'status_verifikasi' => 'ditolak',
            'status_akun' => 'nonaktif',
        ]);

        return redirect()
            ->route('admin.pengguna.index')
            ->with(
                'success',
                'Pengguna ditolak.'
            );
    }
}