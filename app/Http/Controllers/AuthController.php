<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
                'email' => 'required|email|max:50|exists:users,email',
                'password' => 'required|min:8|max:20',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
            }

            if (!Auth::attempt($request->only('email', 'password'))) {
                return $this->errorResponse(null, 'Password tidak valid.', 401);
            }

            $user = Auth::user();
            return $this->successResponse($user, 'Login berhasil.');
        }

        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255|exists:users,email',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
            }

            $status = Password::sendResetLink($request->only('email'));

            if ($status === Password::RESET_LINK_SENT) {
                return $this->successResponse(null, 'Reset password email terkirim.');
            } else {
                return $this->errorResponse(null, 'Reset password email gagal dikirim.');
            }
        }

        return view('auth.forgot-password');
    }

    public function resetPassword(Request $request, $token = null)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'token' => 'required|max:255',
                'email' => 'required|email|max:50|exists:users,email',
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

            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return $this->successResponse(null, 'Password berhasil direset.');
            } else {
                return $this->errorResponse(null, 'Password gagal direset.');
            }
        }
        return view('auth.reset-password', compact('token'));
    }

    public function updateFCMToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $user = Auth::user();

        if (!$user) {
            return $this->errorResponse(null, 'Data Karyawan tidak ditemukan.', 404);
        }

        $user->update([
            'fcm_token' => $request->token,
        ]);

        return $this->successResponse($user, 'Data FCM Token diupdate.');
    }
}
