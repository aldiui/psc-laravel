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
                    ->addColumn('aksi', function ($presensi) {
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex  align-items-baseline  mr-1" onclick="getModal(`createModal`, `/admin/presensi/' . $presensi->id . '`, [`id`, `nama`, `email`, `jabatan`, `no_hp`, `role`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        return $editButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['nama', 'img', 'presensi_masuk', 'presensi_keluar', 'tugas_catatan', 'aksi'])
                    ->make(true);
            }
        }

        return view('admin.presensi.index');
    }

    public function rekapPresensi(Request $request)
    {
        set_time_limit(300);

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $presensiRecords = Presensi::select('user_id', 'tanggal', 'jam_keluar')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal')
            ->get();

        $karyawans = User::select('id', 'nama')->get()->keyBy('id');

        $presensiData = [];

        foreach ($karyawans as $karyawan) {
            $presensiData[$karyawan->id] = [
                'nama' => $karyawan->nama,
                'presensi' => array_fill(1, $endDate->day, ['masuk' => 0, 'keluar' => 0]),
            ];
        }

        foreach ($presensiRecords as $record) {
            $tanggal = Carbon::parse($record->tanggal)->day;
            $user_id = $record->user_id;

            $presensiData[$user_id]['presensi'][$tanggal]['masuk'] = 1;
            $presensiData[$user_id]['presensi'][$tanggal]['keluar'] = $record->jam_keluar ? 1 : 0;
        }

        $labels = range(1, $endDate->day);

        if ($request->ajax()) {
            return $this->successResponse([
                'labels' => $labels,
                'presensi_data' => array_values($presensiData),
            ], 'Data presensi ditemukan.');
        }

        if ($request->input('mode') === 'pdf') {
            $bulanTahun = $startDate->locale('id')->translatedFormat('F Y');

            $pdf = PDF::loadView('admin.presensi.pdf', [
                'labels' => $labels,
                'presensi_data' => array_values($presensiData),
                'bulanTahun' => $bulanTahun,
            ]);

            $options = [
                'margin_top' => 0,
                'margin_right' => 0,
                'margin_bottom' => 0,
                'margin_left' => 0,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('legal', 'landscape');

            $namaFile = 'laporan_rekap_presensi_' . $bulan . '_' . $tahun . '.pdf';

            return $pdf->stream($namaFile);
        }

        return view('admin.presensi.rekap', compact('labels', 'presensiData'));
    }

}
