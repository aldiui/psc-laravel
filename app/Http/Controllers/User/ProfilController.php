<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->isMethod('put')) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'image' => 'image|mimes:png,jpg,jpeg',
                'email' => 'required|email|unique:users,email,' . Auth::user()->id,
                'jabatan' => 'required',
                'no_hp' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
            }

            $user = Auth::user();

            if (!$user) {
                return $this->errorResponse(null, 'Data karyawan tidak ditemukan.', 404);
            }

            $updateUser = [
                'nama' => $request->input('nama'),
                'email' => $request->input('email'),
                'jabatan' => $request->input('jabatan'),
                'no_hp' => $request->input('no_hp'),
            ];

            if ($request->hasFile('image')) {
                if ($user->image != 'default.png' && Storage::exists('public/img/karyawan/' . $user->image)) {
                    Storage::delete('public/img/karyawan/' . $user->image);
                }
                $image = $request->file('image')->hashName();
                $request->file('image')->storeAs('public/img/karyawan', $image);
                $updateUser['image'] = $image;
            }

            $user->update($updateUser);

            return $this->successResponse($user, 'Data profil diupdate.');
        }

        return view('user.profil.index');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_lama' => 'required|min:8',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $user = Auth::user();

        if (!$user) {
            return $this->errorResponse(null, 'Data karyawan tidak ditemukan.', 404);
        }

        if (!Hash::check($request->input('password_lama'), $user->password)) {
            return $this->errorResponse(null, 'Password lama tidak sesuai.', 422);
        }

        $user->update([
            'password' => bcrypt($request->input('password')),
        ]);

        return $this->successResponse($user, 'Data password diupdate.');
    }
}