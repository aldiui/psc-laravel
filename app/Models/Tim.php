<?php

namespace App\Models;

use App\Models\DetailTim;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tim extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function detailTims() 
    {
        return $this->hasMany(DetailTim::class);
    }
}