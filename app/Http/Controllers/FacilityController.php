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
    $date = $request->input('date', Carbon::today('Asia/Jakarta')->toDateString());

    $slots = $this->getSlotsForDate($facility, $date);

    $days = collect(range(0, 6))->map(function ($i) use ($date) {
        $d = Carbon::today('Asia/Jakarta')->addDays($i);
        return [
            'key' => $d->toDateString(),
            'day' => $d->translatedFormat('D'),
            'date' => $d->day,
            'active' => $d->toDateString() === $date,
        ];
    });

    return view('facilities.availability', compact('facility', 'slots', 'date', 'days'));
}

    public function getSlotsForDate(Facility $facility, $date)
    {
        $start = \Carbon\Carbon::parse($date . ' 07:00', 'Asia/Jakarta');
        $end   = \Carbon\Carbon::parse($date . ' 20:00', 'Asia/Jakarta');
        $now   = \Carbon\Carbon::now('Asia/Jakarta');

        // Ambil reservasi yang aktif pada tanggal tersebut, lewat relasi reservation_detail
        $booked = \App\Models\ReservationDetail::where('facility_id', $facility->id)
            ->whereHas('reservation', function ($q) use ($date) {
                $q->whereIn('status', ['menunggu', 'disetujui'])
                ->whereDate('start_time', $date);
            })
            ->with('reservation')
            ->get();

        $slots = [];

        while ($start < $end) {
            $slotEnd = $start->copy()->addMinutes(30);

            // Cek apakah slot bentrok dengan reservasi yang ada
            $isBooked = $booked->contains(function ($b) use ($start, $slotEnd) {
                $resStart = \Carbon\Carbon::parse($b->reservation->start_time, 'Asia/Jakarta');
                $resEnd   = \Carbon\Carbon::parse($b->reservation->end_time, 'Asia/Jakarta');
                return ($start < $resEnd && $slotEnd > $resStart);
            });

            $isPast = $start->lt($now);

            $slots[] = [
                'start'   => $start->format('H:i'),
                'end'     => $slotEnd->format('H:i'),
                'status'  => $isBooked ? 'terisi' : 'tersedia',
                'is_past' => $isPast,
            ];

            $start = $slotEnd;
        }

        return $slots;
    }
}