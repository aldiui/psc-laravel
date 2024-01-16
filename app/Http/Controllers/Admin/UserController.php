<?php

namespace App\Http\Controllers\Admin;

use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponder;
    
    public function index(Request $request)
    {    
        if ($request->isMethod('put')) {
            $dataValidator = [
                'nama' => 'required',
                'image' => 'image|mimes:png,jpg,jpeg',
                'email' => 'required|email|unique:users,email,'.$id,
                'jabatan' => 'required',
                'no_hp' => 'required',
            ];
    
            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
            }

            $updateKaryawan = [
                'nama' => $request->input('nama'),
                'email' => $request->input('email'),
                'jabatan' => $request->input('jabatan'),
                'no_hp' => $request->input('no_hp'),
            ];
    
            if ($request->hasFile('image')) {
                if ($karyawan->image != 'default.png' && Storage::exists('public/img/karyawan/' . $karyawan->image)) {
                    Storage::delete('public/img/karyawan/' . $karyawan->image);
                }
                $image = $request->file('image')->hashName();
                $request->file('image')->storeAs('public/img/karyawan', $image);
                $updateKaryawan['image'] = $image;
            }
            
            $karyawan->update($updateKaryawan);
            
            return $this->successResponse($karyawan, 'Data profil diupdate.');
        }

        return view('admin.user.index');
    }
}