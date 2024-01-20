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
                return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
            }
            
            if(!$presensi){
                $presensi = Presensi::create([
                    'user_id' => Auth::user()->id,
                    'tanggal' => date('Y-m-d'),
                    'lokasi_in' => $request->location,
                    'clock_in' => date('H:i:s'),
                ]);

                return $this->successResponse($presensi, 'Presensi Masuk berhasil.');
            }

            $presensi->update([
                'lokasi_out' => $request->location,
                'clock_out' => date('H:i:s'),
            ]);

            return $this->successResponse($presensi, 'Presensi Keluar berhasil.');
        }
        
        return view('user.presensi.index', compact('presensi', 'pengaturan'));
    }
}