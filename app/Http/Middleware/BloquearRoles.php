<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Permiso;

class BloquearRoles
{
    public function handle(Request $request, Closure $next, $sistema_id, ...$roles)
    {

        $user_id = Auth::id();

        if (!empty($roles)){

            $bloquea_rol = Permiso::where('user_id', $user_id)
            ->where('sistema_id', $sistema_id)
            ->whereIn('rol_id',$roles)
            ->exists();

            if ($bloquea_rol){
                abort(403, 'Acceso denegado');
            }

        }

        return $next($request);
    }
}
