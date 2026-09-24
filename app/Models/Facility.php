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

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function activeReport()
    {
        return $this->hasOne(Report::class)
            ->whereIn('status', [
                'baru',
                'diproses'
            ])
            ->latestOfMany();
    }
    public function getTypeLabelAttribute()
    {
        return match($this->type){

            'ruangan'
                => 'Ruangan',

            'laboratorium'
                => 'Laboratorium',

            'area_olahraga'
                => 'Area Olahraga',

            'peralatan_presentasi'
                => 'Peralatan Presentasi',

            'audio_multimedia'
                => 'Audio Multimedia',

            default
                => 'Lainnya',

        };
    }



    public function show(Facility $facility)
    {
        $facility->load([
            'reports',
            'activeReport'
        ]);


        return view(
            'petugas.fasilitas.detail',
            compact('facility')
        );
    }
}