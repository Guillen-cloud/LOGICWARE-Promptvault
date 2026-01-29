<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lista de correos electrónicos permitidos como administradores
        $adminEmails = [
            'layer@gmail.com', //123123123 contra <--- Asegúrate de que este sea EXACTAMENTE el correo con el que iniciaste sesión
            'admin@promptvault.com',
        ];

        if (!Auth::check() || !in_array(Auth::user()->email, $adminEmails)) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
