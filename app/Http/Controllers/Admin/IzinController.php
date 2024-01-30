<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\User;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IzinController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bulan = $request->input("bulan");
            $tahun = $request->input("tahun");

            $izins = Izin::with('user')->whereMonth('tanggal_mulai', $bulan)->whereYear('tanggal_mulai', $tahun)->latest()->get();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($izins)
                    ->addColumn('aksi', function ($izin) {
                        $confirmButton = '<button class="btn btn-sm btn-primary mr-1" onclick="getDetailIzin(`confirmModal`, `/admin/izin/' . $izin->id . '`, [`id`, `tgl_mulai`, `tgl_selesai`, `alasan`, `file`, `tipe`])"><i class="fas fa-question-circle mr-1"></i>Konfirmasi</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/izin/' . $izin->id . '`, `izinTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';

                        return ($izin->status == '0' || $izin->status == '2') ? $confirmButton . $deleteButton : "<span class='badge badge-success'><i class='far fa-check-circle mr-1'></i> Disetujui</span>";
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
                        return '<img src="/storage/img/karyawan/' . $izin->user->image . '" width="100px" alt="">';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'status_badge', 'tanggal', 'nama', 'img'])
                    ->make(true);
            }

            return $this->successResponse($izins, 'Data izin ditemukan.');
        }

        return view('admin.izin.index');
    }

    public function show($id)
    {
        $izin = Izin::find($id);

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
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), ['status' => 'required|in:1,2']);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $izin = Izin::find($id);

        if (!$izin) {
            return $this->errorResponse(null, 'Data izin tidak ditemukan.', 404);
        }

        $izin->update(['status' => $request->status]);

        return $this->successResponse($izin, 'Data izin diupdate.');
    }

    public function destroy($id)
    {
        $izin = Izin::find($id);

        if (!$izin) {
            return $this->errorResponse(null, 'Data izin tidak ditemukan.', 404);
        }

        if (Storage::exists('public/img/izin/' . $izin->file)) {
            Storage::delete('public/img/izin/' . $izin->file);
        }

        $izin->delete();

        return $this->successResponse(null, 'Data izin dihapus.');
    }

}
