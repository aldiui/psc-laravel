<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BarangExport;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Traits\ApiResponder;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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
                        $editButton = '<button class="btn btn-sm btn-warning mr-1" onclick="getSelectEdit(); getModal(`editModal`, `/admin/barang/' . $barang->id . '`, [`id`,`kategori_id`,`unit_id`,`nama`, `deskripsi`, `qty`, `image`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/barang/' . $barang->id . '`, `barangTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
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

        return view('admin.barang.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kategori_id' => 'required|numeric',
            'unit_id' => 'required|numeric',
            'qty' => 'required|numeric',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/img/barang', $image);
        }

        $barang = Barang::create([
            'nama' => $request->input('nama'),
            'kategori_id' => $request->input('kategori_id'),
            'unit_id' => $request->input('unit_id'),
            'deskripsi' => $request->input('deskripsi'),
            'qty' => $request->input('qty'),
            'image' => $image ?? null,
        ]);

        return $this->successResponse($barang, 'Data barang ditambahkan.', 201);
    }

    public function show($id)
    {
        if ($id == "excel") {
            ob_end_clean();
            ob_start();
            return Excel::download(new BarangExport(), 'Barang.xlsx');
        }

        if ($id == 'pdf') {
            $barangs = Barang::with('unit', 'kategori')->get();
            $pdf = PDF::loadView('admin.barang.pdf', compact('barangs'));

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('a4', 'landscape');

            $namaFile = 'Barang.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->stream($namaFile);
        }

        $barang = Barang::find($id);

        if (!$barang) {
            return $this->errorResponse(null, 'Data barang tidak ditemukan.', 404);
        }

        return $this->successResponse($barang, 'Data barang ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kategori_id' => 'required|numeric',
            'unit_id' => 'required|numeric',
            'qty' => 'required|numeric',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $barang = Barang::find($id);

        if (!$barang) {
            return $this->errorResponse(null, 'Data barang tidak ditemukan.', 404);
        }

        $updateBarang = [
            'nama' => $request->input('nama'),
            'kategori_id' => $request->input('kategori_id'),
            'unit_id' => $request->input('unit_id'),
            'deskripsi' => $request->input('deskripsi'),
            'qty' => $request->input('qty'),
        ];

        if ($request->hasFile('image')) {
            if ($barang->image != 'default.png' && Storage::exists('public/img/barang/' . $barang->image)) {
                Storage::delete('public/img/barang/' . $barang->image);
            }
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/img/barang', $image);
            $updateBarang['image'] = $image;
        }

        $barang->update($updateBarang);

        return $this->successResponse($barang, 'Data barang diubah.');
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return $this->errorResponse(null, 'Data barang tidak ditemukan.', 404);
        }

        if ($barang->image != 'default.png' && Storage::exists('public/img/barang/' . $barang->image)) {
            Storage::delete('public/img/barang/' . $barang->image);
        }

        $barang->delete();

        return $this->successResponse(null, 'Data barang dihapus.');
    }
}
