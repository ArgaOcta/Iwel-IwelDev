<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    // Tambahkan ...$roles agar bisa menerima banyak role sekaligus
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika user belum login, atau rolenya TIDAK ADA di dalam daftar role yang diizinkan
        if (! $request->user() || ! in_array($request->user()->role, $roles)) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}