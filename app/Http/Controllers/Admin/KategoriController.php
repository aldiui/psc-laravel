<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kategoris = Kategori::all();
            if ($request->mode == "datatable") {
                return DataTables::of($kategoris)
                    ->addColumn('aksi', function ($kategori) {
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex  align-items-baseline  mr-1" onclick="getModal(`createModal`, `/admin/kategori/' . $kategori->id . '`, [`id`, `nama`, `deskripsi`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex  align-items-baseline " onclick="confirmDelete(`/admin/kategori/' . $kategori->id . '`, `kategoriTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi'])
                    ->make(true);
            }

            return $this->successResponse($kategoris, 'Data Kategori ditemukan.');
        }

        return view('admin.kategori.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:50|unique:kategoris,nama',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $kategori = Kategori::create($request->only('nama', 'deskripsi'));
        return $this->successResponse($kategori, 'Data Kategori ditambahkan.', 201);
    }

    public function show($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return $this->errorResponse(null, 'Data Kategori tidak ditemukan.', 404);
        }

        return $this->successResponse($kategori, 'Data Kategori ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:50|unique:kategoris,nama,' . $id,
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $kategori = Kategori::find($id);

        if (!$kategori) {
            return $this->errorResponse(null, 'Data Kategori tidak ditemukan.', 404);
        }

        $kategori->update($request->only('nama', 'deskripsi'));
        return $this->successResponse($kategori, 'Data Kategori diubah.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return $this->errorResponse(null, 'Data Kategori tidak ditemukan.', 404);
        }

        $kategori->delete();
        return $this->successResponse(null, 'Data Kategori dihapus.');
    }
}
