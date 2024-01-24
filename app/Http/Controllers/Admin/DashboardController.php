<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Unit;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalUnit' => Unit::count(),
            'totalKategori' => Kategori::count(),
            'totalBarang' => Barang::count(),
            'totalKaryawan' => User::count(),
        ];

        return view('admin.dashboard.index', $data);
    }
}
