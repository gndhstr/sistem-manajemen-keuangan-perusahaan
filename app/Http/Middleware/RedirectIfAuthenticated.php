<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // Pengguna sudah terautentikasi
            $user = Auth::user();
    
            // Logika redirect sesuai dengan peran pengguna
            if ($user->role == "1") {
                return redirect('/admin');
            } elseif ($user->role == "2") {
                return redirect('/direktur');
            } elseif ($user->role == "3") {
                return redirect('/manajer');
            } elseif ($user->role == "4") {
                return redirect('/karyawan');
            }
        }
    
        // Pengguna belum terautentikasi, arahkan ke halaman login
        return $next($request);
    }
}
