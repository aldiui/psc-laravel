<?php

namespace App\Http\Controllers\Admin;

use App\Exports\KaryawanExport;
use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\Presensi;
use App\Models\User;
use App\Traits\ApiResponder;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $karyawans = User::all();
            if ($request->mode == "datatable") {
                return DataTables::of($karyawans)
                    ->addColumn('aksi', function ($karyawan) {
                        $detailButton = '<a class="btn btn-sm btn-info d-inline-flex  align-items-baseline  mr-1" href="/admin/karyawan/' . $karyawan->id . '"><i class="fas fa-info-circle mr-1"></i>Detail</a>';
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex  align-items-baseline  mr-1" onclick="getModal(`createModal`, `/admin/karyawan/' . $karyawan->id . '`, [`id`, `nama`, `email`, `jabatan`, `no_hp`, `role`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex  align-items-baseline " onclick="confirmDelete(`/admin/karyawan/' . $karyawan->id . '`, `karyawanTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';

                        return $detailButton . $editButton . $deleteButton;
                    })
                    ->addColumn('img', function ($karyawan) {
                        return '<img src="' . ($karyawan->image != 'default.png' ? '/storage/img/karyawan/' . $karyawan->image : '/images/default.png') . '" width="100px" alt="">';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'img'])
                    ->make(true);
            }

            return $this->successResponse($karyawans, 'Data Karyawan ditemukan.');
        }

        return view('admin.karyawan.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'jabatan' => 'required',
            'no_hp' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/img/karyawan', $image);
        }

        $karyawan = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'role' => $request->role,
            'image' => $image ?? "default.png",
        ]);

        return $this->successResponse($karyawan, 'Data Karyawan ditambahkan.', 201);
    }

    public function show(Request $request, $id)
    {

        if ($request->ajax()) {
            $bulan = $request->bulan;
            $tahun = $request->tahun;

            $karyawan = User::find($id);
            if ($request->mode == "presensi") {
                $presensis = Presensi::where('user_id', $id)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->orderBy('id', 'desc')
                    ->get();

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

            if ($request->mode == 'izin') {
                $izins = Izin::with('approval')->where('user_id', $id)->whereMonth('tanggal_mulai', $bulan)->whereYear('tanggal_mulai', $tahun)->latest()->get();
                if ($request->input("mode") == "datatable") {
                    return DataTables::of($izins)
                        ->addColumn('tanggal', function ($izin) {
                            return ($izin->tanggal_selesai == null) ? formatTanggal($izin->tanggal_mulai) : formatTanggal($izin->tanggal_mulai) . ' - ' . formatTanggal($izin->tanggal_selesai);
                        })
                        ->addColumn('status_badge', function ($izin) {
                            return statusBadge($izin->status);
                        })
                        ->addIndexColumn()
                        ->rawColumns(['status_badge', 'tanggal'])
                        ->make(true);
                }

            }

            if (!$karyawan) {
                return $this->errorResponse(null, 'Data Karyawan tidak ditemukan.', 404);
            }

            return $this->successResponse($karyawan, 'Data Karyawan ditemukan.');
        }

        if ($id == 'excel') {
            ob_end_clean();
            ob_start();
            return Excel::download(new KaryawanExport(), 'Karyawan.xlsx');
        } elseif ($id == "pdf") {
            $karyawans = User::all();
            $pdf = PDF::loadView('admin.karyawan.pdf', compact('karyawans'));

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('a4', 'landscape');

            $namaFile = 'Karyawan.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->stream($namaFile);
        }

        $karyawan = User::findOrFail($id);

        return view('admin.karyawan.show', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $dataValidator = [
            'nama' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
            'email' => 'required|email|unique:users,email,' . $id,
            'jabatan' => 'required',
            'no_hp' => 'required',
            'role' => 'required',
        ];

        if ($request->password != null) {
            $dataValidator['password'] = 'required|min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $dataValidator);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $karyawan = User::find($id);

        if (!$karyawan) {
            return $this->errorResponse(null, 'Data Karyawan tidak ditemukan.', 404);
        }

        $updateKaryawan = [
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'role' => $request->role,
        ];

        if ($request->hasFile('image')) {
            if ($karyawan->image != 'default.png' && Storage::exists('public/img/karyawan/' . $karyawan->image)) {
                Storage::delete('public/img/karyawan/' . $karyawan->image);
            }
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/img/karyawan', $image);
            $updateKaryawan['image'] = $image;
        }

        if ($request->password != null) {
            $updateKaryawan['password'] = bcrypt($request->password);
        }

        $karyawan->update($updateKaryawan);

        return $this->successResponse($karyawan, 'Data Karyawan diubah.');
    }

    public function destroy($id)
    {
        $karyawan = User::find($id);

        if (!$karyawan) {
            return $this->errorResponse(null, 'Data Karyawan tidak ditemukan.', 404);
        }

        if ($karyawan->image != 'default.png' && Storage::exists('public/img/karyawan/' . $karyawan->image)) {
            Storage::delete('public/img/karyawan/' . $karyawan->image);
        }

        $karyawan->delete();

        return $this->successResponse(null, 'Data Karyawan dihapus.');
    }
}
