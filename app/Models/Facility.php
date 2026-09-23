<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'type',
        'location',
        'capacity',
        'description',
        'equipment', // ← missing di fillable
        'image',
        'status',
    ];

    protected $casts = [
        'equipment' => 'array', // ← kolom equipment isinya JSON array
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