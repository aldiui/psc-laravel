<?php

namespace App\Http\Controllers\User;

use App\Models\Presensi;
use App\Models\Pengaturan;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PresensiController extends Controller
{
    use ApiResponder;
    
    public function index(Request $request)
    {
        $pengaturan = Pengaturan::find(1);
        $presensi = Presensi::where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
        
        if($request->isMethod("post")){
            $validator = Validator::make($request->all(), [
                'location' => 'required',        
            ]);

            if ($validator->fails()) {
                return $this->respondValidationError($validator->errors()->first());
            }
            
            if(!$presensi){
                
            }
        }
        
        return view('user.presensi.index', compact('presensi', 'pengaturan'));
    }
}