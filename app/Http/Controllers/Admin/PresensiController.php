<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tanggal = $request->input("tanggal");
            $presensis = Presensi::with('user')->where('tanggal', $tanggal)->latest()->get();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($presensis)
                    ->addColumn('nama', function ($presensi) {
                        return $presensi->user->nama;
                    })
                    ->addColumn('img', function ($presensi) {
                        return '<img src="/storage/img/karyawan/' . $presensi->user->image . '" width="100px" alt="">';
                    })
                    ->addColumn('presensi_masuk', function ($presensi) {
                        if ($presensi->clock_in) {
                            return '
                            <div>
                                <div class="mb-2">
                                    <span class="badge badge-success"><i class="far fa-clock"></i> ' . $presensi->clock_in . '</span>
                                </div>
                                <div class="mb-2">' . ($presensi->alasan_in ? "<span class='text-danger font-weight-bold'><i class='fas fa-map-marker-alt mr-1'></i> Diluar Radius </span>" : "<span class='text-success font-weight-bold'><i class='fas fa-map-marker-alt mr-1'></i> Dalam Radius </span>") . '</div>
                                <div class="mb-2">' . ($presensi->alasan_in ? "<span>Keterangan : " . $presensi->alasan_in . "</span>" : "") . '</div>
                            </div>';
                        } else {
                            return '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum Presensi</span>';
                        }
                    })
                    ->addColumn('presensi_keluar', function ($presensi) {
                        if ($presensi->clock_out) {
                            return '
                            <div>
                                <div class="mb-2">
                                    <span class="badge badge-success"><i class="far fa-clock"></i> ' . $presensi->clock_out . '</span>
                                </div>
                                <div class="mb-2">' . ($presensi->alasan_out ? "<span class='text-danger font-weight-bold'><i class='fas fa-map-marker-alt mr-1'></i> Diluar Radius </span>" : "<span class='text-success font-weight-bold'><i class='fas fa-map-marker-alt mr-1'></i> Dalam Radius </span>") . '</div>
                                <div class="mb-2">' . ($presensi->alasan_out ? "<span>Keterangan : " . $presensi->alasan_out . "</span>" : "") . '</div>
                            </div>';
                        } else {
                            return '<span class="badge badge-danger"><i class="fas fa-times-circle mr-1"></i> Belum Presensi</span>';
                        }
                    })
                    ->addIndexColumn()
                    ->rawColumns(['nama', 'img', 'presensi_masuk', 'presensi_keluar'])
                    ->make(true);
            }
        }

        return view('admin.presensi.index');
    }
}
