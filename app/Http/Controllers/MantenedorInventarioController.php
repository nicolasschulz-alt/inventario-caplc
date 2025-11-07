<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InventarioController;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class MantenedorInventarioController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            'auth', // Middleware global para este controlador

            new Middleware('VerificarAccesoSistema:1'),
            new Middleware('BloquearRoles:1,1', except: [
                'index',
                'ubicacion_list',
            ]),

        ];
    }

    public function index(){

        return view('mantenedores.inventario.mantenedor-inventario');
    }

    
    public function ubicacion_list(Request $request){

        try {

            $sala_list = DB::table('sala')
                            ->select(
                                DB::Raw('edificio.nombre as nombre_edificio'),
                                DB::Raw('piso.nombre as nombre_piso'),
                                'sala.id',
                                'sala.numero_sala',
                                'sala.nombre_sala'
                            )
                            ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
                            ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
                            ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
                            ->orderBy('edificio.nombre','asc')
                            ->orderBy('piso.id','asc')
                            ->orderBy('edificio_piso.id','asc')
                            ->get();

            $html = View::make('mantenedores.inventario.content.tablaListaUbicacion', ['sala_list' => $sala_list])->render();
            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500,'error' => $e->getMessage()],500);
        }
        

    }

    public function ubicacion_update(Request $request){

        $sala_id = $request->sala_id;

        DB::beginTransaction();

        try {
            
            $sala                   = Sala::find($sala_id);
            $sala->nombre_sala      = $request->nombre_sala;
            $sala->save();

            DB::commit();
            return response()->json(['status' => 201, 'error' => null], 201);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public function include_formulario_ubicacion_editar($sala_id){

        try {

            $data = DB::table('sala')
                            ->select(
                                DB::Raw('edificio.nombre as nombre_edificio'),
                                DB::Raw('piso.nombre as nombre_piso'),
                                'sala.id',
                                'sala.numero_sala',
                                'sala.nombre_sala'
                                )
                            ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
                            ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
                            ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
                            ->where('sala.id','=',$sala_id)
                            ->orderBy('edificio.nombre','asc')
                            ->orderBy('piso.id','asc')
                            ->orderBy('edificio_piso.id','asc')
                            ->first();

            $html = View::make('mantenedores.inventario.content.formEditarUbicacion', 
                                [
                                    'sala_id' => $sala_id,
                                    'data'    => $data,
                                ]
                                )->render();

            
            return response()->json($html,200);

        } catch (\Exception $e) {
            //echo $e;
            return response()->json($e->getMessage(),500);
        }

    }

    public function ubicacion_create(Request $request){

        $sala_id = null;
        

        DB::beginTransaction();

        $inventario = new InventarioController;

        try {

            $status = 200;
            $sala_id = null;

            if (isset($request->edificio_piso) && isset($request->numero_sala) && isset($request->nombre_sala)){
                
                if ($inventario->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala) == null){
                    $sala                   = new Sala();
                    $sala->numero_sala      = $request->numero_sala;
                    $sala->nombre_sala      = $request->nombre_sala;
                    $sala->edificio_piso_id = $request->edificio_piso;
                    $sala->save();
                    $sala_id = $sala->id;
                    $status = 201;
                } else {
                    $status = 200;
                    $sala_id = $inventario->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala);
                }

            }

            DB::commit();
            return response()->json(['status' => $status, 'error' => null, 'sala_id' => $sala_id], $status);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function include_formulario_ubicacion_crear(){

        try {

            $edificio_piso = DB::table('edificio_piso')
                                ->select(
                                    'edificio_piso.id',
                                    DB::Raw('edificio.nombre as nombre_edificio'),
                                    DB::Raw('piso.nombre as nombre_piso')
                                    )
                                ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
                                ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
                                ->orderBy('edificio.nombre','asc')
                                ->orderBy('piso.id','asc')
                                ->orderBy('edificio_piso.id','asc')
                                ->get();

            $html = View::make('mantenedores.inventario.content.formRegUbicacion', ['edificio_piso' => $edificio_piso])->render();

            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }

    }


}
