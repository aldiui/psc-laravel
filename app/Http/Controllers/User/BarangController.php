<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $barangs = Barang::with('unit', 'kategori')->get();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($barangs)
                    ->addColumn('aksi', function ($barang) {
                        $editButton = '<button class="btn btn-sm btn-warning mr-1" onclick="getSelectEdit(), getModal(`editModal`, `/barang/' . $barang->id . '`, [`id`,`kategori_id`,`unit_id`,`nama`, `deskripsi`, `qty`, `image`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/barang/' . $barang->id . '`, `barangTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';

                        return $editButton . $deleteButton;
                    })
                    ->addColumn('img', function ($barang) {
                        return '<img src="/storage/img/barang/' . $barang->image . '" width="150px" alt="">';
                    })
                    ->addColumn('qty_unit', function ($barang) {
                        return $barang->qty . ($barang->unit->nama !== 'Kosong' ? ' ' . $barang->unit->nama : '');
                    })
                    ->addColumn('kategori', function ($barang) {
                        return $barang->kategori->nama;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'img', 'kategori'])
                    ->make(true);
            }

            return $this->successResponse($barangs, 'Data barang ditemukan.');
        }

        return view('barang.index');
    }

}
