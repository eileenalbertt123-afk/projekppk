<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrableUser extends Model
{
    protected $fillable = [
        'identifier',
        'name',
        'user_type_id',
        'is_registered',
    ];

    protected $casts = [
        'is_registered' => 'boolean',
    ];

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }
}