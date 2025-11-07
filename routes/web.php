<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnidadTicController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ExportExcelPcController;
use App\Http\Controllers\ExportExcelImpresoraController;
use App\Http\Controllers\ExportExcelAnexoController;
use App\Http\Controllers\ExportExcelHuelleroController;
use App\Http\Controllers\ExportExcelMonitorController;
use App\Http\Controllers\SistemasController;
use App\Http\Controllers\MantenedorInventarioController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\GestionUsuarioController;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */

/* Route::get('/access-denied', function () {
    return view('access-denied');
})->name('access-denied'); */

Route::middleware('auth')->group(function () {

    Route::get('/access-denied', function () {
        return view('access-denied');
    })->name('access-denied');

    Route::get('/dashboard', [PrincipalController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


    //RUTAS DEL LOGIN 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //RUTAS MODULOS
    Route::get('/tic', [UnidadTicController::class, 'index'])->name('tic.index');
    //Route::get('/gestion_usuarios', [GestionUsuarioController::class, 'index'])->name('usuario.index')->middleware('rol:2,2');
    Route::get('/gestion_usuarios', [GestionUsuarioController::class, 'index'])->name('usuario.index');
    

    //RUTAS USUARIOS
    Route::get('/gestion_usuarios/include_buscar_user/{user_id?}', [GestionUsuarioController::class, 'include_buscar_user'])->name('usuario.include_buscar_user');
    Route::get('/gestion_usuarios/permiso_user_list/{user_id?}', [GestionUsuarioController::class, 'permiso_user_list'])->name('usuario.permiso_user_list');
    Route::post('/gestion_usuarios/permiso_user_create', [GestionUsuarioController::class, 'permiso_user_create'])->name('usuario.permiso_user_create');
    Route::get('/gestion_usuarios/include_formulario_permiso_user_create/{user_id?}', [GestionUsuarioController::class, 'include_formulario_permiso_user_create'])->name('usuario.include_formulario_permiso_user_create');
    Route::post('/gestion_usuarios/user_delete/{user_id?}', [GestionUsuarioController::class, 'user_delete'])->name('usuario.user_delete');
    Route::post('/gestion_usuarios/permiso_user_delete/{permiso_id?}', [GestionUsuarioController::class, 'permiso_user_delete'])->name('usuario.permiso_user_delete');
    Route::get('/gestion_usuarios/include_form_permiso_user_update/{permiso_id?}', [GestionUsuarioController::class, 'include_form_permiso_user_update'])->name('usuario.include_form_permiso_user_update');
    Route::post('/gestion_usuarios/permiso_user_update/{permiso_id?}', [GestionUsuarioController::class, 'permiso_user_update'])->name('usuario.permiso_user_update');
    
    //RUTAS MANTENEDORES INVENTARIO
    Route::get('/inventario/mantenedor', [MantenedorInventarioController::class, 'index'])->name('inventario.mantenedor');
    Route::get('/inventario/mantenedor/ubicacion_list', [MantenedorInventarioController::class, 'ubicacion_list'])->name('inventario.mantenedor.ubicacion_list');
    Route::post('/inventario/mantenedor/ubicacion_update/{sala_id?}', [MantenedorInventarioController::class, 'ubicacion_update'])->name('inventario.mantenedor.ubicacion_update');
    Route::get('/inventario/mantenedor/include_formulario_ubicacion_editar/{sala_id?}', [MantenedorInventarioController::class, 'include_formulario_ubicacion_editar'])->name('inventario.mantenedor.include_formulario_ubicacion_editar');
    Route::post('/inventario/mantenedor/ubicacion_create', [MantenedorInventarioController::class, 'ubicacion_create'])->name('inventario.mantenedor.ubicacion_create');
    Route::get('/inventario/mantenedor/include_formulario_ubicacion_crear', [MantenedorInventarioController::class, 'include_formulario_ubicacion_crear'])->name('inventario.mantenedor.include_formulario_ubicacion_crear');

    //RUTAS RECICLABLES
    Route::get('/inventario/obtener_nombre_sala/{numero_sala?}/{edificio_piso?}', [InventarioController::class, 'obtener_nombre_sala'])->name('inventario.obtener_nombre_sala');
    Route::get('/inventario/obtener_salas_por_edificio_piso/{edificio_piso?}', [InventarioController::class, 'obtener_salas_por_edificio_piso'])->name('inventario.obtener_salas_por_edificio_piso');
    Route::get('/inventario/obtener_modelos_por_tipo/{tipo_id?}', [InventarioController::class, 'obtener_modelos_por_tipo'])->name('inventario.obtener_modelos_por_tipo');
    Route::get('/inventario/obtener_modelos_por_tipo_marca/{tipo_id?}/{marca_id?}', [InventarioController::class, 'obtener_modelos_por_tipo_marca'])->name('inventario.obtener_modelos_por_tipo_marca');
    Route::get('/inventario/obtener_marca_por_modelo/{modelo_id?}', [InventarioController::class, 'obtener_marca_por_modelo'])->name('inventario.obtener_marca_por_modelo');
    
    //RUTAS PC
    Route::get('/inventario/pc', [InventarioController::class, 'pc'])->name('inventario.pc');
    Route::get('/inventario/pc_export_excel', [ExportExcelPcController::class, 'export'])->name('inventario.pc_export_excel');
    Route::get('/inventario/pc_list', [InventarioController::class, 'pc_list'])->name('inventario.pc_list');
    Route::post('/inventario/pc_update/{pc_id?}', [InventarioController::class, 'pc_update'])->name('inventario.pc_update');
    Route::post('/inventario/pc_create', [InventarioController::class, 'pc_create'])->name('inventario.pc_create');
    Route::post('/inventario/pc_delete/{pc_id?}', [InventarioController::class, 'pc_delete'])->name('inventario.pc_delete');
    Route::get('/inventario/include_formulario_pc_crear', [InventarioController::class, 'include_formulario_pc_crear'])->name('inventario.include_formulario_pc_crear');
    Route::get('/inventario/include_detalle_pc/{pc_id?}', [InventarioController::class, 'include_detalle_pc'])->name('inventario.include_detalle_pc');
    Route::get('/inventario/include_editar_pc/{pc_id?}', [InventarioController::class, 'include_editar_pc'])->name('inventario.include_editar_pc');
    Route::get('/inventario/comprobar_serie_pc/{serie?}', [InventarioController::class, 'comprobar_serie_pc'])->name('inventario.comprobar_serie_pc');
    Route::get('/inventario/include_formulario_pc_editar/{pc_id?}', [InventarioController::class, 'include_formulario_pc_editar'])->name('inventario.include_formulario_pc_editar');
    
    //RUTAS IMPRESORA
    Route::get('/inventario/impresoras', [InventarioController::class, 'impresoras'])->name('inventario.impresoras');
    Route::get('/inventario/impresora_export_excel', [ExportExcelImpresoraController::class, 'export'])->name('inventario.impresora_export_excel');
    Route::get('/inventario/impresora_list', [InventarioController::class, 'impresora_list'])->name('inventario.impresora_list');
    Route::post('/inventario/impresora_update/{impresora_id?}', [InventarioController::class, 'impresora_update'])->name('inventario.impresora_update');
    Route::post('/inventario/impresora_create', [InventarioController::class, 'impresora_create'])->name('inventario.impresora_create');
    Route::post('/inventario/impresora_delete/{impresora_id?}', [InventarioController::class, 'impresora_delete'])->name('inventario.impresora_delete');
    Route::get('/inventario/include_formulario_impresora_crear', [InventarioController::class, 'include_formulario_impresora_crear'])->name('inventario.include_formulario_impresora_crear');
    Route::get('/inventario/include_detalle_impresora/{impresora_id?}', [InventarioController::class, 'include_detalle_impresora'])->name('inventario.include_detalle_impresora');
    Route::get('/inventario/include_editar_impresora/{impresora_id?}', [InventarioController::class, 'include_editar_impresora'])->name('inventario.include_editar_impresora');
    Route::get('/inventario/comprobar_serie_impresora/{serie?}', [InventarioController::class, 'comprobar_serie_impresora'])->name('inventario.comprobar_serie_impresora');
    Route::get('/inventario/include_formulario_impresora_editar/{impresora_id?}', [InventarioController::class, 'include_formulario_impresora_editar'])->name('inventario.include_formulario_impresora_editar');

    //RUTAS ANEXO
    Route::get('/inventario/anexos', [InventarioController::class, 'anexos'])->name('inventario.anexos');
    Route::get('/inventario/anexo_export_excel', [ExportExcelAnexoController::class, 'export'])->name('inventario.anexo_export_excel');
    Route::get('/inventario/anexo_list', [InventarioController::class, 'anexo_list'])->name('inventario.anexo_list');
    Route::post('/inventario/anexo_update/{anexo_id?}', [InventarioController::class, 'anexo_update'])->name('inventario.anexo_update');
    Route::post('/inventario/anexo_create', [InventarioController::class, 'anexo_create'])->name('inventario.anexo_create');
    Route::post('/inventario/anexo_delete/{anexo_id?}', [InventarioController::class, 'anexo_delete'])->name('inventario.anexo_delete');
    Route::get('/inventario/include_formulario_anexo_crear', [InventarioController::class, 'include_formulario_anexo_crear'])->name('inventario.include_formulario_anexo_crear');
    Route::get('/inventario/include_detalle_anexo/{anexo_id?}', [InventarioController::class, 'include_detalle_anexo'])->name('inventario.include_detalle_anexo');
    Route::get('/inventario/include_editar_anexo/{anexo_id?}', [InventarioController::class, 'include_editar_anexo'])->name('inventario.include_editar_anexo');
    Route::get('/inventario/comprobar_serie_anexo/{serie?}', [InventarioController::class, 'comprobar_serie_anexo'])->name('inventario.comprobar_serie_anexo');
    Route::get('/inventario/include_formulario_anexo_editar/{anexo_id?}', [InventarioController::class, 'include_formulario_anexo_editar'])->name('inventario.include_formulario_anexo_editar');
    
    //RUTAS HUELLERO
    Route::get('/inventario/huelleros', [InventarioController::class, 'huelleros'])->name('inventario.huelleros');
    Route::get('/inventario/huellero_export_excel', [ExportExcelHuelleroController::class, 'export'])->name('inventario.huellero_export_excel');
    Route::get('/inventario/huellero_list', [InventarioController::class, 'huellero_list'])->name('inventario.huellero_list');
    Route::post('/inventario/huellero_update/{huellero_id?}', [InventarioController::class, 'huellero_update'])->name('inventario.huellero_update');
    Route::post('/inventario/huellero_create', [InventarioController::class, 'huellero_create'])->name('inventario.huellero_create');
    Route::post('/inventario/huellero_delete/{huellero_id?}', [InventarioController::class, 'huellero_delete'])->name('inventario.huellero_delete');
    Route::get('/inventario/include_formulario_huellero_crear', [InventarioController::class, 'include_formulario_huellero_crear'])->name('inventario.include_formulario_huellero_crear');
    Route::get('/inventario/include_detalle_huellero/{huellero_id?}', [InventarioController::class, 'include_detalle_huellero'])->name('inventario.include_detalle_huellero');
    Route::get('/inventario/include_editar_huellero/{huellero_id?}', [InventarioController::class, 'include_editar_huellero'])->name('inventario.include_editar_huellero');
    Route::get('/inventario/comprobar_serie_huellero/{serie?}', [InventarioController::class, 'comprobar_serie_huellero'])->name('inventario.comprobar_serie_huellero');
    Route::get('/inventario/include_formulario_huellero_editar/{huellero_id?}', [InventarioController::class, 'include_formulario_huellero_editar'])->name('inventario.include_formulario_huellero_editar');
    
    //RUTAS MONITOR
    Route::get('/inventario/monitores', [InventarioController::class, 'monitores'])->name('inventario.monitores');
    Route::get('/inventario/monitor_export_excel', [ExportExcelMonitorController::class, 'export'])->name('inventario.monitor_export_excel');
    Route::get('/inventario/monitor_list', [InventarioController::class, 'monitor_list'])->name('inventario.monitor_list');
    Route::get('/inventario/include_formulario_monitor_crear', [InventarioController::class, 'include_formulario_monitor_crear'])->name('inventario.include_formulario_monitor_crear');
    Route::post('/inventario/monitor_create', [InventarioController::class, 'monitor_create'])->name('inventario.monitor_create');
    Route::get('/inventario/comprobar_serie_monitor/{serie?}', [InventarioController::class, 'comprobar_serie_monitor'])->name('inventario.comprobar_serie_monitor');    
    Route::post('/inventario/monitor_delete/{monitor_id?}', [InventarioController::class, 'monitor_delete'])->name('inventario.monitor_delete');
    Route::get('/inventario/include_detalle_monitor/{monitor_id?}', [InventarioController::class, 'include_detalle_monitor'])->name('inventario.include_detalle_monitor');
    Route::get('/inventario/include_editar_monitor/{monitor_id?}', [InventarioController::class, 'include_editar_monitor'])->name('inventario.include_editar_monitor');
    Route::get('/inventario/include_formulario_monitor_editar/{monitor_id?}', [InventarioController::class, 'include_formulario_monitor_editar'])->name('inventario.include_formulario_monitor_editar');
    Route::post('/inventario/monitor_update/{monitor_id?}', [InventarioController::class, 'monitor_update'])->name('inventario.monitor_update');
    

    






});

require __DIR__.'/auth.php';
