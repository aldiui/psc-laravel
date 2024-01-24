<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengaturanController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $pengaturan = Pengaturan::find(1);

        if ($request->isMethod('put')) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'longitude' => 'required',
                'latitude' => 'required',
                'radius' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
            }

            $pengaturan->update([
                'nama' => $request->input('nama'),
                'longitude' => $request->input('longitude'),
                'latitude' => $request->input('latitude'),
                'radius' => $request->input('radius'),
            ]);

            return $this->successResponse($pengaturan, 'Data pengaturan diupdate.');
        }

        return view('admin.pengaturan.index', compact('pengaturan'));
    }
}
