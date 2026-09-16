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
        return $this->belongsTo(UserType::class);
    }

    // Pengecekan Role Email Kampus
    public function getRoleTypeAttribute()
    {
        $email = $this->email;

        if ($email === 'admin@undip.ac.id') {
            return 'admin';
        } elseif (str_ends_with($email, '@students.undip.ac.id')) {
            return 'mahasiswa';
        } elseif (str_ends_with($email, '@lecturer.undip.ac.id')) {
            return 'dosen';
        } elseif (str_ends_with($email, '@worker.undip.ac.id')) {
            return 'petugas';
        }

        return 'user';
    }

    public function isAdmin() { return $this->role_type === 'admin'; }
    public function isMahasiswa() { return $this->role_type === 'mahasiswa'; }
    public function isDosen() { return $this->role_type === 'dosen'; }
    public function isPetugas() { return $this->role_type === 'petugas'; }
}