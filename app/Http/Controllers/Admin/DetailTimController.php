<?php

namespace App\Http\Controllers\Admin;

use App\Models\DetailTim;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DetailTimController extends Controller
{
    use ApiResponder;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tim_id' => 'required',
            'user_id' => 'required',
            'posisi' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $detailTim = DetailTim::create([
            'tim_id' => $request->input('tim_id'),
            'user_id' => $request->input('user_id'),
            'posisi' => $request->input('posisi'),
        ]);

        return $this->successResponse($detailTim, 'Data Detail Tim ditambahkan.', 201);
    }

    public function show($id)
    {
        $detailTim = DetailTim::find($id);

        if(!$detailTim){
            return $this->errorResponse(null, 'Data Detail Tim tidak ditemukan.', 404);    
        }
        
        return $this->successResponse($detailTim, 'Data Detail Tim ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'posisi' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $detailTim = DetailTim::find($id);
        
        if(!$detailTim){
            return $this->errorResponse(null, 'Data Detail Tim tidak ditemukan.', 404);    
        }

        $detailTim->update([
            'user_id' => $request->input('user_id'),
            'posisi' => $request->input('posisi')
        ]);

        return $this->successResponse($detailTim, 'Data Detail Tim diupdate.');
    }

    public function destroy($id)
    {
        $detailTim = DetailTim::find($id);

        if(!$detailTim){
            return $this->errorResponse(null, 'Data Detail Tim tidak ditemukan.', 404);    
        }

        $detailTim->delete();
        
        return $this->successResponse(null, 'Data Detail Tim dihapus.');
    }
}
