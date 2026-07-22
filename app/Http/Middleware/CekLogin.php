<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekLogin
{
    public function handle(Request $request, Closure $next)
    {
        // IZINKAN JIKA SUDAH LOGIN
        if (session()->has('login')) {
            return $next($request);
        }

        // JIKA BELUM LOGIN
        return redirect('/login');
    }
}