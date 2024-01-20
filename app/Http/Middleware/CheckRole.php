<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        }

        $user = Auth::user();

        if ($user->role == $role) {
            return $next($request);
        }
        
        if ($user->role == 'admin') {
            return redirect('/admin');
        } else {
            return redirect('/');
        }
    }
}