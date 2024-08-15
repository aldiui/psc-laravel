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
                'nama' => 'required|max:50',
                'image' => 'image|mimes:png,jpg,jpeg',
                'email' => 'required|max:50|email|unique:users,email,' . Auth::user()->id,
                'no_hp' => 'required|numeric|digits_between:10,13',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
            }

            $user = Auth::user();

            if (!$user) {
                return $this->errorResponse(null, 'Data Karyawan tidak ditemukan.', 404);
            }

            $updateUser = [
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
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
            'password_lama' => 'required|min:8|max:20',
            'password' => 'required|min:8|max:20',
            'password_confirmation' => 'required|min:8|max:20|same:password',
        ], [
            'password.required' => 'Password Baru harus diisi.',
            'password.min' => 'Password Baru minimal 8 karakter.',
            'password.max' => 'Password Baru maksimal 20 karakter.',
            'password_confirmation.required' => 'Konfirmasi password harus diisi.',
            'password_confirmation.same' => 'Konfirmasi password tidak sama.',
            'password_confirmation.min' => 'Konfirmasi password minimal 8 karakter.',
            'password_confirmation.max' => 'Konfirmasi password maksimal 20 karakter.',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $user = Auth::user();

        if (!$user) {
            return $this->errorResponse(null, 'Data Karyawan tidak ditemukan.', 404);
        }

        if (!Hash::check($request->password_lama, $user->password)) {
            return $this->errorResponse(null, 'Password lama tidak sesuai.', 422);
        }

        $user->update($request->only('password'));

        return $this->successResponse($user, 'Data Password diupdate.');
    }
}
