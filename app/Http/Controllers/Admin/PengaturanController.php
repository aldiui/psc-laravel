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
                'nama' => 'required|max:50',
                'ketua_pelaksana' => 'required|max:50',
                'nip_ketua_pelaksana' => 'required|max:50',
                'longitude' => 'required|max:50',
                'latitude' => 'required|max:50',
                'radius' => 'required|max:10',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
            }

            $pengaturan->update($request->only('nama', 'ketua_pelaksana', 'nip_ketua_pelaksana', 'longitude', 'latitude', 'radius'));
            return $this->successResponse($pengaturan, 'Data pengaturan diubah.');
        }
        return view('admin.pengaturan.index', compact('pengaturan'));
    }
}
