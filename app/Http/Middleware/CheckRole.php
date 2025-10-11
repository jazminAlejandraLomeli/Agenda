<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
 
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $requiredRoles): Response
    {
        if (Auth::check()) { // Obtiene los roles del usuario desde la sesión
            $userRoles = Auth::user()->roles;
            // Verifica si alguno de los roles del usuario coincide con el rol requerido
            foreach ($userRoles as $role) {
                if ($role->name === $requiredRoles) {
                    return $next($request);   // Si coincide, permite que la solicitud continúe
                }
            }
        }
        // Si no tiene ninguno de los roles requeridos, retorna un 403
        abort(403, 'Acceso prohibido');
    
    }
}
