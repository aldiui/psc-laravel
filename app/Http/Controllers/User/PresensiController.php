<?php

namespace App\Http\Controllers\User;

use DataTables;
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

        if ($request->ajax()) {
            $bulan = $request->input("bulan");
            $tahun = $request->input("tahun");
            
            $presensis = Presensi::where('user_id', Auth::user()->id)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->latest()->get();
            if($request->input("mode") == "datatable"){
                return DataTables::of($presensis)
                ->addColumn('presensi_masuk', function ($row) {
                    if ($row->clock_in) {
                        return '
                            <div>
                                <div class="mb-2">
                                    <span class="badge badge-success"><i class="far fa-clock"></i> ' . $row->clock_in . '</span>
                                </div>
                                <div class="mb-2">' . ($row->alasan_in ? "<span class='text-danger font-weight-bold'><i class='fas fa-map-marker-alt mr-1'></i> Diluar Radius </span>" : "<span class='text-success font-weight-bold'><i class='fas fa-map-marker-alt mr-1'></i> Dalam Radius </span>") . '</div>
                                <div class="mb-2">' . ($row->alasan_in ? "<span>Keterangan : " . $row->alasan_in . "</span>" : "") . '</div>
                            </div>';
                    } else {
                        return '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum Presensi</span>';
                    }
                })                
                ->addColumn('presensi_keluar', function ($row) {
                    if ($row->clock_out) {
                        return '
                            <div>
                                <div class="mb-2">
                                    <span class="badge badge-success"><i class="far fa-clock"></i> ' . $row->clock_out . '</span>
                                </div>
                                <div class="mb-2">' . ($row->alasan_out ? "<span class='text-danger font-weight-bold'><i class='fas fa-map-marker-alt mr-1'></i> Diluar Radius </span>" : "<span class='text-success font-weight-bold'><i class='fas fa-map-marker-alt mr-1'></i> Dalam Radius </span>") . '</div>
                                <div class="mb-2">' . ($row->alasan_out ? "<span>Keterangan : " . $row->alasan_out . "</span>" : "") . '</div>
                            </div>';
                    } else {
                        return '<span class="badge badge-danger"><i class="fas fa-times-circle mr-1"></i> Belum Presensi</span>';
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['presensi_masuk', 'presensi_keluar'])
                ->make(true);
            }
        }
        
        return view('user.presensi.index', compact('presensi', 'pengaturan'));
    }
}