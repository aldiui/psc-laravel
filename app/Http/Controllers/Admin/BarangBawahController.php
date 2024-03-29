<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BarangBawahExport;
use App\Http\Controllers\Controller;
use App\Models\BarangBawah;
use App\Traits\ApiResponder;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BarangBawahController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $barangBawahs = BarangBawah::with(['barang.unit'])->get();
            if ($request->mode == "datatable") {
                return DataTables::of($barangBawahs)
                    ->addColumn('aksi', function ($barangBawah) {
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex align-items-baseline mr-1" onclick="getModal(`createModal`, `/admin/barang-bawah/' . $barangBawah->id . '`, [`id`, `barang_id`, `qty`, `deskripsi`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex  align-items-baseline " onclick="confirmDelete(`/admin/barang-bawah/' . $barangBawah->id . '`, `barangBawahTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addColumn('nama', function ($barangBawah) {
                        return $barangBawah->barang->nama;
                    })
                    ->addColumn('quantity', function ($barangBawah) {
                        return $barangBawah->qty . " " . ($barangBawah->barang->unit->nama !== 'Kosong' ? ' ' . $barangBawah->barang->unit->nama : '');
                    })
                    ->addIndexColumn()
                    ->rawColumns(['nama', 'aksi', 'quantity'])
                    ->make(true);
            }

            return $this->successResponse($barangBawahs, 'Data Barang Bawah ditemukan.');
        }

        return view('admin.barang-bawah.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $cekBarangBawah = BarangBawah::where('barang_id', $request->barang_id)->first();
        if ($cekBarangBawah) {
            return $this->errorResponse(null, 'Data Barang Bawah sudah ada.', 409);
        }

        $barangBawah = BarangBawah::create([
            'barang_id' => $request->barang_id,
            'qty' => $request->qty,
            'deskripsi' => $request->deskripsi,
        ]);

        return $this->successResponse($barangBawah, 'Data Barang Bawah ditambahkan.', 201);
    }

    public function show($id)
    {
        if ($id == "excel") {
            ob_end_clean();
            ob_start();
            return Excel::download(new BarangBawahExport(), 'BarangBawah.xlsx');
        } elseif ($id == 'pdf') {
            $barangBawahs = BarangBawah::with('barang.unit', 'barang.kategori')->get();
            $pdf = PDF::loadView('admin.barang-bawah.pdf', compact('barangBawahs'));

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('a4', 'landscape');

            $namaFile = 'BarangBawah.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->stream($namaFile);
        } else {
            $barangBawah = BarangBawah::find($id);

            if (!$barangBawah) {
                return $this->errorResponse(null, 'Data Barang Bawah tidak ditemukan.', 404);
            }

            return $this->successResponse($barangBawah, 'Data Barang Bawah ditemukan.');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $barangBawah = BarangBawah::find($id);

        if (!$barangBawah) {
            return $this->errorResponse(null, 'Data Barang Bawah tidak ditemukan.', 404);
        }

        $barangBawah->update([
            'barang_id' => $request->barang_id,
            'qty' => $request->qty,
            'deskripsi' => $request->deskripsi,
        ]);

        return $this->successResponse($barangBawah, 'Data Barang Bawah diubah.');
    }

    public function destroy($id)
    {
        $barangBawah = BarangBawah::find($id);

        if (!$barangBawah) {
            return $this->errorResponse(null, 'Data Barang Bawah tidak ditemukan.', 404);
        }

        $barangBawah->delete();

        return $this->successResponse(null, 'Data Barang Bawah dihapus.');
    }
}
