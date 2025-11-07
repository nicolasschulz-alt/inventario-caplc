<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Permiso;

class VerificarRol
{

    public function handle($request, Closure $next, $sistema_id, ...$roles)
    {
        $user_id = Auth::user()->id;

        $tiene_sistema = true;
        $bloquea_rol = false;

        if (empty($roles)){

            $tiene_sistema = Permiso::where('user_id', $user_id)
            ->where('sistema_id', $sistema_id)
            ->exists();

        } else {

            $bloquea_rol = Permiso::where('user_id', $user_id)
            ->where('sistema_id', $sistema_id)
            ->whereIn('rol_id',$roles)
            ->exists();

        }

        if (!$tiene_sistema) {
            //return redirect('/access-denied');
            return redirect()->route('access-denied');
        }
        if ($bloquea_rol){
            abort(403, 'Acceso denegado');
        }

        return $next($request);
    }

}
