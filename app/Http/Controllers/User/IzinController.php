<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\Notifikasi;
use App\Models\User;
use App\Traits\ApiResponder;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IzinController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bulan = $request->bulan;
            $tahun = $request->tahun;

            $izins = Izin::with('approval')->where('user_id', Auth::user()->id)->whereMonth('tanggal_mulai', $bulan)->whereYear('tanggal_mulai', $tahun)->latest()->get();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($izins)
                    ->addColumn('aksi', function ($izin) {
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex align-items-baseline  mr-1" onclick="getModal(`createModal`, `/izin/' . $izin->id . '`, [`id`, `tanggal_mulai`, `tanggal_selesai`, `alasan`, `file`, `tipe`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex  align-items-baseline  " onclick="confirmDelete(`/izin/' . $izin->id . '`, `izinTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                        return ($izin->status == '0' || $izin->status == '2') ? $editButton . $deleteButton : "<a class='btn btn-info mb-2' href='/izin/" . $izin->id . "' target='_blank'><i class='fas fa-print mr-1'></i> Cetak</a> <br> Di setujui oleh " . $izin->approval->nama;
                    })
                    ->addColumn('tanggal', function ($izin) {
                        return ($izin->tanggal_selesai == null) ? formatTanggal($izin->tanggal_mulai) : formatTanggal($izin->tanggal_mulai) . ' - ' . formatTanggal($izin->tanggal_selesai);
                    })
                    ->addColumn('status_badge', function ($izin) {
                        return statusBadge($izin->status);
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'status_badge', 'tanggal'])
                    ->make(true);
            }

            return $this->successResponse($izins, 'Data Izin ditemukan.');
        }

        return view('user.izin.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_mulai' => 'required',
            'alasan' => 'required',
            'file' => 'image|mimes:png,jpg,jpeg',
            'tipe' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file')->hashName();
            $request->file('file')->storeAs('public/img/izin', $file);
        }

        $izin = Izin::create([
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_selesai' => $request->input('tanggal_selesai') ?? null,
            'alasan' => $request->input('alasan'),
            'file' => $file ?? null,
            'tipe' => $request->input('tipe'),
            'user_id' => Auth::user()->id,
        ]);

        $notifikasi = Notifikasi::create([
            'user_id' => Auth::user()->id,
            'target_id' => getSuperAdmin()->id,
            'title' => 'Izin',
            'body' => Auth::user()->nama . ' Mengajukan ' . $izin->tipe . ' pada ' . formatTanggal($izin->tanggal_mulai),
            'url' => '/admin/izin',
        ]);

        kirimNotifikasi($notifikasi->title, $notifikasi->body, getSuperAdmin()->fcm_token);

        return $this->successResponse($izin, 'Data Izin ditambahkan.', 201);
    }

    public function show(Request $request, $id)
    {
        $izin = Izin::with('user')->find($id);

        if ($request->ajax()) {
            if (!$izin) {
                return $this->errorResponse(null, 'Data Izin tidak ditemukan.', 404);
            }

            return $this->successResponse($izin, 'Data Izin ditemukan.');
        } else {
            if (!$izin || $izin->status != '1') {
                return redirect()->route('izin.index');
            }

            $pdf = PDF::loadView('admin.izin.pdf', compact('izin'));

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
        $dataValidator = [
            'tanggal_mulai' => 'required',
            'alasan' => 'required',
            'file' => 'image|mimes:png,jpg,jpeg',
            'tipe' => 'required',
        ];

        $validator = Validator::make($request->all(), $dataValidator);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $izin = Izin::find($id);

        if (!$izin) {
            return $this->errorResponse(null, 'Data Izin tidak ditemukan.', 404);
        }

        $updateIzin = [
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_selesai' => $request->input('tanggal_selesai') ?? null,
            'alasan' => $request->input('alasan'),
            'tipe' => $request->input('tipe'),
        ];

        if ($request->hasFile('file')) {
            if (Storage::exists('public/img/izin/' . $izin->file)) {
                Storage::delete('public/img/izin/' . $izin->file);
            }
            $file = $request->file('file')->hashName();
            $request->file('file')->storeAs('public/img/izin', $file);
            $updateIzin['file'] = $file;
        }

        $izin->update($updateIzin);

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
