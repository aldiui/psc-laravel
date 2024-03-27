<?php

namespace App\Http\Controllers\Admin;

use App\Exports\IzinExport;
use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\Notifikasi;
use App\Models\Pengaturan;
use App\Models\User;
use App\Traits\ApiResponder;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class IzinController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if ($request->ajax()) {
            $izins = Izin::with(['user', 'approval'])->whereMonth('tanggal_mulai', $bulan)->whereYear('tanggal_mulai', $tahun)->latest()->get();
            if ($request->mode == "datatable") {
                return DataTables::of($izins)
                    ->addColumn('aksi', function ($izin) {
                        $confirmButton = '<button class="btn btn-sm btn-primary d-inline-flex  align-items-baseline  mr-1" onclick="getDetailIzin(`confirmModal`, `/admin/izin/' . $izin->id . '`, [`id`, `tgl_mulai`, `tgl_selesai`, `alasan`, `file`, `tipe`])"><i class="fas fa-question-circle mr-1"></i>Konfirmasi</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex  align-items-baseline " onclick="confirmDelete(`/admin/izin/' . $izin->id . '`, `izinTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                        return ($izin->status == '0' || $izin->status == '2') ? $confirmButton . $deleteButton : "<a class='btn btn-info mb-2' href='/admin/izin/" . $izin->id . "' target='_blank'><i class='fas fa-print mr-1'></i> Cetak</a> <br> Di setujui oleh " . $izin->approval->nama;
                    })
                    ->addColumn('tanggal', function ($izin) {
                        return ($izin->tanggal_selesai == null) ? formatTanggal($izin->tanggal_mulai) : formatTanggal($izin->tanggal_mulai) . ' - ' . formatTanggal($izin->tanggal_selesai);
                    })
                    ->addColumn('status_badge', function ($izin) {
                        return statusBadge($izin->status);
                    })
                    ->addColumn('nama', function ($izin) {
                        return $izin->user->nama;
                    })
                    ->addColumn('img', function ($izin) {
                        return '<img src="' . ($izin->user->image != 'default.png' ? '/storage/img/karyawan/' . $izin->user->image : '/images/default.png') . '" width="100px" alt="">';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'status_badge', 'tanggal', 'nama', 'img'])
                    ->make(true);
            }

            return $this->successResponse($izins, 'Data Izin ditemukan.');
        }

        if ($request->mode == "pdf") {
            $izins = Izin::with(['user', 'approval'])->where('status', '1')->whereMonth('tanggal_mulai', $bulan)->whereYear('tanggal_mulai', $tahun)->latest()->get();
            $bulanTahun = Carbon::create($tahun, $bulan, 1)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F Y');

            $pdf = PDF::loadView('admin.izin.rekap', compact('izins', 'bulanTahun'));

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('legal', 'landscape');

            $namaFile = 'laporan_rekap_izin_' . $bulan . '_' . $tahun . '.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->stream($namaFile);
        }

        if ($request->mode == "excel") {
            ob_end_clean();
            ob_start();
            return Excel::download(new IzinExport($bulan, $tahun), 'laporan_rekap_izin_' . $bulan . '_' . $tahun . '.xlsx');
        }

        return view('admin.izin.index');
    }

    public function show(Request $request, $id)
    {
        $izin = Izin::with('user')->find($id);

        if ($request->ajax()) {
            if (!$izin) {
                return $this->errorResponse(null, 'Data Izin tidak ditemukan.', 404);
            }

            $formattedTanggalMulai = formatTanggal($izin->tanggal_mulai);
            $formattedTanggalSelesai = ($izin->tanggal_selesai == null) ? null : formatTanggal($izin->tanggal_selesai);
            $formattedTanggalRange = ($formattedTanggalSelesai == null) ? $formattedTanggalMulai : $formattedTanggalMulai . ' - ' . $formattedTanggalSelesai;

            $izin->tgl_mulai = $formattedTanggalMulai;
            $izin->tgl_selesai = $formattedTanggalSelesai;
            $izin->tgl_range = $formattedTanggalRange;

            return $this->successResponse($izin, 'Data Izin ditemukan.');
        } else {
            if (!$izin || $izin->status != '1') {
                return redirect()->route('admin.izin.index');
            }
            $pengaturan = Pengaturan::find(1);
            $pdf = PDF::loadView('admin.izin.pdf', compact(['izin', 'pengaturan']));

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('a4', 'potrait');

            $namaFile = 'izin.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->stream($namaFile);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), ['status' => 'required|in:1,2']);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $izin = Izin::find($id);

        if (!$izin) {
            return $this->errorResponse(null, 'Data Izin tidak ditemukan.', 404);
        }

        $izin->update([
            'status' => $request->status,
            'approval_id' => Auth::user()->id,
        ]);

        $notifikasi = Notifikasi::create([
            'user_id' => Auth::user()->id,
            'target_id' => $izin->user_id,
            'title' => 'Izin',
            'body' => $izin->user->nama . ' Mengajukan ' . $izin->tipe . ' pada ' . formatTanggal($izin->tanggal_mulai) . ($request->status == 2 ? ' ditolak' : ' disetujui'),
            'url' => '/izin',
        ]);

        if ($izin->user->fcm_token) {
            kirimNotifikasi($notifikasi->title, $notifikasi->body, $izin->user->fcm_token);
        }

        return $this->successResponse($izin, 'Data Izin diubah.');
    }

    public function destroy($id)
    {
        $izin = Izin::find($id);

        if (!$izin) {
            return $this->errorResponse(null, 'Data Izin tidak ditemukan.', 404);
        }

        if (Storage::exists('public/img/izin/' . $izin->file)) {
            Storage::delete('public/img/izin/' . $izin->file);
        }

        $izin->delete();

        return $this->successResponse(null, 'Data Izin dihapus.');
    }

}
