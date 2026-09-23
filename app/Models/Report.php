<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'report_code',
        'facility_id',
        'category',
        'description',
        'image_path',
        'image',
        'status',
        'resolution_note',
        'resolved_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();


        static::creating(function ($report) {

            $lastId = self::max('id') + 1;


            $report->report_code =
                'LP-' . str_pad(
                    $lastId,
                    3,
                    '0',
                    STR_PAD_LEFT
                );

        });
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

}