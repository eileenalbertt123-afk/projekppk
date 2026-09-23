<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'identifier',
    'password',
    'role',
    'status_akun',
    'user_type_id',
])]

#[Hidden([
    'password',
    'remember_token',
])]

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }

    /**
     * Mengecek role utama pengguna.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPengguna()
    {
        return $this->role === 'pengguna';
    }

    public function isPetugas()
    {
        return $this->role === 'petugas';
    }

    /**
     * Mengecek tipe pengguna.
     */
    public function isMahasiswa()
    {
        return $this->user_type_id === 1;
    }

    public function isDosen()
    {
        return $this->user_type_id === 2;
    }

    public function isTendik()
    {
        return $this->user_type_id === 3;
    }
}