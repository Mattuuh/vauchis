<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarAdministrador
{
    private const TIEMPO_MAXIMO_INACTIVIDAD = 600; // 10 minutos en segundos

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*
         * Verificar que exista la información de autenticación.
         *
         * Según la estructura que vienes utilizando:
         * session('auth.tu_id')
         */
        if (!$request->session()->has('auth')) {
            return redirect()
                ->route('login')
                ->with('error', 'Debes iniciar sesión para acceder.');
        }

        $datosUsuario = $request->session()->get('auth');

        /*
         * Verificar que el usuario sea administrador.
         * tu_id = 1 representa administrador.
         */
        if (
            !is_array($datosUsuario) ||
            !isset($datosUsuario['tu_id']) ||
            (int) $datosUsuario['tu_id'] !== 1
        ) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        /*
         * Verificar tiempo de inactividad.
         */
        $ultimaActividad = $request->session()->get('ultima_actividad');

        if (
            $ultimaActividad !== null &&
            now()->timestamp - (int) $ultimaActividad
                > self::TIEMPO_MAXIMO_INACTIVIDAD
        ) {
            $request->session()->flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Tu sesión finalizó por permanecer inactiva durante más de 10 minutos.'
                );
        }

        /*
         * Renovar la última actividad con cada petición administrativa.
         */
        $request->session()->put('ultima_actividad', now()->timestamp);

        /*
         * Compartir un atributo adicional con la petición.
         */
        $request->attributes->set('es_administrador', true);

        return $next($request);
    }
}
