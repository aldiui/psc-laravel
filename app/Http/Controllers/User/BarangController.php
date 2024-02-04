<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $barangs = Barang::with('unit', 'kategori')->get();
            return $this->successResponse($barangs, 'Data barang ditemukan.');
        }
    }
}
