<?php

namespace App\Models;

use App\Models\Izin;
use App\Models\Stok;
use App\Models\Presensi;
use App\Models\DetailTim;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function detailTims()
    {
        return $this->hasMany(DetailTim::class);
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