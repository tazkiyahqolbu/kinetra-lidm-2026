<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Pastikan user sudah login dan memiliki role yang sesuai
        if (!Auth::check() || Auth::user()->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Anda tidak memiliki akses ke halaman ini.'], 403);
            }

            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
