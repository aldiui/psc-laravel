<?php

namespace App\Models;

use App\Models\Stok;
use App\Models\Barang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailStok extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stok()
    {
        return $this->belongsTo(Stok::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}