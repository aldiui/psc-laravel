<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\User;
use App\Traits\ApiResponder;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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
                        return '<img src="' . ($presensi->user->image != 'default.png' ? '/storage/img/karyawan/' . $presensi->user->image : '/images/default.png') . '" width="100px" alt="">';
                    })
                    ->addColumn('presensi_masuk', function ($presensi) {
                        return generatePresensiColumn($presensi, 'masuk');
                    })
                    ->addColumn('presensi_keluar', function ($presensi) {
                        return generatePresensiColumn($presensi, 'keluar');
                    })
                    ->addIndexColumn()
                    ->rawColumns(['nama', 'img', 'presensi_masuk', 'presensi_keluar'])
                    ->make(true);
            }
        }

        return view('admin.presensi.index');
    }

    public function rekapPresensi(Request $request)
    {
        $bulan = $request->input("bulan");
        $tahun = $request->input("tahun");
        if ($request->ajax()) {
            $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
            $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();

            $karyawans = User::where('role', 'user')->get();

            $dates = Carbon::parse($startDate);
            $labels = [];

            while ($dates <= $endDate) {
                $dateString = $dates->toDateString();
                $labels[] = formatTanggal($dateString, 'd');
                $dates->addDay();
            }

            foreach ($karyawans as $karyawan) {
                $presensi = [];

                for ($day = 1; $day <= $endDate->daysInMonth; $day++) {
                    $date = Carbon::create($tahun, $bulan, $day);

                    $presensiMasukCount = Presensi::where('user_id', $karyawan->id)
                        ->whereDate('tanggal', $date)
                        ->count();

                    $presensiKeluarCount = Presensi::where('user_id', $karyawan->id)
                        ->whereDate('tanggal', $date)
                        ->whereNotNull('clock_out')
                        ->count();

                    $presensi[] = [
                        "masuk" => $presensiMasukCount,
                        "keluar" => $presensiKeluarCount,
                    ];
                }

                $presensiData[] = [
                    'nama' => $karyawan->nama,
                    'presensi' => $presensi,
                ];
            }

            return $this->successResponse([
                'labels' => $labels,
                'presensi_data' => $presensiData,
            ], 'Data presensi ditemukan.');
        }

        if ($request->input("mode") == "pdf") {
            $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
            $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();

            $karyawans = User::all();

            $dates = Carbon::parse($startDate);
            $labels = [];

            while ($dates <= $endDate) {
                $dateString = $dates->toDateString();
                $labels[] = formatTanggal($dateString, 'd');
                $dates->addDay();
            }

            foreach ($karyawans as $karyawan) {
                $presensi = [];

                for ($day = 1; $day <= $endDate->daysInMonth; $day++) {
                    $date = Carbon::create($tahun, $bulan, $day);

                    $presensiMasukCount = Presensi::where('user_id', $karyawan->id)
                        ->whereDate('tanggal', $date)
                        ->count();

                    $presensiKeluarCount = Presensi::where('user_id', $karyawan->id)
                        ->whereDate('tanggal', $date)
                        ->whereNotNull('clock_out')
                        ->count();

                    $presensi[] = [
                        "masuk" => $presensiMasukCount,
                        "keluar" => $presensiKeluarCount,
                    ];
                }

                $presensiData[] = [
                    'nama' => $karyawan->nama,
                    'presensi' => $presensi,
                ];
            }
            $bulanTahun = Carbon::create($tahun, $bulan, 1)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F Y');

            $pdf = PDF::loadView('admin.presensi.pdf', [
                'labels' => $labels,
                'presensi_data' => $presensiData,
                'bulanTahun' => $bulanTahun,
            ]);

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('legal', 'landscape');

            $namaFile = 'laporan_rekap_presensi_' . $bulan . '_' . $tahun . '.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->stream($namaFile);
        }

        return view('admin.presensi.rekap');
    }

}
