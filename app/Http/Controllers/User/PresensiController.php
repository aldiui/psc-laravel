<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\Presensi;
use App\Traits\ApiResponder;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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
        $cekPresensi = Presensi::where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d', strtotime('-1 day')))->first();
        if ($cekPresensi && $cekPresensi->jam_keluar == null) {
            $presensi = $cekPresensi;
        } else {
            $presensi = Presensi::where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
        }

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
                    'tugas' => $request->tugas,
                    'catatan' => $request->catatan,
                ]);

                return $this->successResponse($presensi, 'Presensi Keluar berhasil.');
            }
        }

        return view('user.presensi.index', compact('presensi', 'pengaturan'));
    }

    public function rekapPresensi(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if ($request->mode == "datatable") {
            $presensis = Presensi::where('user_id', Auth::user()->id)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->latest()->get();
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
                ->addColumn('tugas_catatan', function ($presensi) {
                    if ($presensi->tugas) {
                        $tugas = stringToArray($presensi->tugas);
                        $catatan = $presensi->catatan;

                        $output = '<div><ul style="padding-left: 20px; margin:0%">';

                        foreach ($tugas as $task) {
                            $output .= "<li>$task</li>";
                        }

                        if ($catatan) {
                            $output .= "<li>$catatan</li>";
                        }

                        $output .= '</ul></div>';

                        return $output;
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['presensi_masuk', 'presensi_keluar', 'tgl', 'tugas_catatan'])
                ->make(true);
        }

        if ($request->mode == "pdf") {
            $presensis = Presensi::where('user_id', Auth::user()->id)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->oldest()->get();
            $bulanTahun = Carbon::create($tahun, $bulan, 1)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F Y');

            $pdf = PDF::loadView('user.presensi.pdf', [
                'presensis' => $presensis,
                'bulanTahun' => $bulanTahun,
            ]);

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('legal', 'potrat');

            $namaFile = 'laporan_rekap_presensi_' . $bulan . '_' . $tahun . '.pdf';

            return $pdf->stream($namaFile);
        }
    }
}
