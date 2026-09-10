<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = ['name', 'type', 'location', 'capacity', 'description', 'status', 'image'];
}