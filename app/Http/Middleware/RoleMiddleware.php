<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            abort(403, 'Anda belum login');
        }

        $userRole = Auth::user()->role;

        if (!in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki akses');
        }

        return $next($request);
    }
}