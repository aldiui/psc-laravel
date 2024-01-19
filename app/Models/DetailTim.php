<?php

namespace App\Models;

use App\Models\Tim;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailTim extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
