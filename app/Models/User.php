<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    const ROLE_ADMIN = 'admin';
    const ROLE_PETUGAS = 'petugas';
    const ROLE_DOSEN = 'dosen_pembimbing';
    const ROLE_KAPRODI = 'kaprodi';

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isPetugas()
    {
        return $this->role === self::ROLE_PETUGAS;
    }

    public function isDosen()
    {
        return $this->role === self::ROLE_DOSEN;
    }

    public function isKaprodi()
    {
        return $this->role === self::ROLE_KAPRODI;
    }

    public function getRoleLabelAttribute()
    {
        return match ($this->role) {
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_PETUGAS => 'Petugas',
            self::ROLE_DOSEN => 'Dosen Pembimbing',
            self::ROLE_KAPRODI => 'Kaprodi',
            default => 'Unknown Role',
        };
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
