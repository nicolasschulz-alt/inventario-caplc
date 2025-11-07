<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pc;
use App\Models\PcApp;
use App\Models\App;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportExcelPcController extends Controller
{

    public function export()
    {
        //try {
                $cat_app_so = 1;
                $cat_app_office = 3;
                $cat_app_antivirus = 2;
                $cat_app_escritorio = 4;

            $pc_list = Pc::select(
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
                'tipo_disco_pc.nombre as tipo_disco',
                'candado_id',
                'candado.nombre as candado',
                'corriente_id',
                'corriente.nombre as corriente',
                'oc_id',
                'orden_compra.descripcion as orden_compra',
                'pc.observaciones',
                'estado_id',
                'user_crea.name as nombre_user_crea',
                DB::Raw("DATE_FORMAT(pc.fecha_crea, '%d/%m/%Y %H:%i') as fecha_user_crea"),
                'user_mod.name as nombre_user_mod',
                DB::Raw("DATE_FORMAT(pc.fecha_mod, '%d/%m/%Y %H:%i') as fecha_user_mod"),
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
            ->leftJoin('tipo_disco_pc','tipo_disco_pc.id','=','disco_pc.tipo_disco_id')
            ->leftJoin('candado','candado.id','=','pc.candado_id')
            ->leftJoin('corriente','corriente.id','=','pc.corriente_id')
            ->leftJoin('orden_compra','orden_compra.id','=','pc.oc_id')
            ->leftJoin('users as user_crea','user_crea.id','=','pc.user_crea_id')
            ->leftJoin('users as user_mod','user_mod.id','=','pc.user_mod_id')
            ->leftJoin('propietario','propietario.id','=','pc.propietario_id')
            ->orderBy('edificio.nombre','asc')
            ->orderBy('piso.nombre','asc')
            ->orderBy('sala.numero_sala','asc')
            ->orderBy('sala.nombre_sala','asc')
            ->get();
    
            if ($pc_list->isNotEmpty()){

                foreach ($pc_list as $pc) {

                    $sistema_operativo = PcApp::leftJoin('app','app.id','=','pc_app.app_id')
                                                ->where('pc_app.pc_id','=',$pc->pc_id)
                                                ->where('app.categoria_id','=',$cat_app_so)
                                                ->orderBy('app.id','asc')
                                                ->first();

                    $office = PcApp::leftJoin('app','app.id','=','pc_app.app_id')
                                    ->where('pc_app.pc_id','=',$pc->pc_id)
                                    ->where('app.categoria_id','=',$cat_app_office)
                                    ->orderBy('app.id','asc')
                                    ->first();

                    $antivirus = PcApp::leftJoin('app','app.id','=','pc_app.app_id')
                                        ->where('pc_app.pc_id','=',$pc->pc_id)
                                        ->where('app.categoria_id','=',$cat_app_antivirus)
                                        ->orderBy('app.id','asc')
                                        ->first();

                    $app_ecritorio = PcApp::leftJoin('app','app.id','=','pc_app.app_id')
                                            ->where('pc_app.pc_id','=',$pc->pc_id)
                                            ->where('app.categoria_id','=',$cat_app_escritorio)
                                            ->orderBy('app.id','asc')
                                            ->get();
                    
                    $pc->sistema_operativo = isset($sistema_operativo) ? $sistema_operativo : null;
                    $pc->office = isset($office) ? $office : null;
                    $pc->antivirus = isset($antivirus) ? $antivirus : null;
                    $pc->app_ecritorio = $app_ecritorio->isNotEmpty() ? $app_ecritorio : null;
                    
                }
    
            }
    
            // Crear una nueva instancia de Spreadsheet
            $spreadsheet = new Spreadsheet();
    
            // Obtener la hoja activa
            $sheet = $spreadsheet->getActiveSheet();

            $appsEscritorio = App::select('id','nombre')
                                ->where('app.categoria_id','=',$cat_app_escritorio)
                                ->orderBy('app.id','asc')
                                ->get();

            // Ajustar el ancho de las columnas manualmente según el contenido
            $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','AA','AB','AC','AD'];
            foreach ($columns as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
    
            // Definir los encabezados de las columnas
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Serie');
            $sheet->setCellValue('C1', 'Número inventario');
            $sheet->setCellValue('D1', 'Estado');
            $sheet->setCellValue('E1', 'Propietario');
            $sheet->setCellValue('F1', 'Dirección IP');
            $sheet->setCellValue('G1', 'Edificio');
            $sheet->setCellValue('H1', 'Piso');
            $sheet->setCellValue('I1', 'Sala');
            $sheet->setCellValue('J1', 'Nombre sala');
            $sheet->setCellValue('K1', 'Nombre equipo');
            $sheet->setCellValue('L1', 'Nombre usuario ad');
            $sheet->setCellValue('M1', 'Nombre marca');
            $sheet->setCellValue('N1', 'Nombre modelo');
            $sheet->setCellValue('O1', 'Tipo');
            $sheet->setCellValue('P1', 'CPU');
            $sheet->setCellValue('Q1', 'RAM');
            $sheet->setCellValue('R1', 'Disco');
            $sheet->setCellValue('S1', 'Candado');
            $sheet->setCellValue('T1', 'Corriente');
            $sheet->setCellValue('U1', 'Orden compra');
            $sheet->setCellValue('V1', 'Observaciones');

            $sheet->setCellValue('W1', 'Usuario crea');
            $sheet->setCellValue('X1', 'Fecha crea');

            $sheet->setCellValue('Y1', 'Usuario mod');
            $sheet->setCellValue('Z1', 'Fecha mod');

            $sheet->setCellValue('AA1', 'Sistema operativo');
            $sheet->setCellValue('AB1', 'Licencia SO');

            $sheet->setCellValue('AC1', 'Office');
            $sheet->setCellValue('AD1', 'Licencia Office');
    
            // Poner en negrita los encabezados
            $sheet->getStyle('A1:AD1')->getFont()->setBold(true);
    
            // Centrar los encabezados
            $sheet->getStyle('A1:AD1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
            // Rellenar las filas con los datos de los usuarios
            $row = 2; // Comenzamos en la fila 2, porque la fila 1 es para los encabezados
            foreach ($pc_list as $pc) {
                $sheet->setCellValue('A' . $row, $pc->pc_id);
                $sheet->setCellValue('B' . $row, $pc->serie);
                $sheet->setCellValue('C' . $row, $pc->num_inventario);
                $sheet->setCellValue('D' . $row, $pc->estado_dispositivo);
                $sheet->setCellValue('E' . $row, $pc->nombre_propietario);
                $sheet->setCellValue('F' . $row, $pc->direccion_ip);
                $sheet->setCellValue('G' . $row, $pc->nombre_edificio);
                $sheet->setCellValue('H' . $row, $pc->nombre_piso);
                //$sheet->setCellValue('H' . $row, $pc->numero_sala);
    
                // Asignar el teléfono como texto (solo en la columna 'H')
                $sheet->setCellValueExplicit('I' . $row, $pc->numero_sala, DataType::TYPE_STRING);
    
                $sheet->setCellValue('J' . $row, $pc->nombre_sala);
    
                $sheet->setCellValue('K'. $row, $pc->nombre_equipo);
                $sheet->setCellValue('L'. $row, $pc->nombre_usuario_ad);
                $sheet->setCellValue('M'. $row, $pc->nombre_marca);
                $sheet->setCellValue('N'. $row, $pc->nombre_modelo);
                $sheet->setCellValue('O'. $row, $pc->tipo_pc);
                $sheet->setCellValue('P'. $row, $pc->cpu);
                $sheet->setCellValue('Q'. $row, $pc->ram);
                $sheet->setCellValue('R'. $row, isset($pc->disco) ? $pc->disco . ' (' . $pc->tipo_disco . ')' : '');
                $sheet->setCellValue('S'. $row, $pc->candado);
                $sheet->setCellValue('T'. $row, $pc->corriente);
                $sheet->setCellValue('U'. $row, $pc->orden_compra);
                $sheet->setCellValue('V'. $row, $pc->observaciones);
                $sheet->setCellValue('W'. $row, $pc->nombre_user_crea);
                $sheet->setCellValue('X'. $row, $pc->fecha_user_crea);
                $sheet->setCellValue('Y'. $row, $pc->nombre_user_mod);
                $sheet->setCellValue('Z'. $row, $pc->fecha_user_mod);

                if (isset($pc->sistema_operativo)){
                    if (isset($pc->sistema_operativo->licencia) && !empty($pc->sistema_operativo->licencia)){
                        $sheet->setCellValue('AA'. $row, $pc->sistema_operativo->nombre);
                        $sheet->setCellValue('AB'. $row, $pc->sistema_operativo->licencia);
                    } else {
                        if ($pc->sistema_operativo->tiene_licencia == 0){
                            $sheet->setCellValue('AA'. $row, $pc->sistema_operativo->nombre);
                            $sheet->setCellValue('AB'. $row, 'Sin licencia');
                        } else if ($pc->sistema_operativo->tiene_licencia == 2){
                            $sheet->setCellValue('AA'. $row, $pc->sistema_operativo->nombre);
                            $sheet->setCellValue('AB'. $row, 'No aplica licencia');
                        }
                    }
                } else {
                    $sheet->setCellValue('AA'. $row, '');
                    $sheet->setCellValue('AB'. $row, '');
                }

                
                if (isset($pc->office)){                    
                    if (isset($pc->office->licencia) && !empty($pc->office->licencia)){
                        $sheet->setCellValue('AC'. $row, $pc->office->nombre);
                        $sheet->setCellValue('AD'. $row, $pc->office->licencia);
                    } else {
                        if ($pc->office->tiene_licencia == 0){
                            $sheet->setCellValue('AC'. $row, $pc->office->nombre);
                            $sheet->setCellValue('AD'. $row, 'Sin licencia');
                        } else if ($pc->office->tiene_licencia == 2){
                            $sheet->setCellValue('AC'. $row, $pc->office->nombre);
                            $sheet->setCellValue('AD'. $row, 'No aplica licencia');
                        }
                    }                    
                } else {
                    $sheet->setCellValue('AC'. $row, '');
                    $sheet->setCellValue('AD'. $row, '');
                }
                
                $column = 'AE';
                if ($pc->app_ecritorio != null){
                    foreach ($appsEscritorio as $appE) {
                        foreach ($pc->app_ecritorio as $app_e) {
                            if ($app_e->id == $appE->id){
                                if (isset($app_e->licencia) && !empty($app_e->licencia)){
                                    $sheet->setCellValue($column . $row, $app_e->licencia);
                                } else {
                                    if ($app_e->tiene_licencia == 0){
                                        $sheet->setCellValue($column . $row, 'Sin licencia');
                                    } else if ($app_e->tiene_licencia == 2){
                                        $sheet->setCellValue($column . $row, 'No aplica licencia');
                                    }
                                }
                            }
                        }
                        $column++;
                    }
                } else {
                    foreach ($appsEscritorio as $appE) {
                        $sheet->setCellValue($column . $row, '');
                        $sheet->setCellValue($column . $row, '');
                        $column++;
                    }
                }
    
                $row++;
            }


            $column = 'AE';
            
            // Colocar los nuevos encabezados después de "Y"
            foreach ($appsEscritorio as $header) {
                $sheet->setCellValue($column . '1', $header->nombre);
                $sheet->getStyle($column . '1', $header->nombre)->getFont()->setBold(true);
                $sheet->getColumnDimension($column)->setAutoSize(true);
                $column++; // Avanzamos a la siguiente columna (Z)
            }
    
            // Crear un escritor y guardarlo en un archivo Excel
            $writer = new Xlsx($spreadsheet);
    
            // Descargar el archivo Excel
            $fileName = 'pc_reporte.xlsx';
            return response()->stream(
                function () use ($writer) {
                    $writer->save('php://output');
                },
                200,
                [
                    "Content-Type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                    "Content-Disposition" => "attachment; filename=$fileName",
                ]
            );
            
        //} catch (\Throwable $th) {
        //    return redirect()->route('inventario.pc');
        //}

    }
    
}
