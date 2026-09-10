<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\ReservationDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $query = Facility::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('capacity')) {
            $query->where('capacity', '>=', $request->capacity);
        }

        $facilities = $query->get();
        $types = Facility::select('type')->distinct()->pluck('type');
        $locations = Facility::select('location')->distinct()->orderBy('location')->pluck('location');

        return view('facilities.index', compact('facilities', 'types', 'locations'));
    }

    public function availability(Request $request, Facility $facility)
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        // Generate semua slot 30 menit dari jam 07:00 - 20:00
        $slots = [];
        $start = Carbon::parse($date . ' 07:00');
        $end = Carbon::parse($date . ' 20:00');

        while ($start < $end) {
            $slotEnd = $start->copy()->addMinutes(30);
            $slots[] = [
                'start' => $start->format('H:i'),
                'end' => $slotEnd->format('H:i'),
                'status' => 'tersedia',
            ];
            $start = $slotEnd;
        }

        // Ambil reservasi yang disetujui / menunggu di fasilitas & tanggal ini
        $booked = ReservationDetail::where('facility_id', $facility->id)
            ->whereHas('reservation', function ($q) use ($date) {
                $q->whereIn('status', ['disetujui', 'menunggu'])
                ->whereDate('start_time', $date);
            })
            ->with('reservation')
            ->get();

        // Cek bentrok jam pada setiap slot
        foreach ($slots as &$slot) {
            $slotStart = Carbon::parse($date . ' ' . $slot['start']);
            $slotEnd = Carbon::parse($date . ' ' . $slot['end']);

            foreach ($booked as $b) {
                // 2. Parse waktu dari DB ke Carbon agar komparasi tanggal & jam akurat
                $resStart = Carbon::parse($b->reservation->start_time);
                $resEnd = Carbon::parse($b->reservation->end_time);

                if ($slotStart < $resEnd && $slotEnd > $resStart) {
                    $slot['status'] = 'tidak tersedia';
                    break;
                }
            }
        }

        return view('facilities.availability', compact('facility', 'slots', 'date'));
    }
}