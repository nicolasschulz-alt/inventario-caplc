<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Permiso;
use App\Models\Sistema;

class PrincipalController extends Controller
{
    public function index(Request $request){
        
        $permiso_all_user = $this->permiso_all_user($request->user()->id);
        $sistemas_sin_acceso = $this->sistemas_sin_acceso($request->user()->id);
        $sistemas_user = [];

        if ($permiso_all_user->isNotEmpty()){
            foreach ($permiso_all_user as $value) {
                $value->acceso = true;
                $sistemas_user[] = $value;
            }
        }
        foreach ($sistemas_sin_acceso as $value) {
            $value->acceso = false;
            $sistemas_user[] = $value;
        }
        return view('dashboard')->with('sistemas_user',$sistemas_user);
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

    private function sistemas_sin_acceso($user_id){
        $permisos_user = $this->obtener_permiso_user($user_id);
        $sistemas_user = $permisos_user->pluck('sistema_id')->toArray();

        $sistemas_sin_acceso = Sistema::select(
            DB::Raw('NULL as permiso_id'),
            DB::Raw('NULL as rol_id'),
            DB::Raw('NULL as nombre_rol'),
            'id as sistema_id',
            'nombre as nombre_sistema'
        )
        ->whereNotIn('id',$sistemas_user)
        ->orderBy('id','asc')
        ->get();

        return $sistemas_sin_acceso;
    }

    private function permiso_all_user($user_id = null){

        $permiso_all_user = Permiso::select(
            DB::Raw('permiso.id as permiso_id'),

            DB::Raw('rol.id as rol_id'),
            DB::Raw('rol.nombre as nombre_rol'),

            DB::Raw('sistema.id as sistema_id'),
            DB::Raw('sistema.nombre as nombre_sistema')
        )
        ->leftJoin('rol','rol.id','=','permiso.rol_id')
        ->leftJoin('sistema','sistema.id','=','permiso.sistema_id')
        ->where('permiso.user_id',$user_id)
        ->orderBy('sistema.id','asc')
        ->get();

        return $permiso_all_user;
    }

    /* public function update_permisos($user_id = null, $permiso_asignar = []){

        DB::beginTransaction();
        try {

            $permiso_delete = Permiso::where('user_id',$user_id);
            $permiso_delete->delete();

            if (count($permiso_asignar) > 0){

                foreach ($permiso_asignar as $value) {
                    $permiso             = new Permiso();
                    $permiso->user_id    = $user_id;
                    $permiso->rol_id     = $value['rol_id'];
                    $permiso->sistema_id = $value['sistema_id'];
                    $permiso->save();
                }

            }

            DB::commit();
            return response()->json(['status' => 200, 'error' => null], 200);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 500);
        }
    } */

}
