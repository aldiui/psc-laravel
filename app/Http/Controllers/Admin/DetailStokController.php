<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailStok;
use App\Models\Stok;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailStokController extends Controller
{
    use ApiResponder;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stok_id' => 'required|exists:stoks,id',
            'barang_id' => 'required|exists:barangs,id',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $cekDetailStok = DetailStok::where('stok_id', $request->input('stok_id'))->where('barang_id', $request->input('barang_id'))->first();
        if ($cekDetailStok) {
            return $this->errorResponse(null, 'Data Detail Stok sudah ada.', 409);
        }

        $stok = Stok::find($request->input('stok_id'));

        if (!$stok) {
            return $this->errorResponse(null, 'Data stok tidak ditemukan.', 404);
        }

        if ($stok->jenis == 'Keluar') {
            $cekStokBarang = Barang::find($request->input('barang_id'));
            if ($cekStokBarang->qty < $request->input('qty')) {
                return $this->errorResponse(null, 'Stok tidak mencukupi.', 409);
            }
        }

        $detailStok = DetailStok::create([
            'stok_id' => $request->input('stok_id'),
            'barang_id' => $request->input('barang_id'),
            'qty' => $request->input('qty'),
            'deskripsi' => $request->input('deskripsi'),
        ]);

        return $this->successResponse($detailStok, 'Data Detail Stok ditambahkan.', 201);
    }

    public function show($id)
    {
        $detailStok = DetailStok::find($id);

        if (!$detailStok) {
            return $this->errorResponse(null, 'Data Detail Stok tidak ditemukan.', 404);
        }

        return $this->successResponse($detailStok, 'Data Detail Stok ditemukan.');
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

        $detailStok = DetailStok::find($id);

        if (!$detailStok) {
            return $this->errorResponse(null, 'Data Detail Stok tidak ditemukan.', 404);
        }

        $stok = Stok::find($detailStok->stok_id);

        if (!$stok) {
            return $this->errorResponse(null, 'Data stok tidak ditemukan.', 404);
        }

        if ($stok->jenis == 'Keluar') {
            $cekStokBarang = Barang::find($request->input('barang_id'));
            if ($cekStokBarang->qty < $request->input('qty')) {
                return $this->errorResponse(null, 'Stok tidak mencukupi.', 409);
            }
        }

        $detailStok->update([
            'barang_id' => $request->input('barang_id'),
            'qty' => $request->input('qty'),
            'deskripsi' => $request->input('deskripsi'),
        ]);

        return $this->successResponse($detailStok, 'Data Detail Stok diubah.');
    }

    public function destroy($id)
    {
        $detailStok = DetailStok::find($id);

        if (!$detailStok) {
            return $this->errorResponse(null, 'Data Detail Stok tidak ditemukan.', 404);
        }

        $detailStok->delete();

        return $this->successResponse(null, 'Data Detail Stok dihapus.');
    }
}
