<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'location',
        'capacity',
        'description',
        'equipment',
        'image',
        'status',
    ];

    protected $casts = [
        'equipment' => 'array',
        'capacity' => 'integer',
    ];

    public function reservationDetails()
    {
        return $this->hasMany(ReservationDetail::class);
    }

    // tambah shortcut ke reservations
    public function reservations()
    {
        return $this->belongsToMany(
            Reservation::class,
            'reservation_detail',
            'facility_id',
            'reservation_id'
        );
    }
}