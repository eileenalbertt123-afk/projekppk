<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;

class UpdateReservationStatus extends Command
{
    protected $signature = 'reservation:update-status';

    protected $description = 'Update reservation status automatically';


    public function handle()
    {
        $now = Carbon::now();


        // Reservasi disetujui dan waktu selesai sudah lewat
        $completedReservations = Reservation::where('status', 'disetujui')
            ->where('end_time', '<=', $now)
            ->get();


        foreach ($completedReservations as $reservation) {

            // Update status reservasi
            $reservation->update([
                'status' => 'selesai'
            ]);

            // Simpan riwayat perubahan status
            $reservation->statusHistories()->create([
                'status' => 'selesai',
                'reason' => 'Status otomatis karena waktu peminjaman telah selesai',
                'changed_by' => null
            ]);
        }

        // Reservasi menunggu tetapi tanggal sudah lewat
        $expiredReservations = Reservation::where('status', 'menunggu')
            ->where('start_time', '<=', $now)
            ->get();

        foreach ($expiredReservations as $reservation) {

            $reservation->update([
                'status' => 'dibatalkan'
            ]);

            $reservation->statusHistories()->create([
                'status' => 'dibatalkan',
                'reason_category' => 'otomatis_sistem',
                'reason' => 'Status otomatis karena tanggal peminjaman telah lewat',
                'changed_by' => null
            ]);
        }

        $this->info('Reservation status updated successfully.');
    }
}