<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pc;
use App\Models\PcApp;
use App\Models\Impresora;
use App\Models\Sala;
use App\Models\Anexo;
use App\Models\ModeloDispositivo;
use App\Models\MarcaDispositivo;
use App\Models\ConexionImpresora;
use App\Models\Huellero;
use App\Models\Monitor;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PcExport;
use App\Exports\ImpresoraExport;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class InventarioController extends Controller implements HasMiddleware

{
    public static function middleware(): array
    {
        return [
            'auth', // Middleware global para este controlador
            new Middleware('VerificarAccesoSistema:1'),
            new Middleware('BloquearRoles:1,3', only: [
                'pc_delete',
                'impresora_delete',
                'anexo_delete',
                'huellero_delete',
                'monitor_delete',
            ]),
            new Middleware('BloquearRoles:1,1', except: [
                'pc',
                'pc_list',
                'pc_detalle',
                'include_detalle_pc',

                'impresoras',
                'impresora_list',
                'impresora_detalle',
                'include_detalle_impresora',

                'anexos',
                'anexo_list',
                'anexo_detalle',
                'include_detalle_anexo',

                'huelleros',
                'huellero_list',
                'huellero_detalle',
                'include_detalle_huellero',

                'monitores',
                'monitor_list',
                'monitor_detalle',
                'include_detalle_monitor',
            ]),
        ];
    }

    public function pc(){

        return view('inventario.pc');
        
    }

    public function pc_list(Request $request){

        try {

            $pc_list = DB::table('pc')
                        ->select(
                                DB::Raw('pc.id as pc_id'),
                                'pc.serie','pc.num_inventario', 
                                'pc.estado_id',
                                DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
                                'ip.direccion_ip',
                                DB::Raw('edificio.nombre as nombre_edificio'),
                                DB::Raw('piso.nombre as nombre_piso'),
                                DB::Raw('sala.id as sala_id'),
                                'sala.numero_sala',
                                'sala.nombre_sala',
                                DB::Raw('marca_dispositivo.nombre as nombre_marca'),
                                DB::Raw('modelo_dispositivo.nombre as nombre_modelo')
                        )
                        ->leftJoin('sala','sala.id','=','sala_id')
                        ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
                        ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
                        ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
                        ->leftJoin('ip','ip.id','=','pc.ip_id')
                        ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','pc.estado_id')
                        ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','pc.marca_id')
                        ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','pc.modelo_id')
                        ->orderBy('pc.id','desc')
                        ->get();

            $html = View::make('inventario.content.pc.tablaListaPc', ['pc_list' => $pc_list])->render();
            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500,'error' => $e->getMessage()],500);
        }
        

    }

    public function pc_detalle($pc_id){

        $cat_app_so = 1;
        $cat_app_office = 3;
        $cat_app_antivirus = 2;
        $cat_app_escritorio = 4;

        $pc =  PC::select(
                DB::Raw('pc.id as pc_id'),
                DB::Raw('upper(pc.serie) as serie'),
                'pc.num_inventario', 
                'pc.estado_id',
                DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
                'ip.id as ip_id',
                'ip.direccion_ip',
                DB::Raw('edificio.nombre as nombre_edificio'),
                DB::Raw('piso.nombre as nombre_piso'),
                DB::Raw('sala.id as sala_id'),
                'sala.numero_sala',
                'sala.nombre_sala',
                'nombre_equipo',
                'nombre_usuario_ad',
                'marca_id',
                'modelo_id',
                'marca_dispositivo.nombre as nombre_marca',
                'modelo_dispositivo.nombre as nombre_modelo',
                'tipo_id',
                'tipo_pc.nombre as tipo_pc',
                'cpu_id',
                'cpu_pc.nombre as cpu',
                'ram_id',
                'ram_pc.nombre as ram',
                'disco_id',
                'disco_pc.nombre as disco',
                'candado_id',
                'candado.nombre as candado',
                'corriente_id',
                'corriente.nombre as corriente',
                'oc_id',
                'orden_compra.descripcion as orden_compra',
                'pc.observaciones',
                'estado_id',
                'pc.propietario_id',
                'propietario.nombre as nombre_propietario'
        )
        ->leftJoin('sala','sala.id','=','pc.sala_id')
        ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
        ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
        ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
        ->leftJoin('ip','ip.id','=','pc.ip_id')
        ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','pc.estado_id')
        ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','pc.marca_id')
        ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','pc.modelo_id')
        ->leftJoin('tipo_pc','tipo_pc.id','=','pc.tipo_id')
        ->leftJoin('cpu_pc','cpu_pc.id','=','pc.cpu_id')
        ->leftJoin('ram_pc','ram_pc.id','=','pc.ram_id')
        ->leftJoin('disco_pc','disco_pc.id','=','pc.disco_id')
        ->leftJoin('candado','candado.id','=','pc.candado_id')
        ->leftJoin('corriente','corriente.id','=','pc.corriente_id')
        ->leftJoin('orden_compra','orden_compra.id','=','pc.oc_id')
        ->leftJoin('propietario','propietario.id','=','pc.propietario_id')
        ->where('pc.id','=',$pc_id)
        ->orderBy('pc.id','desc')
        ->first();

        $sistema_operativo = PcApp::leftJoin('app','app.id','=','pc_app.app_id')
                                    ->where('pc_app.pc_id','=',$pc_id)
                                    ->where('app.categoria_id','=',$cat_app_so)
                                    ->orderBy('app.id','asc')
                                    ->first();

        $office = PcApp::leftJoin('app','app.id','=','pc_app.app_id')
                        ->where('pc_app.pc_id','=',$pc_id)
                        ->where('app.categoria_id','=',$cat_app_office)
                        ->orderBy('app.id','asc')
                        ->first();

        $antivirus = PcApp::leftJoin('app','app.id','=','pc_app.app_id')
                        ->where('pc_app.pc_id','=',$pc_id)
                        ->where('app.categoria_id','=',$cat_app_antivirus)
                        ->orderBy('app.id','asc')
                        ->first();

        $app_ecritorio = PcApp::leftJoin('app','app.id','=','pc_app.app_id')
                                ->where('pc_app.pc_id','=',$pc_id)
                                ->where('app.categoria_id','=',$cat_app_escritorio)
                                ->orderBy('app.id','asc')
                                ->get();

        if (isset($pc)){
            $pc->sistema_operativo = isset($sistema_operativo) ? $sistema_operativo : null;
            $pc->office = isset($office) ? $office : null;
            $pc->antivirus = isset($antivirus) ? $antivirus : null;
            $pc->app_ecritorio = $app_ecritorio->isNotEmpty() ? $app_ecritorio : null;
        }

        return $pc;

    }

    public function pc_create(Request $request){

        $sala_id = null;

        DB::beginTransaction();

        try {

            if (isset($request->sala_id)){

                $sala_id = $request->sala_id;

            } else if (isset($request->edificio_piso) && isset($request->numero_sala) && isset($request->nombre_sala)){
                
                if ($this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala) == null){
                    $sala                   = new Sala();
                    $sala->numero_sala      = $request->numero_sala;
                    $sala->nombre_sala      = $request->nombre_sala;
                    $sala->edificio_piso_id = $request->edificio_piso;
                    $sala->save();
                    $sala_id = $sala->id;
                } else {
                    $sala_id = $this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala);
                }

            }
        
            $pc                          = new Pc();
            $pc->sala_id                 = $sala_id;
            $pc->nombre_equipo           = $request->nombre_equipo;
            $pc->nombre_usuario_ad       = $request->nombre_usuario_ad;
            $pc->estado_id               = $request->estado_id;
            $pc->marca_id                = $request->marca_id;
            $pc->modelo_id               = $request->modelo_id;
            $pc->tipo_id                 = $request->tipo_id;            
            $pc->cpu_id                  = $request->cpu_id;
            $pc->ram_id                  = $request->ram_id;
            $pc->disco_id                = $request->disco_id;
            $pc->serie                   = $request->serie;
            $pc->ip_id                   = $request->ip_id;
            $pc->oc_id                   = $request->oc_id;
            $pc->num_inventario          = $request->num_inventario;
            $pc->candado_id              = $request->candado_id;
            $pc->corriente_id            = $request->corriente_id;
            $pc->observaciones           = $request->observaciones;
            $pc->propietario_id          = $request->propietario_id;
            $pc->user_crea_id            = Auth::user()->id;
            $pc->fecha_crea              = Carbon::now()->format('Y-m-d H:i:s');
            $pc->save();

            if (isset($request->apps) && is_array($request->apps)){

                if (count($request->apps) > 0){
                    foreach ($request->apps as $value){
                        $pc_app                 = new PcApp();
                        $pc_app->pc_id          = $pc->id; 
                        $pc_app->app_id         = $value['app_id']; 
                        $pc_app->tiene_licencia = $value['apl_licencia'];
                        $pc_app->licencia       = $value['licencia'];
                        $pc_app->save();
                    }
                }
            }

            DB::commit();
            return response()->json(['status' => 201, 'error' => null], 201);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function pc_update(Request $request){

        $pc_id = $request->pc_id;
        $sala_id = null;
        $cat_app_escritorio = 4;

        DB::beginTransaction();

        try {

            if (isset($request->sala_id)){

                $sala_id = $request->sala_id;

            } else if (isset($request->edificio_piso) && isset($request->numero_sala) && isset($request->nombre_sala)){
                
                if ($this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala) == null){
                    $sala                   = new Sala();
                    $sala->numero_sala      = $request->numero_sala;
                    $sala->nombre_sala      = $request->nombre_sala;
                    $sala->edificio_piso_id = $request->edificio_piso;
                    $sala->save();
                    $sala_id = $sala->id;
                } else {
                    $sala_id = $this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala);
                }

            }
        
            $pc                          = Pc::find($pc_id);
            $pc->sala_id                 = $sala_id;
            $pc->nombre_equipo           = $request->nombre_equipo;
            $pc->nombre_usuario_ad       = $request->nombre_usuario_ad;
            $pc->estado_id               = $request->estado_id;
            $pc->marca_id                = $request->marca_id;
            $pc->modelo_id               = $request->modelo_id;
            $pc->tipo_id                 = $request->tipo_id;
            $pc->cpu_id                  = $request->cpu_id;
            $pc->ram_id                  = $request->ram_id;
            $pc->disco_id                = $request->disco_id;
            $pc->serie                   = $request->serie;
            $pc->ip_id                   = $request->ip_id;
            $pc->oc_id                   = $request->oc_id;
            $pc->num_inventario          = $request->num_inventario;
            $pc->candado_id              = $request->candado_id;
            $pc->corriente_id            = $request->corriente_id;
            $pc->observaciones           = $request->observaciones;
            $pc->propietario_id          = $request->propietario_id;
            $pc->user_mod_id             = Auth::user()->id;
            $pc->fecha_mod               = Carbon::now()->format('Y-m-d H:i:s');
            $pc->save();

            if (isset($request->apps) && is_array($request->apps)){

                if (count($request->apps) > 0){

                    $result = PcApp::where('pc_app.pc_id','=',$pc_id)->delete();
                    
                    foreach ($request->apps as $value){
                        $pc_app                 = new PcApp();
                        $pc_app->pc_id          = $pc_id; 
                        $pc_app->app_id         = $value['app_id']; 
                        $pc_app->tiene_licencia = $value['apl_licencia'];
                        $pc_app->licencia       = $value['licencia'];
                        $pc_app->save();
                    }
                }
            }

            DB::commit();
            return response()->json(['status' => 201, 'error' => null], 201);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public function pc_delete($pc_id){

        DB::beginTransaction();
        try {

            $pc_app = PcApp::where('pc_id',$pc_id);
            $pc_app->delete();

            $pc = Pc::find($pc_id);
            $pc->delete();
            
            DB::commit();
            return response()->json(['status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    

    public function comprobar_ubicacion($edificio_piso,$numero_sala,$nombre_sala){

        $sala = null;
        $sala_id = null;

        $numero_sala = strtoupper($numero_sala);
        $nombre_sala = strtoupper($nombre_sala);
        
        if (isset($edificio_piso) && isset($numero_sala) && isset($nombre_sala)){

            $sala = Sala::where(DB::Raw('upper(numero_sala)'),'=',$numero_sala)
                         ->where(DB::Raw('upper(nombre_sala)'),'=',$nombre_sala)
                         ->where('edificio_piso_id','=',$edificio_piso)
                         ->first();

            if (isset($sala)){
                $sala_id = $sala->id;
            }

        }

        return $sala_id;

    }

    
    

    private function comprobar_anexo($anexo_buscar){

        $anexo = null;
        $anexo_id = null;
        
        if (isset($anexo_buscar)){

            $anexo = Anexo::where('anexo','=',$anexo_buscar)->first();

            if (isset($anexo)){
                $anexo_id = $anexo->id;
            }

        }

        return $anexo_id;

    }

    public function comprobar_serie_pc($serie = null){
        $pc = null;
        $serie_pc = null;
        try {

            if (isset($serie)){

                $serie = strtoupper(trim($serie));
    
                $pc = PC::where(DB::Raw('upper(serie)'),'=',$serie)->first();
    
                if (isset($pc)){
                    $serie_pc = $pc->serie;
                }
    
            }
                        
            return response()->json(['serie' => $serie_pc ,'status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
        
    }

    public function obtener_modelos_por_tipo($tipo_id = null){
        $modelos = null;
        try {

            if (isset($tipo_id)){
    
                $modelos = ModeloDispositivo::where('tipo_dispositivo_id','=',$tipo_id)
                                            ->get();

            }
                        
            return response()->json(['modelos' => $modelos ,'status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
        
    }

    public function obtener_modelos_por_tipo_marca($tipo_id = null,$marca_id = null){
        $modelos = null;
        try {

            if (isset($tipo_id) && isset($marca_id)){
    
                $modelos = ModeloDispositivo::where('tipo_dispositivo_id','=',$tipo_id)
                                            ->where('marca_dispositivo_id','=',$marca_id)
                                            ->get();

            }
                        
            return response()->json(['modelos' => $modelos ,'status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function obtener_marca_por_modelo($modelo_id = null){
        $marca = null;
        try {

            if (isset($modelo_id)){
    
                $marca = MarcaDispositivo::select('marca_dispositivo.id as marca_id','marca_dispositivo.nombre')
                                         ->join('modelo_dispositivo','modelo_dispositivo.marca_dispositivo_id','=','marca_dispositivo.id')
                                         ->where('modelo_dispositivo.id','=',$modelo_id)
                                         ->first();

            }
                        
            return response()->json(['marca' => $marca ,'status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
        
    }
    

    public function include_formulario_pc_crear(){

        $tipo_dispositivo_id = 1;
        $cat_app_so = 1;
        $cat_app_office = 3;
        $cat_app_antivirus = 2;
        $cat_app_escritorio = 4;

        try {

            $ip_list = DB::table('ip')
                            ->orderBy('ip.id','asc')
                            ->get();

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

            $tipo_pc = DB::table('tipo_pc')
                            ->orderBy('tipo_pc.id','asc')
                            ->get();

            $marca_pc = DB::table('marca_dispositivo')
                            ->select('marca_dispositivo.id','marca_dispositivo.nombre')
                            ->where('marca_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('marca_dispositivo.id','asc')
                            ->get();

            $modelo_pc = DB::table('modelo_dispositivo')
                            ->select('modelo_dispositivo.id',DB::Raw('upper(modelo_dispositivo.nombre) as nombre_modelo'),'marca_dispositivo.nombre as nombre_marca')
                            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','modelo_dispositivo.marca_dispositivo_id')
                            ->where('modelo_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('modelo_dispositivo.nombre','asc')
                            ->get();

            $cpu_pc = DB::table('cpu_pc')
                        ->select('cpu_pc.id',DB::Raw('upper(cpu_pc.nombre) as nombre'))
                        ->orderBy('cpu_pc.nombre','asc')
                        ->get();

            $ram_pc = DB::table('ram_pc')
                            ->orderBy('ram_pc.nombre','asc')
                            ->get();

            $disco_pc = DB::table('disco_pc')
                            ->select('disco_pc.id',DB::Raw('upper(tipo_disco_pc.nombre) as nombre_tipo_disco'),'disco_pc.nombre as nombre_disco')
                            ->leftJoin('tipo_disco_pc','tipo_disco_pc.id','disco_pc.tipo_disco_id')
                            ->orderBy('disco_pc.id','asc')
                            ->get();

            $estado_candado = DB::table('candado')
                                ->orderBy('candado.id','asc')
                                ->get();

            $corriente = DB::table('corriente')
                            ->orderBy('corriente.id','asc')
                            ->get();

            $orden_compra = DB::table('orden_compra')
                                ->orderBy('orden_compra.id','asc')
                                ->get();

            $propietario = DB::table('propietario')
                                ->orderBy('propietario.id','asc')
                                ->get();

            $estado_dispositivo = DB::table('estado_dispositivo')
                                    ->orderBy('estado_dispositivo.id','asc')
                                    ->get();

            $sistema_operativo = DB::table('app')
                                    ->where('app.categoria_id','=',$cat_app_so)
                                    ->orderBy('app.id','asc')
                                    ->get();
                                
            $office = DB::table('app')
                        ->where('app.categoria_id','=',$cat_app_office)
                        ->orderBy('app.id','asc')
                        ->get();

            $antivirus = DB::table('app')
                            ->where('app.categoria_id','=',$cat_app_antivirus)
                            ->orderBy('app.id','asc')
                            ->get();

            $app_ecritorio = DB::table('app')
                                ->where('app.categoria_id','=',$cat_app_escritorio)
                                ->orderBy('app.id','asc')
                                ->get();


            $html = View::make('inventario.content.pc.formRegPcCrear', 
                                [
                                    'ip_list'               => $ip_list,
                                    'sala_list'             => $sala_list,
                                    'edificio_piso'         => $edificio_piso,
                                    'tipo_pc'               => $tipo_pc,
                                    'marca_pc'              => $marca_pc,
                                    'modelo_pc'             => $modelo_pc,
                                    'cpu_pc'                => $cpu_pc,
                                    'ram_pc'                => $ram_pc,
                                    'disco_pc'              => $disco_pc,
                                    'estado_candado'        => $estado_candado,
                                    'corriente'             => $corriente,
                                    'orden_compra'          => $orden_compra,
                                    'propietario'           => $propietario,
                                    'estado_dispositivo'    => $estado_dispositivo,
                                    'sistema_operativo'     => $sistema_operativo,
                                    'office'                => $office,
                                    'antivirus'             => $antivirus,
                                    'app_ecritorio'         => $app_ecritorio,

                                ]
                                )->render();

            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }

    }

    public function include_formulario_pc_editar($pc_id){

        $tipo_dispositivo_id = 1;
        $cat_app_so = 1;
        $cat_app_office = 3;
        $cat_app_antivirus = 2;
        $cat_app_escritorio = 4;

        try {

            $data = $this->pc_detalle($pc_id);

            $ip_list = DB::table('ip')
                            ->orderBy('ip.id','asc')
                            ->get();

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

            $tipo_pc = DB::table('tipo_pc')
                            ->orderBy('tipo_pc.id','asc')
                            ->get();

            $marca_pc = DB::table('marca_dispositivo')
                            ->select('marca_dispositivo.id','marca_dispositivo.nombre')
                            ->where('marca_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('marca_dispositivo.id','asc')
                            ->get();

            $modelo_pc = DB::table('modelo_dispositivo')
                            ->select('modelo_dispositivo.id',DB::Raw('upper(modelo_dispositivo.nombre) as nombre_modelo'),'marca_dispositivo.nombre as nombre_marca')
                            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','modelo_dispositivo.marca_dispositivo_id')
                            ->where('modelo_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('modelo_dispositivo.nombre','asc')
                            ->get();

            $cpu_pc = DB::table('cpu_pc')
                        ->select('cpu_pc.id',DB::Raw('upper(cpu_pc.nombre) as nombre'))
                        ->orderBy('cpu_pc.nombre','asc')
                        ->get();

            $ram_pc = DB::table('ram_pc')
                            ->orderBy('ram_pc.nombre','asc')
                            ->get();

            $disco_pc = DB::table('disco_pc')
                            ->select('disco_pc.id',DB::Raw('upper(tipo_disco_pc.nombre) as nombre_tipo_disco'),'disco_pc.nombre as nombre_disco')
                            ->leftJoin('tipo_disco_pc','tipo_disco_pc.id','disco_pc.tipo_disco_id')
                            ->orderBy('disco_pc.id','asc')
                            ->get();

            $estado_candado = DB::table('candado')
                                ->orderBy('candado.id','asc')
                                ->get();

            $corriente = DB::table('corriente')
                            ->orderBy('corriente.id','asc')
                            ->get();

            $orden_compra = DB::table('orden_compra')
                                ->orderBy('orden_compra.id','asc')
                                ->get();

            $anexo = DB::table('anexo')
                            ->orderBy('anexo.anexo','asc')
                            ->get();
            
            $propietario = DB::table('propietario')
                            ->orderBy('propietario.id','asc')
                            ->get();

            $estado_dispositivo = DB::table('estado_dispositivo')
                                    ->orderBy('estado_dispositivo.id','asc')
                                    ->get();

            $sistema_operativo = DB::table('app')
                                    ->where('app.categoria_id','=',$cat_app_so)
                                    ->orderBy('app.id','asc')
                                    ->get();
                                
            $office = DB::table('app')
                        ->where('app.categoria_id','=',$cat_app_office)
                        ->orderBy('app.id','asc')
                        ->get();

            $antivirus = DB::table('app')
                            ->where('app.categoria_id','=',$cat_app_antivirus)
                            ->orderBy('app.id','asc')
                            ->get();

            $app_ecritorio = DB::table('app')
                                ->where('app.categoria_id','=',$cat_app_escritorio)
                                ->orderBy('app.id','asc')
                                ->get();


            $html = View::make('inventario.content.pc.formRegPcEditar', 
                                [
                                    'pc_id'                 => $pc_id,
                                    'data'                  => $data,
                                    'ip_list'               => $ip_list,
                                    'sala_list'             => $sala_list,
                                    'edificio_piso'         => $edificio_piso,
                                    'tipo_pc'               => $tipo_pc,
                                    'marca_pc'              => $marca_pc,
                                    'modelo_pc'             => $modelo_pc,
                                    'cpu_pc'                => $cpu_pc,
                                    'ram_pc'                => $ram_pc,
                                    'disco_pc'              => $disco_pc,
                                    'estado_candado'        => $estado_candado,
                                    'corriente'             => $corriente,
                                    'orden_compra'          => $orden_compra,
                                    'anexo'                 => $anexo,
                                    'propietario'           => $propietario,
                                    'estado_dispositivo'    => $estado_dispositivo,
                                    'sistema_operativo'     => $sistema_operativo,
                                    'office'                => $office,
                                    'antivirus'             => $antivirus,
                                    'app_ecritorio'         => $app_ecritorio,
                                ]
                                )->render();

            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }

        

    }

    public function include_detalle_pc($pc_id){

        $cat_app_so = 1;
        $cat_app_office = 3;
        $cat_app_antivirus = 2;
        $cat_app_escritorio = 4;

        try {
           
            $pc =  PC::select(
                    DB::Raw('pc.id as pc_id'),
                    'pc.serie',
                    DB::Raw('upper(pc.serie) as serie'),
                    'pc.num_inventario', 
                    'pc.estado_id',
                    'pc.propietario_id',
                    'propietario.nombre as nombre_propietario',
                    DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
                    'ip.direccion_ip',
                    DB::Raw('edificio.nombre as nombre_edificio'),
                    DB::Raw('piso.nombre as nombre_piso'),
                    DB::Raw('sala.id as sala_id'),
                    'sala.numero_sala',
                    'sala.nombre_sala',
                    'nombre_equipo',
                    'nombre_usuario_ad',
                    'marca_id',
                    'marca_dispositivo.nombre as nombre_marca',
                    'modelo_dispositivo.nombre as nombre_modelo',
                    'tipo_pc.nombre as tipo_pc',
                    'cpu_pc.nombre as cpu',
                    'ram_pc.nombre as ram',
                    'disco_pc.nombre as disco',
                    'candado.nombre as candado',
                    'corriente.nombre as corriente',
                    'orden_compra.descripcion as orden_compra',
                    'pc.observaciones',
                    'user_crea.name as nombre_user_crea',
                    DB::Raw("DATE_FORMAT(pc.fecha_crea, '%d/%m/%Y %H:%i') as fecha_user_crea"),
                    'user_mod.name as nombre_user_mod',
                    DB::Raw("DATE_FORMAT(pc.fecha_mod, '%d/%m/%Y %H:%i') as fecha_user_mod")

            )
            ->leftJoin('sala','sala.id','=','pc.sala_id')
            ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
            ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
            ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
            ->leftJoin('ip','ip.id','=','pc.ip_id')
            ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','pc.estado_id')
            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','pc.marca_id')
            ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','pc.modelo_id')
            ->leftJoin('tipo_pc','tipo_pc.id','=','pc.tipo_id')
            ->leftJoin('cpu_pc','cpu_pc.id','=','pc.cpu_id')
            ->leftJoin('ram_pc','ram_pc.id','=','pc.ram_id')
            ->leftJoin('disco_pc','disco_pc.id','=','pc.disco_id')
            ->leftJoin('candado','candado.id','=','pc.candado_id')
            ->leftJoin('corriente','corriente.id','=','pc.corriente_id')
            ->leftJoin('orden_compra','orden_compra.id','=','pc.oc_id')
            ->leftJoin('users as user_crea','user_crea.id','=','pc.user_crea_id')
            ->leftJoin('users as user_mod','user_mod.id','=','pc.user_mod_id')
            ->leftJoin('propietario','propietario.id','=','pc.propietario_id')
            ->where('pc.id','=',$pc_id)
            ->orderBy('pc.id','desc')
            ->first();
            

            $sistema_operativo = PcApp::leftJoin('app','app.id','=','pc_app.app_id')
                                        ->where('pc_app.pc_id','=',$pc_id)
                                        ->where('app.categoria_id','=',$cat_app_so)
                                        ->orderBy('app.id','asc')
                                        ->get();
        
            $office = PcApp::leftJoin('app','app.id','=','pc_app.app_id')
                            ->where('pc_app.pc_id','=',$pc_id)
                            ->where('app.categoria_id','=',$cat_app_office)
                            ->orderBy('app.id','asc')
                            ->get();

            $antivirus = PcApp::leftJoin('app','app.id','=','pc_app.app_id')
                                ->where('pc_app.pc_id','=',$pc_id)
                                ->where('app.categoria_id','=',$cat_app_antivirus)
                                ->orderBy('app.id','asc')
                                ->get();

            $app_ecritorio = PcApp::leftJoin('app','app.id','=','pc_app.app_id')
                                    ->where('pc_app.pc_id','=',$pc_id)
                                    ->where('app.categoria_id','=',$cat_app_escritorio)
                                    ->orderBy('app.id','asc')
                                    ->get();

            if (isset($pc)){
                //$pc->fecha_user_crea = Carbon::parse($pc->fecha_user_crea)->format('d/m/Y H:i');
                //$pc->fecha_user_mod = Carbon::parse($pc->fecha_user_mod)->format('d/m/Y H:i');
                $pc->sistema_operativo = $sistema_operativo->isNotEmpty() ? $sistema_operativo : null;
                $pc->office = $office->isNotEmpty() ? $office : null;
                $pc->antivirus = $antivirus->isNotEmpty() ? $antivirus : null;
                $pc->app_ecritorio = $app_ecritorio->isNotEmpty() ? $app_ecritorio : null;
            }

            //dd($pc);
            
            $html = View::make('inventario.content.pc.detallePcModal',['data' => $pc])->render();

            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }

    }

    
    public function obtener_nombre_sala($numero_sala,$edificio_piso){

        try {

            $result = Sala::select('nombre_sala')
                            ->where('numero_sala','=',$numero_sala)
                            ->where('edificio_piso_id','=',$edificio_piso)
                            ->first();
                        
            return response()->json(['data' => $result ,'status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public function obtener_salas_por_edificio_piso($edificio_piso){

        try {

            $salas = Sala::select('numero_sala')
                            ->where('edificio_piso_id','=',$edificio_piso)
                            ->get();

            return response()->json(['data' => $salas ,'status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public function impresoras(){

        return view('inventario.impresoras');
    }

    public function impresora_list(Request $request){

        try {

            $impresora_list = DB::table('impresora')
                        ->select(
                                DB::Raw('impresora.id as impresora_id'),
                                'impresora.serie',
                                'impresora.num_inventario',
                                'impresora.estado_id',
                                DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
                                'ip.direccion_ip',
                                DB::Raw('edificio.nombre as nombre_edificio'),
                                DB::Raw('piso.nombre as nombre_piso'),
                                DB::Raw('sala.id as sala_id'),
                                'sala.numero_sala',
                                'sala.nombre_sala',
                                DB::Raw('marca_dispositivo.nombre as nombre_marca'),
                                DB::Raw('modelo_dispositivo.nombre as nombre_modelo'),
                                DB::Raw('conexion_impresora.nombre as nombre_conexion')
                        )
                        ->leftJoin('sala','sala.id','=','sala_id')
                        ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
                        ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
                        ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
                        ->leftJoin('ip','ip.id','=','impresora.ip_id')
                        ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','impresora.estado_id')
                        ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','impresora.marca_id')
                        ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','impresora.modelo_id')
                        ->leftJoin('conexion_impresora','conexion_impresora.id','=','impresora.conexion_id')
                        ->orderBy('impresora.id','desc')
                        ->get();

            $html = View::make('inventario.content.impresora.tablaListaImpresora', ['impresora_list' => $impresora_list])->render();
            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500,'error' => $e->getMessage()],500);
        }

    }

    public function impresora_detalle($impresora_id){

        $impresora =  Impresora::select(
                DB::Raw('impresora.id as impresora_id'),
                DB::Raw('upper(impresora.serie) as serie'),
                'impresora.num_inventario', 
                'impresora.estado_id',
                DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
                'ip.id as ip_id',
                'ip.direccion_ip',
                DB::Raw('edificio.nombre as nombre_edificio'),
                DB::Raw('piso.nombre as nombre_piso'),
                DB::Raw('sala.id as sala_id'),
                'sala.numero_sala',
                'sala.nombre_sala',
                'marca_id',
                'modelo_id',
                'marca_dispositivo.nombre as nombre_marca',
                'modelo_dispositivo.nombre as nombre_modelo',
                'tipo_id',
                'tipo_impresora.nombre as tipo_impresora',
                'candado_id',
                'candado.nombre as candado',
                'corriente_id',
                'corriente.nombre as corriente',
                'impresora.observaciones',
                'estado_id',
                'impresora.conexion_id',
                DB::Raw('conexion_impresora.nombre as nombre_conexion'),
                'impresora.propietario_id',
                'propietario.nombre as nombre_propietario'
                
        )
        ->leftJoin('sala','sala.id','=','impresora.sala_id')
        ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
        ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
        ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
        ->leftJoin('ip','ip.id','=','impresora.ip_id')
        ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','impresora.estado_id')
        ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','impresora.marca_id')
        ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','impresora.modelo_id')
        ->leftJoin('tipo_impresora','tipo_impresora.id','=','impresora.tipo_id')
        ->leftJoin('candado','candado.id','=','impresora.candado_id')
        ->leftJoin('corriente','corriente.id','=','impresora.corriente_id')
        ->leftJoin('conexion_impresora','conexion_impresora.id','=','impresora.conexion_id')
        ->leftJoin('propietario','propietario.id','=','impresora.propietario_id')
        ->where('impresora.id','=',$impresora_id)
        ->orderBy('impresora.id','desc')
        ->first();

        return $impresora;

    }

    public function include_detalle_impresora($impresora_id){

        try {
           
            $impresora =  Impresora::select(
                DB::Raw('impresora.id as impresora_id'),
                DB::Raw('upper(impresora.serie) as serie'),
                'impresora.num_inventario', 
                'impresora.estado_id',
                DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
                'ip.id as ip_id',
                'ip.direccion_ip',
                DB::Raw('edificio.nombre as nombre_edificio'),
                DB::Raw('piso.nombre as nombre_piso'),
                DB::Raw('sala.id as sala_id'),
                'sala.numero_sala',
                'sala.nombre_sala',
                'marca_id',
                'modelo_id',
                'marca_dispositivo.nombre as nombre_marca',
                'modelo_dispositivo.nombre as nombre_modelo',
                'tipo_id',
                'tipo_impresora.nombre as tipo_impresora',
                'candado_id',
                'candado.nombre as candado',
                'corriente_id',
                'corriente.nombre as corriente',
                'impresora.observaciones',
                'impresora.propietario_id',
                'propietario.nombre as nombre_propietario',
                'estado_id',
                DB::Raw('conexion_impresora.nombre as nombre_conexion'),
                'user_crea.name as nombre_user_crea',
                DB::Raw("DATE_FORMAT(impresora.fecha_crea, '%d/%m/%Y %H:%i') as fecha_user_crea"),
                'user_mod.name as nombre_user_mod',
                DB::Raw("DATE_FORMAT(impresora.fecha_mod, '%d/%m/%Y %H:%i') as fecha_user_mod")
            )
            ->leftJoin('sala','sala.id','=','impresora.sala_id')
            ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
            ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
            ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
            ->leftJoin('ip','ip.id','=','impresora.ip_id')
            ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','impresora.estado_id')
            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','impresora.marca_id')
            ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','impresora.modelo_id')
            ->leftJoin('tipo_impresora','tipo_impresora.id','=','impresora.tipo_id')
            ->leftJoin('candado','candado.id','=','impresora.candado_id')
            ->leftJoin('corriente','corriente.id','=','impresora.corriente_id')
            ->leftJoin('conexion_impresora','conexion_impresora.id','=','impresora.conexion_id')
            ->leftJoin('users as user_crea','user_crea.id','=','impresora.user_crea_id')
            ->leftJoin('users as user_mod','user_mod.id','=','impresora.user_mod_id')
            ->leftJoin('propietario','propietario.id','=','impresora.propietario_id')
            ->where('impresora.id','=',$impresora_id)
            ->orderBy('impresora.id','desc')
            ->first();

            $html = View::make('inventario.content.impresora.detalleImpresoraModal',['data' => $impresora])->render();

            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }

    }

    public function impresora_create(Request $request){

        $sala_id = null;

        DB::beginTransaction();

        try {

            if (isset($request->sala_id)){

                $sala_id = $request->sala_id;

            } else if (isset($request->edificio_piso) && isset($request->numero_sala) && isset($request->nombre_sala)){
                
                if ($this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala) == null){
                    $sala                   = new Sala();
                    $sala->numero_sala      = $request->numero_sala;
                    $sala->nombre_sala      = $request->nombre_sala;
                    $sala->edificio_piso_id = $request->edificio_piso;
                    $sala->save();
                    $sala_id = $sala->id;
                } else {
                    $sala_id = $this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala);
                }

            }
        
            $impresora                          = new Impresora();
            $impresora->sala_id                 = $sala_id;
            $impresora->estado_id               = $request->estado_id;
            $impresora->marca_id                = $request->marca_id;
            $impresora->modelo_id               = $request->modelo_id;
            $impresora->tipo_id                 = $request->tipo_id;
            $impresora->serie                   = $request->serie;
            $impresora->ip_id                   = $request->ip_id;
            $impresora->num_inventario          = $request->num_inventario;
            $impresora->conexion_id             = $request->conexion_id;
            $impresora->candado_id              = $request->candado_id;
            $impresora->corriente_id            = $request->corriente_id;
            $impresora->observaciones           = $request->observaciones;
            $impresora->user_crea_id            = Auth::user()->id;
            $impresora->fecha_crea              = Carbon::now()->format('Y-m-d H:i:s');
            $impresora->propietario_id          = $request->propietario_id;
            $impresora->save();

            DB::commit();
            return response()->json(['status' => 201, 'error' => null], 201);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function impresora_update(Request $request){

        $impresora_id = $request->impresora_id;
        $sala_id = null;

        DB::beginTransaction();

        try {

            if (isset($request->sala_id)){

                $sala_id = $request->sala_id;

            } else if (isset($request->edificio_piso) && isset($request->numero_sala) && isset($request->nombre_sala)){
                
                if ($this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala) == null){
                    $sala                   = new Sala();
                    $sala->numero_sala      = $request->numero_sala;
                    $sala->nombre_sala      = $request->nombre_sala;
                    $sala->edificio_piso_id = $request->edificio_piso;
                    $sala->save();
                    $sala_id = $sala->id;
                } else {
                    $sala_id = $this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala);
                }

            }
        
            $impresora                          = Impresora::find($impresora_id);
            $impresora->sala_id                 = $sala_id;
            $impresora->estado_id               = $request->estado_id;
            $impresora->marca_id                = $request->marca_id;
            $impresora->modelo_id               = $request->modelo_id;
            $impresora->tipo_id                 = $request->tipo_id;
            $impresora->serie                   = $request->serie;
            $impresora->ip_id                   = $request->ip_id;
            $impresora->num_inventario          = $request->num_inventario;
            $impresora->conexion_id             = $request->conexion_id;
            $impresora->candado_id              = $request->candado_id;
            $impresora->corriente_id            = $request->corriente_id;
            $impresora->observaciones           = $request->observaciones;
            $impresora->user_mod_id             = Auth::user()->id;
            $impresora->fecha_mod               = Carbon::now()->format('Y-m-d H:i:s');
            $impresora->propietario_id          = $request->propietario_id;
            $impresora->save();

            DB::commit();
            return response()->json(['status' => 201, 'error' => null], 201);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public function impresora_delete($impresora_id){

        DB::beginTransaction();
        try {

            $impresora = Impresora::find($impresora_id);
            $impresora->delete();
            
            DB::commit();
            return response()->json(['status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function include_formulario_impresora_editar($impresora_id){

        $tipo_dispositivo_id = 2;

        try {

            $data = $this->impresora_detalle($impresora_id);

            $conexion_impresora = ConexionImpresora::all();

            $ip_list = DB::table('ip')
                            ->orderBy('ip.id','asc')
                            ->get();

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

            $tipo_impresora = DB::table('tipo_impresora')
                            ->orderBy('tipo_impresora.id','asc')
                            ->get();

            $marca_impresora = DB::table('marca_dispositivo')
                            ->select('marca_dispositivo.id','marca_dispositivo.nombre')
                            ->where('marca_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('marca_dispositivo.id','asc')
                            ->get();

            $modelo_impresora = DB::table('modelo_dispositivo')
                            ->select('modelo_dispositivo.id',DB::Raw('upper(modelo_dispositivo.nombre) as nombre_modelo'),'marca_dispositivo.nombre as nombre_marca')
                            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','modelo_dispositivo.marca_dispositivo_id')
                            ->where('modelo_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('modelo_dispositivo.nombre','asc')
                            ->get();

            $estado_candado = DB::table('candado')
                                ->orderBy('candado.id','asc')
                                ->get();

            $corriente = DB::table('corriente')
                            ->orderBy('corriente.id','asc')
                            ->get();

            $propietario = DB::table('propietario')
                            ->orderBy('propietario.id','asc')
                            ->get();

            $estado_dispositivo = DB::table('estado_dispositivo')
                                    ->orderBy('estado_dispositivo.id','asc')
                                    ->get();

            $html = View::make('inventario.content.impresora.formRegImpresoraEditar', 
                                [
                                    'impresora_id'          => $impresora_id,
                                    'data'                  => $data,
                                    'conexion_impresora'    => $conexion_impresora,
                                    'ip_list'               => $ip_list,
                                    'sala_list'             => $sala_list,
                                    'edificio_piso'         => $edificio_piso,
                                    'tipo_impresora'        => $tipo_impresora,
                                    'marca_impresora'       => $marca_impresora,
                                    'modelo_impresora'      => $modelo_impresora,
                                    'estado_candado'        => $estado_candado,
                                    'corriente'             => $corriente,
                                    'propietario'           => $propietario,
                                    'estado_dispositivo'    => $estado_dispositivo
                                ]
                                )->render();
            
            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }

    }

    public function include_formulario_impresora_crear(){

        $tipo_dispositivo_id = 2;

        try {

            $conexion_impresora = ConexionImpresora::all();

            $ip_list = DB::table('ip')
                            ->orderBy('ip.id','asc')
                            ->get();

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

            $tipo_impresora = DB::table('tipo_impresora')
                            ->orderBy('tipo_impresora.id','asc')
                            ->get();

            $marca_impresora = DB::table('marca_dispositivo')
                            ->select('marca_dispositivo.id','marca_dispositivo.nombre')
                            ->where('marca_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('marca_dispositivo.id','asc')
                            ->get();

            $modelo_impresora = DB::table('modelo_dispositivo')
                            ->select('modelo_dispositivo.id',DB::Raw('upper(modelo_dispositivo.nombre) as nombre_modelo'),'marca_dispositivo.nombre as nombre_marca')
                            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','modelo_dispositivo.marca_dispositivo_id')
                            ->where('modelo_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('modelo_dispositivo.nombre','asc')
                            ->get();

            $estado_candado = DB::table('candado')
                                ->orderBy('candado.id','asc')
                                ->get();

            $corriente = DB::table('corriente')
                            ->orderBy('corriente.id','asc')
                            ->get();

            $propietario = DB::table('propietario')
                            ->orderBy('propietario.id','asc')
                            ->get();

            $estado_dispositivo = DB::table('estado_dispositivo')
                                    ->orderBy('estado_dispositivo.id','asc')
                                    ->get();

            $html = View::make('inventario.content.impresora.formRegImpresoraCrear', 
                                [
                                    'conexion_impresora'    => $conexion_impresora,
                                    'ip_list'               => $ip_list,
                                    'sala_list'             => $sala_list,
                                    'edificio_piso'         => $edificio_piso,
                                    'tipo_impresora'        => $tipo_impresora,
                                    'marca_impresora'       => $marca_impresora,
                                    'modelo_impresora'      => $modelo_impresora,
                                    'estado_candado'        => $estado_candado,
                                    'corriente'             => $corriente,
                                    'propietario'           => $propietario,
                                    'estado_dispositivo'    => $estado_dispositivo
                                ]
                                )->render();

            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }

    }

    public function comprobar_serie_impresora($serie = null){
        $impresora = null;
        $serie_impresora = null;
        try {

            if (isset($serie)){

                $serie = strtoupper(trim($serie));
    
                $impresora = Impresora::where(DB::Raw('upper(serie)'),'=',$serie)->first();
    
                if (isset($impresora)){
                    $serie_impresora = $impresora->serie;
                }
    
            }
                        
            return response()->json(['serie' => $serie_impresora ,'status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
        
    }


    public function anexos(){
        return view('inventario.anexos');
    }

    public function anexo_list(Request $request){

        try {

            $anexo_list = DB::table('anexo')
                        ->select(
                                DB::Raw('anexo.id as anexo_id'),
                                'anexo.anexo',
                                'anexo.identificador',
                                'anexo.serie',
                                'anexo.mac',
                                'anexo.num_inventario',
                                'anexo.estado_id',
                                DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
                                DB::Raw('edificio.nombre as nombre_edificio'),
                                DB::Raw('piso.nombre as nombre_piso'),
                                DB::Raw('sala.id as sala_id'),
                                'sala.numero_sala',
                                'sala.nombre_sala',
                                DB::Raw('marca_dispositivo.nombre as nombre_marca'),
                                DB::Raw('modelo_dispositivo.nombre as nombre_modelo')
                        )
                        ->leftJoin('sala','sala.id','=','sala_id')
                        ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
                        ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
                        ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
                        ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','anexo.estado_id')
                        ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','anexo.marca_id')
                        ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','anexo.modelo_id')
                        ->orderBy('anexo.id','desc')
                        ->get();

            $html = View::make('inventario.content.anexo.tablaListaAnexo', ['anexo_list' => $anexo_list])->render();
            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500,'error' => $e->getMessage()],500);
        }

    }

    public function anexo_detalle($anexo_id){

        $anexo =  Anexo::select(
            DB::Raw('anexo.id as anexo_id'),
            'anexo.anexo',
            'anexo.identificador',
            'anexo.serie',
            'anexo.mac',
            'anexo.num_inventario',
            'anexo.estado_id',
            DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
            DB::Raw('edificio.nombre as nombre_edificio'),
            DB::Raw('piso.nombre as nombre_piso'),
            DB::Raw('sala.id as sala_id'),
            'sala.numero_sala',
            'sala.nombre_sala',
            'anexo.marca_id',
            DB::Raw('marca_dispositivo.nombre as nombre_marca'),
            'anexo.modelo_id',
            DB::Raw('modelo_dispositivo.nombre as nombre_modelo'),
            DB::Raw('categoria_anexo.id as categoria_id'),
            DB::Raw('categoria_anexo.nombre as categoria_anexo'),
            'anexo.observaciones',
            'anexo.propietario_id',
            'propietario.nombre as nombre_propietario'
        
        )
        ->leftJoin('sala','sala.id','=','anexo.sala_id')
        ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
        ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
        ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
        ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','anexo.estado_id')
        ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','anexo.marca_id')
        ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','anexo.modelo_id')
        ->leftJoin('categoria_anexo','categoria_anexo.id','=','anexo.categoria_id')
        ->leftJoin('propietario','propietario.id','=','anexo.propietario_id')
        ->where('anexo.id','=',$anexo_id)
        ->orderBy('anexo.id','desc')
        ->first();

        return $anexo;

    }

    public function include_detalle_anexo($anexo_id){

        try {
           
            $anexo =  Anexo::select(
                DB::Raw('anexo.id as anexo_id'),
                'anexo.anexo',
                'anexo.identificador',
                'anexo.serie',
                'anexo.mac',
                'anexo.num_inventario',
                'anexo.estado_id',
                DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
                DB::Raw('edificio.nombre as nombre_edificio'),
                DB::Raw('piso.nombre as nombre_piso'),
                DB::Raw('sala.id as sala_id'),
                'sala.numero_sala',
                'sala.nombre_sala',
                DB::Raw('marca_dispositivo.nombre as nombre_marca'),
                DB::Raw('modelo_dispositivo.nombre as nombre_modelo'),
                DB::Raw('categoria_anexo.nombre as categoria_anexo'),
                'anexo.observaciones',
                'anexo.propietario_id',
                'propietario.nombre as nombre_propietario',
                'user_crea.name as nombre_user_crea',
                DB::Raw("DATE_FORMAT(anexo.fecha_crea, '%d/%m/%Y %H:%i') as fecha_user_crea"),
                'user_mod.name as nombre_user_mod',
                DB::Raw("DATE_FORMAT(anexo.fecha_mod, '%d/%m/%Y %H:%i') as fecha_user_mod")
            )
            ->leftJoin('sala','sala.id','=','anexo.sala_id')
            ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
            ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
            ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
            ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','anexo.estado_id')
            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','anexo.marca_id')
            ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','anexo.modelo_id')
            ->leftJoin('categoria_anexo','categoria_anexo.id','=','anexo.categoria_id')
            ->leftJoin('users as user_crea','user_crea.id','=','anexo.user_crea_id')
            ->leftJoin('users as user_mod','user_mod.id','=','anexo.user_mod_id')
            ->leftJoin('propietario','propietario.id','=','anexo.propietario_id')
            ->where('anexo.id','=',$anexo_id)
            ->orderBy('anexo.id','desc')
            ->first();

            $html = View::make('inventario.content.anexo.detalleAnexoModal',['data' => $anexo])->render();

            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }

    }

    public function anexo_create(Request $request){

        $sala_id = null;
        //$anexo_id = null;

        DB::beginTransaction();

        try {

            if (isset($request->sala_id)){

                $sala_id = $request->sala_id;

            } else if (isset($request->edificio_piso) && isset($request->numero_sala) && isset($request->nombre_sala)){
                
                if ($this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala) == null){
                    $sala                   = new Sala();
                    $sala->numero_sala      = $request->numero_sala;
                    $sala->nombre_sala      = $request->nombre_sala;
                    $sala->edificio_piso_id = $request->edificio_piso;
                    $sala->save();
                    $sala_id = $sala->id;
                } else {
                    $sala_id = $this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala);
                }

            }
        
            $anexo                          = new Anexo();
            $anexo->sala_id                 = $sala_id;
            $anexo->estado_id               = $request->estado_id;
            $anexo->marca_id                = $request->marca_id;
            $anexo->modelo_id               = $request->modelo_id;
            $anexo->serie                   = $request->serie;
            $anexo->num_inventario          = $request->num_inventario;
            $anexo->mac                     = $request->mac;
            $anexo->anexo                   = $request->anexo;
            $anexo->identificador           = $request->identificador;
            $anexo->categoria_id            = $request->categoria_id;
            $anexo->observaciones           = $request->observaciones;
            $anexo->user_crea_id            = Auth::user()->id;
            $anexo->fecha_crea              = Carbon::now()->format('Y-m-d H:i:s');
            $anexo->propietario_id          = $request->propietario_id;
            $anexo->save();
           

            DB::commit();
            return response()->json(['status' => 201, 'error' => null], 201);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function anexo_update(Request $request){

        $anexo_id = $request->anexo_id;
        $sala_id = null;

        DB::beginTransaction();

        try {

            if (isset($request->sala_id)){

                $sala_id = $request->sala_id;

            } else if (isset($request->edificio_piso) && isset($request->numero_sala) && isset($request->nombre_sala)){
                
                if ($this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala) == null){
                    $sala                   = new Sala();
                    $sala->numero_sala      = $request->numero_sala;
                    $sala->nombre_sala      = $request->nombre_sala;
                    $sala->edificio_piso_id = $request->edificio_piso;
                    $sala->save();
                    $sala_id = $sala->id;
                } else {
                    $sala_id = $this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala);
                }

            }
        
            $anexo                          = Anexo::find($anexo_id);
            $anexo->sala_id                 = $sala_id;
            $anexo->estado_id               = $request->estado_id;
            $anexo->marca_id                = $request->marca_id;
            $anexo->modelo_id               = $request->modelo_id;
            $anexo->serie                   = $request->serie;
            $anexo->num_inventario          = $request->num_inventario;
            $anexo->mac                     = $request->mac;
            $anexo->anexo                   = $request->anexo;
            $anexo->identificador           = $request->identificador;
            $anexo->categoria_id            = $request->categoria_id;
            $anexo->observaciones           = $request->observaciones;
            $anexo->user_mod_id             = Auth::user()->id;
            $anexo->fecha_mod               = Carbon::now()->format('Y-m-d H:i:s');
            $anexo->propietario_id          = $request->propietario_id;
            $anexo->save();

            

            DB::commit();
            return response()->json(['status' => 201, 'error' => null], 201);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public function anexo_delete($anexo_id){

        DB::beginTransaction();
        try {

            $anexo = Anexo::find($anexo_id);
            $anexo->delete();
            
            DB::commit();
            return response()->json(['status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function include_formulario_anexo_editar($anexo_id){

        $tipo_dispositivo_id = 3;

        try {

            $data = $this->anexo_detalle($anexo_id);
            //dd($data);

            //$conexion_impresora = ConexionImpresora::all();

            /* $ip_list = DB::table('ip')
                            ->orderBy('ip.id','asc')
                            ->get(); */

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

            /* $tipo_impresora = DB::table('tipo_impresora')
                            ->orderBy('tipo_impresora.id','asc')
                            ->get(); */

            $marca_anexo = DB::table('marca_dispositivo')
                            ->select('marca_dispositivo.id','marca_dispositivo.nombre')
                            ->where('marca_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('marca_dispositivo.id','asc')
                            ->get();

            $modelo_anexo = DB::table('modelo_dispositivo')
                            ->select('modelo_dispositivo.id',DB::Raw('upper(modelo_dispositivo.nombre) as nombre_modelo'),'marca_dispositivo.nombre as nombre_marca')
                            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','modelo_dispositivo.marca_dispositivo_id')
                            ->where('modelo_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('modelo_dispositivo.nombre','asc')
                            ->get();
                                
            $categoria_anexo = DB::table('categoria_anexo')
                                ->orderBy('categoria_anexo.id','asc')
                                ->get();

            $propietario = DB::table('propietario')
                            ->orderBy('propietario.id','asc')
                            ->get();

            $estado_dispositivo = DB::table('estado_dispositivo')
                                    ->orderBy('estado_dispositivo.id','asc')
                                    ->get();
            //dd($data);
            $html = View::make('inventario.content.anexo.formRegAnexoEditar', 
                                [
                                    'anexo_id'              => $anexo_id,
                                    'data'                  => $data,
                                    'sala_list'             => $sala_list,
                                    'edificio_piso'         => $edificio_piso,
                                    'marca_anexo'           => $marca_anexo,
                                    'modelo_anexo'          => $modelo_anexo,
                                    'categoria_anexo'       => $categoria_anexo,
                                    'propietario'           => $propietario,
                                    'estado_dispositivo'    => $estado_dispositivo
                                ]
                                )->render();

            
            return response()->json($html,200);

        } catch (\Exception $e) {
            //echo $e;
            return response()->json($e->getMessage(),500);
        }

        

    }

    public function include_formulario_anexo_crear(){

        $tipo_dispositivo_id = 3;

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

            $marca_anexo = DB::table('marca_dispositivo')
                            ->select('marca_dispositivo.id','marca_dispositivo.nombre')
                            ->where('marca_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('marca_dispositivo.id','asc')
                            ->get();

            $modelo_anexo = DB::table('modelo_dispositivo')
                            ->select('modelo_dispositivo.id',DB::Raw('upper(modelo_dispositivo.nombre) as nombre_modelo'),'marca_dispositivo.nombre as nombre_marca')
                            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','modelo_dispositivo.marca_dispositivo_id')
                            ->where('modelo_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('modelo_dispositivo.nombre','asc')
                            ->get();

            $categoria_anexo = DB::table('categoria_anexo')
                                    ->orderBy('categoria_anexo.id','asc')
                                    ->get();

            $propietario = DB::table('propietario')
                            ->orderBy('propietario.id','asc')
                            ->get();

            $estado_dispositivo = DB::table('estado_dispositivo')
                                    ->orderBy('estado_dispositivo.id','asc')
                                    ->get();

            $html = View::make('inventario.content.anexo.formRegAnexoCrear', 
                                [
                                    'sala_list'             => $sala_list,
                                    'edificio_piso'         => $edificio_piso,
                                    'categoria_anexo'       => $categoria_anexo,
                                    'marca_anexo'           => $marca_anexo,
                                    'modelo_anexo'          => $modelo_anexo,
                                    'propietario'           => $propietario,
                                    'estado_dispositivo'    => $estado_dispositivo
                                ]
                                )->render();

            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }

    }

    public function comprobar_serie_anexo($serie = null){
        $anexo = null;
        $serie_anexo = null;
        try {

            if (isset($serie)){

                $serie = strtoupper(trim($serie));
    
                $anexo = Anexo::where(DB::Raw('upper(serie)'),'=',$serie)->first();
    
                if (isset($anexo)){
                    $serie_anexo = $anexo->serie;
                }
    
            }
                        
            return response()->json(['serie' => $serie_anexo ,'status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
        
    }
    
    public function huelleros(){

        return view('inventario.huelleros');
    }

    public function huellero_list(Request $request){

        try {

            $huellero_list = DB::table('huellero')
                        ->select(
                                DB::Raw('huellero.id as huellero_id'),
                                'huellero.serie',
                                'huellero.num_inventario',
                                'huellero.estado_id',
                                DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
                                //'ip.direccion_ip',
                                DB::Raw('edificio.nombre as nombre_edificio'),
                                DB::Raw('piso.nombre as nombre_piso'),
                                DB::Raw('sala.id as sala_id'),
                                'sala.numero_sala',
                                'sala.nombre_sala',
                                DB::Raw('marca_dispositivo.nombre as nombre_marca'),
                                DB::Raw('modelo_dispositivo.nombre as nombre_modelo')
                        )
                        ->leftJoin('sala','sala.id','=','sala_id')
                        ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
                        ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
                        ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
                        //->leftJoin('ip','ip.id','=','huellero.ip_id')
                        ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','huellero.estado_id')
                        ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','huellero.marca_id')
                        ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','huellero.modelo_id')
                        ->orderBy('huellero.id','desc')
                        ->get();

            //dd($huellero_list);

            $html = View::make('inventario.content.huellero.tablaListaHuellero', ['huellero_list' => $huellero_list])->render();
            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500,'error' => $e->getMessage()],500);
        }
        

    }

    public function huellero_detalle($huellero_id){

        $huellero =  Huellero::select(

            DB::Raw('huellero.id as huellero_id'),
            'huellero.serie',
            'huellero.num_inventario',
            'huellero.estado_id',
            DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
            DB::Raw('edificio.nombre as nombre_edificio'),
            DB::Raw('piso.nombre as nombre_piso'),
            DB::Raw('sala.id as sala_id'),
            'sala.numero_sala',
            'sala.nombre_sala',
            'huellero.marca_id',
            DB::Raw('marca_dispositivo.nombre as nombre_marca'),
            'huellero.modelo_id',
            DB::Raw('modelo_dispositivo.nombre as nombre_modelo'),
            'huellero.observaciones',
            'huellero.propietario_id',
            'propietario.nombre as nombre_propietario'
        )
        ->leftJoin('sala','sala.id','=','huellero.sala_id')
        ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
        ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
        ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
        ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','huellero.estado_id')
        ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','huellero.marca_id')
        ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','huellero.modelo_id')
        ->leftJoin('propietario','propietario.id','=','huellero.propietario_id')
        ->where('huellero.id','=',$huellero_id)
        ->orderBy('huellero.id','desc')
        ->first();

        return $huellero;

    }

    public function include_detalle_huellero($huellero_id){
        //dd(0);
        try {
           
            $huellero =  Huellero::select(

                DB::Raw('huellero.id as huellero_id'),
                //'huellero.huellero',
                //'huellero.identificador',
                'huellero.serie',
                //'huellero.mac',
                'huellero.num_inventario',
                'huellero.estado_id',
                DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
                DB::Raw('edificio.nombre as nombre_edificio'),
                DB::Raw('piso.nombre as nombre_piso'),
                DB::Raw('sala.id as sala_id'),
                'sala.numero_sala',
                'sala.nombre_sala',
                DB::Raw('marca_dispositivo.nombre as nombre_marca'),
                DB::Raw('modelo_dispositivo.nombre as nombre_modelo'),
                'huellero.observaciones',
                'huellero.propietario_id',
                'propietario.nombre as nombre_propietario',
                'user_crea.name as nombre_user_crea',
                DB::Raw("DATE_FORMAT(huellero.fecha_crea, '%d/%m/%Y %H:%i') as fecha_user_crea"),
                'user_mod.name as nombre_user_mod',
                DB::Raw("DATE_FORMAT(huellero.fecha_mod, '%d/%m/%Y %H:%i') as fecha_user_mod")
            )
            ->leftJoin('sala','sala.id','=','huellero.sala_id')
            ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
            ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
            ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
            ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','huellero.estado_id')
            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','huellero.marca_id')
            ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','huellero.modelo_id')
            ->leftJoin('users as user_crea','user_crea.id','=','huellero.user_crea_id')
            ->leftJoin('users as user_mod','user_mod.id','=','huellero.user_mod_id')
            ->leftJoin('propietario','propietario.id','=','huellero.propietario_id')
            ->where('huellero.id','=',$huellero_id)
            ->orderBy('huellero.id','desc')
            ->first();


            //dd($huellero);

            $html = View::make('inventario.content.huellero.detalleHuelleroModal',['data' => $huellero])->render();

            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }

    }

    public function huellero_create(Request $request){

        $sala_id = null;
        //$huellero_id = null;

        DB::beginTransaction();

        try {

            if (isset($request->sala_id)){

                $sala_id = $request->sala_id;

            } else if (isset($request->edificio_piso) && isset($request->numero_sala) && isset($request->nombre_sala)){
                
                if ($this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala) == null){
                    $sala                   = new Sala();
                    $sala->numero_sala      = $request->numero_sala;
                    $sala->nombre_sala      = $request->nombre_sala;
                    $sala->edificio_piso_id = $request->edificio_piso;
                    $sala->save();
                    $sala_id = $sala->id;
                } else {
                    $sala_id = $this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala);
                }

            }
        
            $huellero                          = new Huellero();
            $huellero->sala_id                 = $sala_id;
            $huellero->estado_id               = $request->estado_id;
            $huellero->marca_id                = $request->marca_id;
            $huellero->modelo_id               = $request->modelo_id;
            $huellero->serie                   = $request->serie;
            $huellero->num_inventario          = $request->num_inventario;
            $huellero->observaciones           = $request->observaciones;
            $huellero->propietario_id          = $request->propietario_id;
            $huellero->user_crea_id            = Auth::user()->id;
            $huellero->fecha_crea              = Carbon::now()->format('Y-m-d H:i:s');
            $huellero->save();
           

            DB::commit();
            return response()->json(['status' => 201, 'error' => null], 201);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function huellero_update(Request $request){

        $huellero_id = $request->huellero_id;
        $sala_id = null;

        DB::beginTransaction();

        try {

            if (isset($request->sala_id)){

                $sala_id = $request->sala_id;

            } else if (isset($request->edificio_piso) && isset($request->numero_sala) && isset($request->nombre_sala)){
                
                if ($this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala) == null){
                    $sala                   = new Sala();
                    $sala->numero_sala      = $request->numero_sala;
                    $sala->nombre_sala      = $request->nombre_sala;
                    $sala->edificio_piso_id = $request->edificio_piso;
                    $sala->save();
                    $sala_id = $sala->id;
                } else {
                    $sala_id = $this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala);
                }

            }
        
            $huellero                          = Huellero::find($huellero_id);
            $huellero->sala_id                 = $sala_id;
            $huellero->estado_id               = $request->estado_id;
            $huellero->marca_id                = $request->marca_id;
            $huellero->modelo_id               = $request->modelo_id;
            $huellero->serie                   = $request->serie;
            $huellero->num_inventario          = $request->num_inventario;
            $huellero->observaciones           = $request->observaciones;
            $huellero->propietario_id          = $request->propietario_id;
            $huellero->user_mod_id             = Auth::user()->id;
            $huellero->fecha_mod               = Carbon::now()->format('Y-m-d H:i:s');
            $huellero->save();

            

            DB::commit();
            return response()->json(['status' => 201, 'error' => null], 201);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public function huellero_delete($huellero_id){

        DB::beginTransaction();
        try {

            $huellero = Huellero::find($huellero_id);
            $huellero->delete();
            
            DB::commit();
            return response()->json(['status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function include_formulario_huellero_editar($huellero_id){

        $tipo_dispositivo_id = 4;

        try {

            $data = $this->huellero_detalle($huellero_id);

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

            $marca_huellero = DB::table('marca_dispositivo')
                            ->select('marca_dispositivo.id','marca_dispositivo.nombre')
                            ->where('marca_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('marca_dispositivo.id','asc')
                            ->get();

            $modelo_huellero = DB::table('modelo_dispositivo')
                            ->select('modelo_dispositivo.id',DB::Raw('upper(modelo_dispositivo.nombre) as nombre_modelo'),'marca_dispositivo.nombre as nombre_marca')
                            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','modelo_dispositivo.marca_dispositivo_id')
                            ->where('modelo_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('modelo_dispositivo.nombre','asc')
                            ->get();
          

            $estado_dispositivo = DB::table('estado_dispositivo')
                                    ->orderBy('estado_dispositivo.id','asc')
                                    ->get();            

            $propietario = DB::table('propietario')
                            ->orderBy('propietario.id','asc')
                            ->get();

            $html = View::make('inventario.content.huellero.formRegHuelleroEditar', 
                                [
                                    'huellero_id'           => $huellero_id,
                                    'data'                  => $data,
                                    'sala_list'             => $sala_list,
                                    'edificio_piso'         => $edificio_piso,
                                    'marca_huellero'        => $marca_huellero,
                                    'modelo_huellero'       => $modelo_huellero,
                                    'estado_dispositivo'    => $estado_dispositivo,
                                    'propietario'           => $propietario,
                                ]
                                )->render();

            
            return response()->json($html,200);

        } catch (\Exception $e) {
            //echo $e;
            return response()->json($e->getMessage(),500);
        }

        

    }

    public function include_formulario_huellero_crear(){

        $tipo_dispositivo_id = 4;

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

            $marca_huellero = DB::table('marca_dispositivo')
                            ->select('marca_dispositivo.id','marca_dispositivo.nombre')
                            ->where('marca_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('marca_dispositivo.id','asc')
                            ->get();

            $modelo_huellero = DB::table('modelo_dispositivo')
                            ->select('modelo_dispositivo.id',DB::Raw('upper(modelo_dispositivo.nombre) as nombre_modelo'),'marca_dispositivo.nombre as nombre_marca')
                            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','modelo_dispositivo.marca_dispositivo_id')
                            ->where('modelo_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('modelo_dispositivo.nombre','asc')
                            ->get();

            $estado_dispositivo = DB::table('estado_dispositivo')
                                    ->orderBy('estado_dispositivo.id','asc')
                                    ->get();

            $propietario = DB::table('propietario')
                            ->orderBy('propietario.id','asc')
                            ->get();

            $html = View::make('inventario.content.huellero.formRegHuelleroCrear', 
                                [
                                    'sala_list'             => $sala_list,
                                    'edificio_piso'         => $edificio_piso,
                                    'marca_huellero'        => $marca_huellero,
                                    'modelo_huellero'       => $modelo_huellero,
                                    'estado_dispositivo'    => $estado_dispositivo,
                                    'propietario'           => $propietario
                                ]
                                )->render();

            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }

        

    }

    public function comprobar_serie_huellero($serie = null){
        $huellero = null;
        $serie_huellero = null;
        try {

            if (isset($serie)){

                $serie = strtoupper(trim($serie));
    
                $huellero = Huellero::where(DB::Raw('upper(serie)'),'=',$serie)->first();
    
                if (isset($huellero)){
                    $serie_huellero = $huellero->serie;
                }
    
            }
                        
            return response()->json(['serie' => $serie_huellero ,'status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
        
    }

    public function monitores(){

        return view('inventario.monitores');
    }

    public function monitor_list(Request $request){

        /* try { */

            $monitor_list = Monitor::select(
                            DB::Raw('monitor.id as monitor_id'),
                            'monitor.serie',
                            'monitor.num_inventario',
                            'monitor.estado_id',
                            DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
                            DB::Raw('edificio.nombre as nombre_edificio'),
                            DB::Raw('piso.nombre as nombre_piso'),
                            DB::Raw('sala.id as sala_id'),
                            'sala.numero_sala',
                            'sala.nombre_sala',
                            DB::Raw('marca_dispositivo.nombre as nombre_marca'),
                            DB::Raw('modelo_dispositivo.nombre as nombre_modelo')
                        )
                        ->leftJoin('sala','sala.id','=','sala_id')
                        ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
                        ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
                        ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
                        ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','monitor.estado_id')
                        ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','monitor.marca_id')
                        ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','monitor.modelo_id')
                        ->orderBy('monitor.id','desc')
                        ->get();

            //dd($monitor_list);

            $html = View::make('inventario.content.monitor.tablaListaMonitor', ['monitor_list' => $monitor_list])->render();
            return response()->json($html,200);

       /*  } catch (\Exception $e) {
            return response()->json(['status' => 500,'error' => $e->getMessage()],500);
        } */
        

    }

    public function include_formulario_monitor_crear(){

        $tipo_dispositivo_id = 5;

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

            $marca_monitor = DB::table('marca_dispositivo')
                            ->select('marca_dispositivo.id','marca_dispositivo.nombre')
                            ->where('marca_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('marca_dispositivo.id','asc')
                            ->get();

            $modelo_monitor = DB::table('modelo_dispositivo')
                            ->select('modelo_dispositivo.id',DB::Raw('upper(modelo_dispositivo.nombre) as nombre_modelo'),'marca_dispositivo.nombre as nombre_marca')
                            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','modelo_dispositivo.marca_dispositivo_id')
                            ->where('modelo_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('modelo_dispositivo.nombre','asc')
                            ->get();

            $estado_dispositivo = DB::table('estado_dispositivo')
                                    ->orderBy('estado_dispositivo.id','asc')
                                    ->get();

            $propietario = DB::table('propietario')
                            ->orderBy('propietario.id','asc')
                            ->get();

            $html = View::make('inventario.content.monitor.formMonitorCrear', 
                                [
                                    'sala_list'             => $sala_list,
                                    'edificio_piso'         => $edificio_piso,
                                    'marca_monitor'         => $marca_monitor,
                                    'modelo_monitor'        => $modelo_monitor,
                                    'estado_dispositivo'    => $estado_dispositivo,
                                    'propietario'           => $propietario,
                                ]
                                )->render();

            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }

    }

    public function monitor_create(Request $request){

        $sala_id = null;

        DB::beginTransaction();

        try {

            if (isset($request->sala_id)){

                $sala_id = $request->sala_id;

            } else if (isset($request->edificio_piso) && isset($request->numero_sala) && isset($request->nombre_sala)){
                
                if ($this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala) == null){
                    $sala                   = new Sala();
                    $sala->numero_sala      = $request->numero_sala;
                    $sala->nombre_sala      = $request->nombre_sala;
                    $sala->edificio_piso_id = $request->edificio_piso;
                    $sala->save();
                    $sala_id = $sala->id;
                } else {
                    $sala_id = $this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala);
                }

            }
        
            $monitor                          = new Monitor();
            $monitor->sala_id                 = $sala_id;
            $monitor->estado_id               = $request->estado_id;
            $monitor->marca_id                = $request->marca_id;
            $monitor->modelo_id               = $request->modelo_id;
            $monitor->serie                   = $request->serie;
            $monitor->num_inventario          = $request->num_inventario;
            $monitor->observaciones           = $request->observaciones;
            $monitor->propietario_id          = $request->propietario_id;
            $monitor->user_crea_id            = Auth::user()->id;
            $monitor->fecha_crea              = Carbon::now()->format('Y-m-d H:i:s');
            $monitor->save();

            DB::commit();
            return response()->json(['status' => 201, 'error' => null], 201);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function monitor_delete($monitor_id){

        DB::beginTransaction();
        try {

            $monitor = Monitor::find($monitor_id);
            $monitor->delete();
            
            DB::commit();
            return response()->json(['status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function include_detalle_monitor($monitor_id){

        try {
           
            $monitor =  Monitor::select(
                'monitor.id as monitor_id',
                'monitor.serie',
                'monitor.num_inventario',
                'monitor.estado_id',
                DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
                DB::Raw('edificio.nombre as nombre_edificio'),
                DB::Raw('piso.nombre as nombre_piso'),
                DB::Raw('sala.id as sala_id'),
                'sala.numero_sala',
                'sala.nombre_sala',
                DB::Raw('marca_dispositivo.nombre as nombre_marca'),
                DB::Raw('modelo_dispositivo.nombre as nombre_modelo'),
                'monitor.observaciones',
                'monitor.propietario_id',
                'propietario.nombre as nombre_propietario',
                'user_crea.name as nombre_user_crea',
                DB::Raw("DATE_FORMAT(monitor.fecha_crea, '%d/%m/%Y %H:%i') as fecha_user_crea"),
                'user_mod.name as nombre_user_mod',
                DB::Raw("DATE_FORMAT(monitor.fecha_mod, '%d/%m/%Y %H:%i') as fecha_user_mod")
            )
            ->leftJoin('sala','sala.id','=','monitor.sala_id')
            ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
            ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
            ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
            ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','monitor.estado_id')
            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','monitor.marca_id')
            ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','monitor.modelo_id')
            ->leftJoin('users as user_crea','user_crea.id','=','monitor.user_crea_id')
            ->leftJoin('users as user_mod','user_mod.id','=','monitor.user_mod_id')
            ->leftJoin('propietario','propietario.id','=','monitor.propietario_id')
            ->where('monitor.id','=',$monitor_id)
            ->orderBy('monitor.id','desc')
            ->first();

            $html = View::make('inventario.content.monitor.detalleMonitorModal',['data' => $monitor])->render();

            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }

    }

    public function monitor_detalle($monitor_id){

        $monitor =  Monitor::select(
            DB::Raw('monitor.id as monitor_id'),
            'monitor.serie',
            'monitor.num_inventario',
            'monitor.estado_id',
            DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
            DB::Raw('edificio.nombre as nombre_edificio'),
            DB::Raw('piso.nombre as nombre_piso'),
            DB::Raw('sala.id as sala_id'),
            'sala.numero_sala',
            'sala.nombre_sala',
            'monitor.marca_id',
            DB::Raw('marca_dispositivo.nombre as nombre_marca'),
            'monitor.modelo_id',
            DB::Raw('modelo_dispositivo.nombre as nombre_modelo'),
            'monitor.observaciones',
            'monitor.propietario_id',
            'propietario.nombre as nombre_propietario'
        )
        ->leftJoin('sala','sala.id','=','monitor.sala_id')
        ->leftJoin('edificio_piso','edificio_piso.id','=','sala.edificio_piso_id')
        ->leftJoin('piso','piso.id','=','edificio_piso.piso_id')
        ->leftJoin('edificio','edificio.id','=','edificio_piso.edificio_id')
        ->leftJoin('estado_dispositivo','estado_dispositivo.id','=','monitor.estado_id')
        ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','monitor.marca_id')
        ->leftJoin('modelo_dispositivo','modelo_dispositivo.id','=','monitor.modelo_id')
        ->leftJoin('propietario','propietario.id','=','monitor.propietario_id')
        ->where('monitor.id','=',$monitor_id)
        ->orderBy('monitor.id','desc')
        ->first();

        return $monitor;

    }

    public function include_formulario_monitor_editar($monitor_id){

        $tipo_dispositivo_id = 5;

        try {

            $data = $this->monitor_detalle($monitor_id);

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

            $marca_monitor = DB::table('marca_dispositivo')
                            ->select('marca_dispositivo.id','marca_dispositivo.nombre')
                            ->where('marca_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('marca_dispositivo.id','asc')
                            ->get();

            $modelo_monitor = DB::table('modelo_dispositivo')
                            ->select('modelo_dispositivo.id',DB::Raw('upper(modelo_dispositivo.nombre) as nombre_modelo'),'marca_dispositivo.nombre as nombre_marca')
                            ->leftJoin('marca_dispositivo','marca_dispositivo.id','=','modelo_dispositivo.marca_dispositivo_id')
                            ->where('modelo_dispositivo.tipo_dispositivo_id',$tipo_dispositivo_id)
                            ->orderBy('modelo_dispositivo.nombre','asc')
                            ->get();
          

            $estado_dispositivo = DB::table('estado_dispositivo')
                                    ->orderBy('estado_dispositivo.id','asc')
                                    ->get();

            $propietario = DB::table('propietario')
                            ->orderBy('propietario.id','asc')
                            ->get();

            $html = View::make('inventario.content.monitor.formMonitorEditar', 
                                [
                                    'monitor_id'            => $monitor_id,
                                    'data'                  => $data,
                                    'sala_list'             => $sala_list,
                                    'edificio_piso'         => $edificio_piso,
                                    'marca_monitor'         => $marca_monitor,
                                    'modelo_monitor'        => $modelo_monitor,
                                    'estado_dispositivo'    => $estado_dispositivo,
                                    'propietario'           => $propietario,
                                ]
                                )->render();

            
            return response()->json($html,200);

        } catch (\Exception $e) {
            //echo $e;
            return response()->json($e->getMessage(),500);
        }

        

    }

    public function monitor_update(Request $request){

        $monitor_id = $request->monitor_id;
        $sala_id = null;

        DB::beginTransaction();

        try {

            if (isset($request->sala_id)){

                $sala_id = $request->sala_id;

            } else if (isset($request->edificio_piso) && isset($request->numero_sala) && isset($request->nombre_sala)){
                
                if ($this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala) == null){
                    $sala                   = new Sala();
                    $sala->numero_sala      = $request->numero_sala;
                    $sala->nombre_sala      = $request->nombre_sala;
                    $sala->edificio_piso_id = $request->edificio_piso;
                    $sala->save();
                    $sala_id = $sala->id;
                } else {
                    $sala_id = $this->comprobar_ubicacion($request->edificio_piso,$request->numero_sala,$request->nombre_sala);
                }

            }
        
            $monitor                          = Monitor::find($monitor_id);
            $monitor->sala_id                 = $sala_id;
            $monitor->estado_id               = $request->estado_id;
            $monitor->marca_id                = $request->marca_id;
            $monitor->modelo_id               = $request->modelo_id;
            $monitor->serie                   = $request->serie;
            $monitor->num_inventario          = $request->num_inventario;
            $monitor->observaciones           = $request->observaciones;
            $monitor->propietario_id          = $request->propietario_id;
            $monitor->user_mod_id             = Auth::user()->id;
            $monitor->fecha_mod               = Carbon::now()->format('Y-m-d H:i:s');
            $monitor->save();

            DB::commit();
            return response()->json(['status' => 201, 'error' => null], 201);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function comprobar_serie_monitor($serie = null){
        $monitor = null;
        $serie_monitor = null;
        try {

            if (isset($serie)){

                $serie = strtoupper(trim($serie));
    
                $monitor = Monitor::where(DB::Raw('upper(serie)'),'=',$serie)->first();
    
                if (isset($monitor)){
                    $serie_monitor = $monitor->serie;
                }

            }
                        
            return response()->json(['serie' => $serie_monitor ,'status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
        
    }


}
