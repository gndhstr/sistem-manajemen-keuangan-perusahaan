<?php

namespace App\Http\Middleware;

use Closure;

class Manajer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()-> role == 'Manajer') {
            return $next($request);
        }
        return redirect('/');
    }
}
