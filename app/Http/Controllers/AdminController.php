<?php

namespace App\Http\Controllers;

use App\Models\Facility;

class AdminController extends Controller
{
    public function index()
    {
        $totalFasilitas = Facility::count();

        $fasilitasAktif = Facility::where('status', 'aktif')->count();

        return view('admin.dashboard', compact(
            'totalFasilitas',
            'fasilitasAktif'
        ));
    }

    public function rekap()
    {
        $rekap = Facility::withCount([
            'reservationDetails as jumlah_penggunaan' => function ($query) {
                $query->whereHas('reservation', function ($q) {
                    $q->where('status', 'disetujui');
                });
            }
        ])->get();
        return view('admin.rekap', compact('rekap'));
    }
}