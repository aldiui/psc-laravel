<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TimExport;
use App\Http\Controllers\Controller;
use App\Models\DetailTim;
use App\Models\Tim;
use App\Traits\ApiResponder;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TimController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tims = Tim::withCount('detailTims')->get();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($tims)
                    ->addColumn('aksi', function ($tim) {
                        $detailButton = '<a class="btn btn-sm btn-info mr-1" href="/admin/tim/' . $tim->id . '"><i class="fas fa-info-circle mr-1"></i>Detail</a>';
                        $editButton = '<button class="btn btn-sm btn-warning mr-1" onclick="getModal(`editModal`, `/admin/tim/' . $tim->id . '`, [`id`, `nama`, `deskripsi`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/tim/' . $tim->id . '`, `timTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';

                        return $detailButton . $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi'])
                    ->make(true);
            }

            return $this->successResponse($tims, 'Data tim ditemukan.');
        }

        return view('admin.tim.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $tim = Tim::create([
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
        ]);

        return $this->successResponse($tim, 'Data tim ditambahkan.', 201);
    }

    public function show(Request $request, $id)
    {
        if ($id == 'excel') {
            ob_end_clean();
            ob_start();
            return Excel::download(new TimExport(), 'Tim.xlsx');
        }

        if ($id == 'pdf') {
            $tims = Tim::withCount('detailTims')->get();
            $pdf = PDF::loadView('admin.tim.pdf', compact('tims'));

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('a4', 'landscape');

            $namaFile = 'Tim.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->stream($namaFile);
        }

        $tim = Tim::find($id);

        if ($request->ajax()) {
            if ($request->input("mode") == "datatable") {
                $detailTims = DetailTim::with('user')->where('tim_id', $id)->get();
                return DataTables::of($detailTims)
                    ->addColumn('aksi', function ($detailTim) {
                        $editButton = '<button class="btn btn-sm btn-warning mr-1" onclick="getSelectEdit(), getModal(`editModal`, `/admin/detail-tim/' . $detailTim->id . '`, [`id`, `user_id`, `posisi`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/detail-tim/' . $detailTim->id . '`, `detailTimTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';

                        return $editButton . $deleteButton;
                    })
                    ->addColumn('nama', function ($detailTim) {
                        return $detailTim->user->nama;
                    })
                    ->addColumn('img', function ($detailTim) {
                        return '<img src="/storage/img/karyawan/' . $detailTim->user->image . '" width="100px" alt="">';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['nama', 'img', 'aksi'])
                    ->make(true);
            }

            if (!$tim) {
                return $this->errorResponse(null, 'Data tim tidak ditemukan.', 404);
            }

            return $this->successResponse($tim, 'Data tim ditemukan.');
        }

        return view('admin.tim.show', compact('tim'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $tim = Tim::find($id);

        if (!$tim) {
            return $this->errorResponse(null, 'Data tim tidak ditemukan.', 404);
        }

        $tim->update([
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
        ]);

        return $this->successResponse($tim, 'Data tim diubah.');
    }

    public function destroy($id)
    {
        $tim = Tim::find($id);

        if (!$tim) {
            return $this->errorResponse(null, 'Data tim tidak ditemukan.', 404);
        }

        $tim->delete();

        return $this->successResponse(null, 'Data tim dihapus.');
    }
}
