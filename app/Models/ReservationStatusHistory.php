<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationStatusHistory extends Model
{
    protected $table = 'reservation_status_histories';

    public $timestamps = false; // hanya ada created_at, tidak ada updated_at

    protected $fillable = [
        'reservation_id',
        'status',
        'reason_category',
        'reason',
        'changed_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'status' => 'string', // opsional, karena enum
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}