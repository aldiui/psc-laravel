<?php

namespace App\Http\Controllers\Admin;

use App\Exports\KategoriExport;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Traits\ApiResponder;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class KategoriController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kategoris = Kategori::all();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($kategoris)
                    ->addColumn('aksi', function ($kategori) {
                        $editButton = '<button class="btn btn-sm btn-warning mr-1" onclick="getModal(`editModal`, `/admin/kategori/' . $kategori->id . '`, [`id`, `nama`, `deskripsi`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/kategori/' . $kategori->id . '`, `kategoriTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';

                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi'])
                    ->make(true);
            }

            return $this->successResponse($kategoris, 'Data kategori ditemukan.');
        }

        return view('admin.kategori.index');
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

        $kategori = Kategori::create([
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
        ]);

        return $this->successResponse($kategori, 'Data kategori ditambahkan.', 201);
    }

    public function show($id)
    {
        if ($id == 'excel') {
            ob_end_clean();
            ob_start();
            return Excel::download(new KategoriExport(), 'Kategori.xlsx');
        }

        if ($id == 'pdf') {
            $kategoris = Kategori::all();
            $pdf = PDF::loadView('admin.kategori.pdf', compact('kategoris'));

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('a4', 'landscape');

            $namaFile = 'Kategori.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->stream($namaFile);
        }

        $kategori = Kategori::find($id);

        if (!$kategori) {
            return $this->errorResponse(null, 'Data kategori tidak ditemukan.', 404);
        }

        return $this->successResponse($kategori, 'Data kategori ditemukan.');
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

        $kategori = Kategori::find($id);

        if (!$kategori) {
            return $this->errorResponse(null, 'Data kategori tidak ditemukan.', 404);
        }

        $kategori->update([
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
        ]);

        return $this->successResponse($kategori, 'Data kategori diubah.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return $this->errorResponse(null, 'Data kategori tidak ditemukan.', 404);
        }

        $kategori->delete();

        return $this->successResponse(null, 'Data kategori dihapus.');
    }

}
