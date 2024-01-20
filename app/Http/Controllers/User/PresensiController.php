<?php

namespace App\Http\Controllers\User;

use App\Models\Pengaturan;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PresensiController extends Controller
{
    use ApiResponder;
    
    public function index()
    {
        $pengaturan = Pengaturan::find(1);
        return view('user.presensi.index', compact('pengaturan'));
    }
}