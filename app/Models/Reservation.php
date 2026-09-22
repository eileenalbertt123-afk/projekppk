<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'reservation_code',
        'user_id',
        'purpose',
        'activity_description',
        'participant_count',
        'document',
        'status',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(ReservationDetail::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(
            ReservationStatusHistory::class,
            'reservation_id'
        );
    }

    public function facilities()
    {
        return $this->belongsToMany(
            Facility::class,
            'reservation_detail',
            'reservation_id',
            'facility_id'
        );
    }

}