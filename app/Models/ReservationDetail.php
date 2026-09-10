<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationDetail extends Model
{
    protected $fillable = ['reservation_id', 'facility_id'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}