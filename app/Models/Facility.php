<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ReservationDetail;

class Facility extends Model
{
    public $timestamps = false;
    
    protected $fillable = ['name', 'type', 'location', 'capacity', 'description', 'equipment', 'status', 'image'];

    public function reservationDetails()
    {
        return $this->hasMany(ReservationDetail::class);
    }
}