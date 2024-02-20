<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $cekPresensi = Presensi::where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d', strtotime('-1 day')))->first();
        if ($cekPresensi->jam_keluar == null) {
            $presensi = $cekPresensi;
        } else {
            $presensi = Presensi::where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
        }

        $presensis = Presensi::where('user_id', Auth::user()->id)->latest()->limit(5)->get();
        return view('user.home.index', compact('presensi', 'presensis'));
    }
}
