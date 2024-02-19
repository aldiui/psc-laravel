<?php

namespace App\Models;

use App\Models\Izin;
use App\Models\Presensi;
use App\Models\Stok;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function stoks()
    {
        return $this->hasMany(Stok::class);
    }

    public function presensis()
    {
        return $this->hasMany(Presensi::class);
    }

    public function izins()
    {
        return $this->hasMany(Izin::class);
    }

}
