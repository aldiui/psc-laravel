<?php

namespace App\Http\Controllers\Admin;

use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    use ApiResponder;
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $presensis = Presensi::all();
            if($request->input("mode") == "datatable"){
                return DataTables::of($presensis)->make(true);
            }

            return $this->successResponse($presensis, 'Data Presensi ditemukan.'); 
        }
    
        return view('admin.presensi.index');
    }
}