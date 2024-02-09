<?php

namespace App\Models;

use App\Models\DetailStok;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailStoks()
    {
        return $this->hasMany(DetailStok::class);
    }

    public function approval()
    {
        return $this->belongsTo(User::class, 'approval_id');
    }
}
