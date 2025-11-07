<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

use App\Models\Permiso;
use App\Models\PermisoEstablecimiento;
use App\Models\Establecimiento;
use App\Models\Rol;
use App\Models\Sistema;
use App\Models\User;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GestionUsuarioController extends Controller implements HasMiddleware
{
    public function __construct(){
        //dd(get_class($this));
        //$this->middleware('rol:2,2')->only(['index']);
    }
    public static function middleware(): array
    {
        return [
            'auth', // Middleware global para este controlador
            new Middleware('VerificarAccesoSistema:2'),
            new Middleware('BloquearRoles:2,1,3'),
        ];
    }
    public function index(){
        $users = User::all();
        return view('gestion_usuario.index')->with('users',$users);
    }

    private function sistemas(){
        $sistemas = Sistema::all();
        return $sistemas;
    }

    private function roles(){
        $roles = Rol::all();
        return $roles;
    }

    private function obtener_permiso_user($user_id){
        $permiso_user = Permiso::select(
            DB::Raw('permiso.id as permiso_id'),

            DB::Raw('rol.id as rol_id'),
            DB::Raw('rol.nombre as nombre_rol'),

            DB::Raw('sistema.id as sistema_id'),
            DB::Raw('sistema.nombre as nombre_sistema')

        )
        ->leftJoin('rol','rol.id','=','permiso.rol_id')
        ->leftJoin('sistema','sistema.id','=','permiso.sistema_id')
        ->where('permiso.user_id',$user_id)
        ->get();
        return $permiso_user;
    }

    private function sistemas_disponibles($user_id){
        $permisos_user = $this->obtener_permiso_user($user_id);
        $sistemas_user = $permisos_user->pluck('sistema_id')->toArray();
        $sistemas_disponibles = Sistema::whereNotIn('id',$sistemas_user)->get();
        return $sistemas_disponibles;
    }

    public function permiso_user_list($user_id = null){

        try {

            $permiso_user_list = Permiso::select(
                DB::Raw('permiso.id as permiso_id'),
    
                DB::Raw('rol.id as rol_id'),
                DB::Raw('rol.nombre as nombre_rol'),
    
                DB::Raw('sistema.id as sistema_id'),
                DB::Raw('sistema.nombre as nombre_sistema'),
    
            )
            ->leftJoin('rol','rol.id','=','permiso.rol_id')
            ->leftJoin('sistema','sistema.id','=','permiso.sistema_id')
            ->where('permiso.user_id',$user_id)
            ->get();

            $html = View::make('gestion_usuario.content.tablaPermisoUser', ['permiso_user_list' => $permiso_user_list])->render();
            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500,'error' => $e->getMessage()],500);
        }

    }

    public function include_buscar_user($user_id = null){

        try {

            $data = User::where('users.id',$user_id)->first();
            $sistemas = $this->sistemas();

            $html = View::make('gestion_usuario.content.selected_user', 
            [
                'data' => $data, 
                'sistemas' => $sistemas
            ]
            )->render();
            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json(['status' => 500,'error' => $e->getMessage()],500);
        }
    }

    public function user_delete($user_id = null){

        DB::beginTransaction();
        try {

            $permisos = Permiso::where('user_id',$user_id);
            $permisos->delete();

            $user = User::find($user_id);
            $user->delete();

            DB::commit();
            return response()->json(['status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function permiso_user_delete($permiso_id){

        DB::beginTransaction();
        try {

            $permiso = Permiso::find($permiso_id);
            $permiso->delete();

            DB::commit();
            return response()->json(['status' => 200, 'error' => null], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function include_formulario_permiso_user_create($user_id){

        try {

            $sistemas_disponibles = $this->sistemas_disponibles($user_id);
            
            $roles = count($sistemas_disponibles) > 0 ? $this->roles() : [];
            $establecimiento = Establecimiento::all();
            //dd($establecimiento);
            $html = View::make('gestion_usuario.content.formUserCreate', 
                                [
                                    'sistemas_disponibles'  => $sistemas_disponibles,
                                    'roles'                 => $roles,
                                    'establecimiento'       => $establecimiento,
                                    'user_id'               => $user_id
                                ])->render();

            return response()->json($html,200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }

    }

    public function permiso_user_create(Request $request){

        DB::beginTransaction();

        try {

            $permiso             = new Permiso();
            $permiso->user_id    = $request->user_id;
            $permiso->rol_id     = $request->rol_id;
            $permiso->sistema_id = $request->sistema_id;
            $permiso->save();

            DB::commit();
            return response()->json(['status' => 201, 'error' => null], 201);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }

    }

    public function include_form_permiso_user_update($permiso_id){

        try {
            $sistemas = $this->sistemas();
            $roles = $this->roles();
            $permiso = Permiso::find($permiso_id);
            $permiso_id = $permiso->id;

            $html = View::make('gestion_usuario.content.formPermisoUserUpdate', 
                                [
                                    'sistemas'      => $sistemas,
                                    'roles'         => $roles,
                                    'permiso'       => $permiso,
                                    'permiso_id'    => $permiso_id
                                ]
                                )->render();
            
            return response()->json($html,200);

        } catch (\Exception $e) {
            //echo $e;
            return response()->json($e->getMessage(),500);
        }

        

    }

    public function permiso_user_update(Request $request){

        DB::beginTransaction();

        try {
            $permiso                = Permiso::find($request->permiso_id);
            $permiso->rol_id        = $request->rol_id;
            $permiso->save();

            DB::commit();
            return response()->json(['status' => 201, 'error' => null], 201);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
    }


}
