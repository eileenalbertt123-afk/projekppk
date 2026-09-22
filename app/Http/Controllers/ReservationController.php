<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Menampilkan Halaman Form Pengajuan Reservasi (Checkout)
     */
    public function create(Request $request)
    {
        $facility = Facility::findOrFail($request->query('facility_id'));
        $date     = $request->query('date');
        $start    = $request->query('start');
        $end      = $request->query('end');

        return view('reservations.create', compact('facility', 'date', 'start', 'end'));
    }

    /**
     * Menyimpan Pengajuan Reservasi ke Database dengan Validasi Server
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'facility_id'          => 'required|exists:facilities,id',
            'date'                 => 'required|date|after_or_equal:today',
            'start_time'           => 'required|date_format:H:i',
            'end_time'             => 'required|date_format:H:i|after:start_time',
            'purpose'              => 'required|string|max:255',
            'activity_description' => 'nullable|string', // Opsional
            'participant_count'    => 'nullable|integer|min:1',
            'document'             => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:2048',
        ]);

        $start = Carbon::parse($request->date . ' ' . $request->start_time);
        $end   = Carbon::parse($request->date . ' ' . $request->end_time);

        // 2. Validasi Server: Jam Operasional (07.00 - 20.00 WIB)
        $opStart = Carbon::parse($request->date . ' 07:00');
        $opEnd   = Carbon::parse($request->date . ' 20:00');

        if ($start < $opStart || $end > $opEnd) {
            return back()->withInput()->withErrors([
                'time' => 'Waktu reservasi harus berada dalam jam operasional (07.00 - 20.00 WIB).'
            ]);
        }

        // 3. Validasi Server: Kelipatan Slot 30 Menit
        if ($start->minute % 30 !== 0 || $end->minute % 30 !== 0) {
            return back()->withInput()->withErrors([
                'time' => 'Waktu mulai dan selesai harus berupa kelipatan slot 30 menit (mis. 07.00, 07.30).'
            ]);
        }

        // 4. Validasi Bentrok Jadwal di Server
        $conflict = Reservation::whereIn('status', ['menunggu', 'disetujui'])
            ->whereHas('details', function ($q) use ($request) {
                $q->where('facility_id', $request->facility_id);
            })
            ->where(function ($q) use ($start, $end) {
                $q->where('start_time', '<', $end)
                ->where('end_time', '>', $start);
            })->exists();

        if ($conflict) {
            return back()->withInput()->withErrors([
                'conflict' => 'Slot waktu pada rentang tersebut sudah dipesan oleh pengguna lain.'
            ]);
        }

        // 5. Upload Dokumen Permohonan (Opsional)
        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('documents', 'public');
        }

        // 6. Simpan ke Database
        $lastCode = Reservation::orderBy('id', 'desc')->value('reservation_code');
        $nextNumber = 1;
        if ($lastCode && preg_match('/RV-(\d+)/', $lastCode, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        }
        $reservationCode = 'RV-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

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

        return redirect()->route('dashboard')->with('success', 'Pengajuan reservasi berhasil dikirim!');
    }
    // Membatalkan reservasi (maksimal H-24 jam sebelum waktu mulai)
    public function cancel(Reservation $reservation)
    {
        // Hanya pemilik reservasi yang boleh membatalkan
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        // Hanya reservasi yang masih menunggu/disetujui yang bisa dibatalkan
        if (!in_array($reservation->status, ['menunggu', 'disetujui'])) {
            return back()->withErrors([
                'cancel' => 'Reservasi ini sudah tidak bisa dibatalkan.'
            ]);
        }

        // Batas waktu: minimal 24 jam sebelum waktu mulai
        if (now()->addHours(24)->greaterThan($reservation->start_time)) {
            return back()->withErrors([
                'cancel' => 'Reservasi hanya bisa dibatalkan paling lambat 24 jam sebelum waktu mulai.'
            ]);
        }

        $reservation->update(['status' => 'dibatalkan']);

        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}