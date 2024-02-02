<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        }

        $user = Auth::user();

        if ($user->role == $role || $user->role == 'admin') {
            return $next($request);
        }

        return redirect('/');
    }
}
