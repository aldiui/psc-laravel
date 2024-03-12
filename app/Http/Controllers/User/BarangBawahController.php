<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BarangBawah;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class BarangBawahController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $barangs = BarangBawah::with(['barang.unit'])->get();
            return $this->successResponse($barangs, 'Data Barang ditemukan.');
        }
    }
}