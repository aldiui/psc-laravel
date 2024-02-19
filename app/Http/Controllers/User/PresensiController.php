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
                        'lokasi_masuk' => $request->location,
                        'jam_masuk' => date('H:i:s'),
                        'alasan_masuk' => $request->alasan ?? null,
                    ]);

                    return $this->successResponse($presensi, 'Presensi Masuk berhasil.');
                }

                $presensi->update([
                    'lokasi_keluar' => $request->location,
                    'jam_keluar' => date('H:i:s'),
                    'alasan_keluar' => $request->alasan ?? null,
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
                        ->addColumn('presensi_masuk', function ($presensi) {
                            return generatePresensiColumn($presensi, 'masuk');
                        })
                        ->addColumn('presensi_keluar', function ($presensi) {
                            return generatePresensiColumn($presensi, 'keluar');
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
