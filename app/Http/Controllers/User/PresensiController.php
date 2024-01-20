<?php

namespace App\Http\Controllers\User;

use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PresensiController extends Controller
{
    use ApiResponder;
    
    public function index()
    {
        return view('user.presensi.index');
    }
}