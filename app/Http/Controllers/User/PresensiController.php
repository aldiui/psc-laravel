<?php

namespace App\Http\Controllers\User;

use App\Models\Presensi;
use App\Models\Pengaturan;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    use ApiResponder;
    
    public function index()
    {
        $presensi = Presensi::where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
        $pengaturan = Pengaturan::find(1);
        return view('user.presensi.index', compact('presensi', 'pengaturan'));
    }
}