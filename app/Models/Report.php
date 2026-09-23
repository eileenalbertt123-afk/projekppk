<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string|null $report_code
 * @property int $user_id
 * @property int $facility_id
 */
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

        /** @var \App\Models\Report $report */
        static::created(function ($report) {

            $report->update([
                'report_code' => 'LP-' . str_pad(
                    $report->id,
                    3,
                    '0',
                    STR_PAD_LEFT
                ),
            ]);

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