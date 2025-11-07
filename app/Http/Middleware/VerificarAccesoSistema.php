<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Permiso;

class VerificarAccesoSistema
{
    public function handle(Request $request, Closure $next, $sistema_id)
    {
        $user_id = Auth::user()->id;

        $tiene_sistema = Permiso::where('user_id', $user_id)
        ->where('sistema_id', $sistema_id)
        ->exists();

        if (!$tiene_sistema) {
            //return redirect('/access-denied');
            return redirect()->route('access-denied');
        }

        return $next($request);
    }
}
