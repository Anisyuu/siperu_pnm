<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (!$user) {
            abort(401);
        }

        if (!$user->hasRole($roles)) {
            abort(403, 'Kamu tidak punya akses.');
        }

        return $next($request);
    }
}
