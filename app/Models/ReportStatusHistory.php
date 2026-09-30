<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportStatusHistory extends Model
{
    const UPDATED_AT = null;
    
    protected $fillable = [
        'report_id',
        'status',
        'changed_by',
        'reason_category',
        'reason',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}