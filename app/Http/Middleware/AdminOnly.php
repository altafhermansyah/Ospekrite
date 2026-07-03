<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Restrict access to users with 'dewa' or 'admin' roles only.
     *
     * Any authenticated user without the correct role will receive a 403.
     * Unauthenticated users are handled by the 'auth' middleware upstream.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['dewa', 'admin'])) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
