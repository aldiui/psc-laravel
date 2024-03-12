<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $notifikasis = Notifikasi::whereMonth('created_at', date('m'))->where('target_id', Auth::user()->id)->latest()->get();
            return view('user.notifikasi.index', compact('notifikasis'));
        }
    }
}
