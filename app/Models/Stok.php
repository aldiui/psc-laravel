<?php

namespace App\Models;

use App\Models\User;
use App\Models\DetailStok;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stok extends Model
{
    use HasFactory;
    
    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailStoks()
    {
        return $this->hasMany(DetailStok::class);
    }
    
}