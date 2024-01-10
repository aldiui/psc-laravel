<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

}