<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalFasilitas = Facility::count();

        $fasilitasAktif = Facility::where('status', 'tersedia')->count();

        return view('admin.dashboard', compact(
            'totalFasilitas',
            'fasilitasAktif'
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

                    if ($tanggalMulai) {
                        $q->whereDate('start_time', '>=', $tanggalMulai);
                    }

                    if ($tanggalAkhir) {
                        $q->whereDate('start_time', '<=', $tanggalAkhir);
                    }
                });
            }
        ])->get();

        return view('admin.rekap', compact(
            'rekap',
            'tanggalMulai',
            'tanggalAkhir'
        ));
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
            'name' => 'required',
            'type' => 'required',
            'location' => 'required',
            'capacity' => 'required|integer',
            'status' => 'required|in:tersedia,dalam_perbaikan,nonaktif',
            'description' => 'nullable',
        ]);

        Facility::create([
            'name' => $request->name,
            'type' => $request->type,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
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
            'name' => 'required',
            'type' => 'required|in:ruangan,laboratorium,area_olahraga,peralatan_presentasi,audio_multimedia,lainnya',
            'location' => 'required',
            'capacity' => 'required|integer',
            'status' => 'required|in:tersedia,dalam_perbaikan,nonaktif',
            'description' => 'nullable',
        ]);

        $fasilitas->update([
            'name' => $request->name,
            'type' => $request->type,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function nonaktifkanFasilitas($id)
    {   
        $fasilitas = Facility::findOrFail($id);

        $fasilitas->update([
            'status' => 'nonaktif',
        ]);

        return redirect()
            ->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil dinonaktifkan.');
    }

    public function pengguna()
    {
        $pengguna = User::with('userType')
            ->orderBy('name')
            ->get();

        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function updateStatusPengguna(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);

        $request->validate([
            'status_akun' => 'required|in:aktif,nonaktif',
        ]);

        $pengguna->update([
            'status_akun' => $request->status_akun,
        ]);

        return redirect()
            ->route('admin.pengguna.index')
            ->with('success', 'Status akun berhasil diperbarui.');
    }
}