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
            return redirect('/');
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
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleCallback(Request $request)
    {
        try {
            $getCallback = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Failed to retrieve user details from Google.', 401);
        }

        $user = User::where('email', $getCallback->email)->first();

        if (!$user) {
            return redirect('/login');
        }

        Auth::login($user);
        return redirect('/');

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
