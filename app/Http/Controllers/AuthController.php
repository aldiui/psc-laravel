<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    use ApiResponder;

    public function login(Request $request)
    {
        if (Auth::check()) {
            return Auth::user()->role == 'admin' ? redirect('/admin') : redirect('/');
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
            }

            if (!Auth::attempt($request->only('email', 'password'))) {
                return $this->errorResponse(null, 'Email atau password tidak valid.', 401);
            }

            $user = Auth::user();
            return $this->successResponse($user, 'Login berhasil.');
        }

        return view('auth.login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleCallback(Request $request)
    {
        $getCallback = Socialite::driver('google')->user();
        $user = User::where('email', $getCallback->email)->first();

        if (!$user) {
            return $this->errorResponse(null, 'Email anda tidak terdaftar.', 401);
        }

        $user = Auth::user();
        return $this->successResponse($user, 'Login berhasil.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
