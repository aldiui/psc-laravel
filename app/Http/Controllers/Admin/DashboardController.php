<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use App\Models\User;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalUnit' => Unit::count(),
            'totalKategori' => Kategori::count(),
            'totalBarang' => Barang::count(),
            'totalKaryawan' => User::count()
        ];

        return view('admin.dashboard.index', $data);
    }
}