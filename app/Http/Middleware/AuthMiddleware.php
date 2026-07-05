<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah session auth_role ada
        if (!session('auth_role')) {
            return redirect('/log-in')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        return $next($request);
    }
}