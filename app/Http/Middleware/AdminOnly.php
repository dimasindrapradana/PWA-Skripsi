<?php

// app/Http/Middleware/AdminOnly.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        Auth::logout();
        abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses panel ini.');
    }
}

