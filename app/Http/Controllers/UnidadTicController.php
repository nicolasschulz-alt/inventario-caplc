<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use App\Models\Pc;
use App\Models\Impresora;
use App\Models\Anexo;
use App\Models\Huellero;
use App\Models\Monitor;

class UnidadTicController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            'auth', // Middleware global para este controlador
            new Middleware('VerificarAccesoSistema:1'),
        ];
    }

    public function index(){

        $pc = Pc::count();
        $impresoras = Impresora::count();
        $anexos = Anexo::count();
        $huelleros = Huellero::count();
        $monitores = Monitor::count();

        return view('tic.index')
             ->with('pc',$pc)
             ->with('impresoras',$impresoras)
             ->with('anexos',$anexos)
             ->with('huelleros',$huelleros)
             ->with('monitores',$monitores);
    }
}
