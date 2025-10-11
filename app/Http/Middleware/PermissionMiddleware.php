<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {

        if (!Auth::check()) return redirect()->route('login');

        $user = Auth::user();

        foreach ($permissions as $permission) {
            if (!$user->can($permission)) {
                abort(403, 'No tienes permiso para acceder a esta página');
            }
        }

        return $next($request);
    }
}
