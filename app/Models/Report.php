<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'facility_id',
        'category',
        'description',
        'image_path',
        'status',
    ];

    /**
     * Relasi: Laporan ini dibuat oleh User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Laporan ini ditujukan untuk Fasilitas/Ruangan tertentu
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}