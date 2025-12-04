<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user login DAN role-nya admin
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, tolak akses (403 Forbidden)
        abort(403, 'Akses ditolak. Halaman ini khusus Administrator.');
    }
}