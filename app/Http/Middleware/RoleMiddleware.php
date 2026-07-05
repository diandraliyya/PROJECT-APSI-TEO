<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Cek apakah sudah login
        if (!session('auth_role')) {
            return redirect('/log-in')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        // Cek apakah role sesuai
        if (session('auth_role') !== $role) {
            // Jika role tidak sesuai, redirect ke halaman sesuai role
            if (session('auth_role') === 'admin') {
                return redirect('/home-admin');
            } elseif (session('auth_role') === 'anggota') {
                return redirect('/home-anggota');
            }
            
            return redirect('/log-in');
        }

        return $next($request);
    }
}