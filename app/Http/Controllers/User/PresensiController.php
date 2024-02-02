<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\Presensi;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
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
            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                    'location' => 'required',
                ]);

                if ($validator->fails()) {
                    return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
                }

                $getLocation = explode(",", $request->location);
                $calculateDistance = calculateDistance($getLocation[0], $getLocation[1], $pengaturan->latitude, $pengaturan->longitude);

                if ($calculateDistance >= $pengaturan->radius) {
                    if ($request->alasan == null) {
                        $selisihJarak = calculateSelisihJarak($calculateDistance - $pengaturan->radius);
                        return $this->errorResponse(null, 'Jarak lebih dari ' . $selisihJarak . ' dari radius lokasi. Mohon isi alasan untuk melanjukan presensi', 422);
                    }
                }

                if (!$presensi) {
                    $presensi = Presensi::create([
                        'user_id' => Auth::user()->id,
                        'tanggal' => date('Y-m-d'),
                        'lokasi_in' => $request->location,
                        'clock_in' => date('H:i:s'),
                        'alasan_in' => $request->alasan ?? null,
                    ]);

                    return $this->successResponse($presensi, 'Presensi Masuk berhasil.');
                }

                $presensi->update([
                    'lokasi_out' => $request->location,
                    'clock_out' => date('H:i:s'),
                    'alasan_out' => $request->alasan ?? null,
                    'catatan' => $request->catatan,
                ]);

                return $this->successResponse($presensi, 'Presensi Keluar berhasil.');
            }

            if ($request->isMethod('get')) {
                $bulan = $request->input("bulan");
                $tahun = $request->input("tahun");

                $presensis = Presensi::where('user_id', Auth::user()->id)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->latest()->get();
                if ($request->input("mode") == "datatable") {
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
                        ->addColumn('tgl', function ($row) {
                            return formatTanggal($row->tanggal);
                        })
                        ->addIndexColumn()
                        ->rawColumns(['presensi_masuk', 'presensi_keluar', 'tgl'])
                        ->make(true);
                }
            }
        }

        return view('user.presensi.index', compact('presensi', 'pengaturan'));
    }
}