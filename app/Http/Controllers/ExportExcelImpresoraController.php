<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Impresora;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportExcelImpresoraController extends Controller
{

    public function export()
    {

        //try {

            $impresora_list = Impresora::select(
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
                'user_crea.name as nombre_user_crea',
                DB::Raw("DATE_FORMAT(impresora.fecha_crea, '%d/%m/%Y %H:%i') as fecha_user_crea"),
                'user_mod.name as nombre_user_mod',
                DB::Raw("DATE_FORMAT(impresora.fecha_mod, '%d/%m/%Y %H:%i') as fecha_user_mod"),
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
            ->leftJoin('users as user_crea','user_crea.id','=','impresora.user_crea_id')
            ->leftJoin('users as user_mod','user_mod.id','=','impresora.user_mod_id')
            ->leftJoin('propietario','propietario.id','=','impresora.propietario_id')
            ->orderBy('edificio.nombre','asc')
            ->orderBy('piso.nombre','asc')
            ->orderBy('sala.numero_sala','asc')
            ->orderBy('sala.nombre_sala','asc')
            ->get();
    
            // Crear una nueva instancia de Spreadsheet
            $spreadsheet = new Spreadsheet();
    
            // Obtener la hoja activa
            $sheet = $spreadsheet->getActiveSheet();

            $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T'];
            foreach ($columns as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
    
            // Definir los encabezados de las columnas
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Serie');
            $sheet->setCellValue('C1', 'Número Inventario');
            $sheet->setCellValue('D1', 'Estado');
            $sheet->setCellValue('E1', 'Propietario');
            $sheet->setCellValue('F1', 'Dirección IP');
            $sheet->setCellValue('G1', 'Edificio');
            $sheet->setCellValue('H1', 'Piso');
            $sheet->setCellValue('I1', 'Sala');
            $sheet->setCellValue('J1', 'Nombre Sala');
            $sheet->setCellValue('K1', 'Nombre Marca');
            $sheet->setCellValue('L1', 'Nombre Modelo');
            $sheet->setCellValue('M1', 'Tipo');
            $sheet->setCellValue('N1', 'Candado');
            $sheet->setCellValue('O1', 'Corriente');
            $sheet->setCellValue('P1', 'Observaciones');
            $sheet->setCellValue('Q1', 'Usuario crea');
            $sheet->setCellValue('R1', 'Fecha crea');
            $sheet->setCellValue('S1', 'Usuario mod');
            $sheet->setCellValue('T1', 'Fecha mod');
    
            // Poner en negrita los encabezados
            $sheet->getStyle('A1:T1')->getFont()->setBold(true);
    
            // Centrar los encabezados
            $sheet->getStyle('A1:T1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            
    
            // Rellenar las filas con los datos de los usuarios
            $row = 2; // Comenzamos en la fila 2, porque la fila 1 es para los encabezados
            foreach ($impresora_list as $impresora) {

                $sheet->setCellValue('A' . $row, $impresora->impresora_id);
                $sheet->setCellValue('B' . $row, $impresora->serie);
                $sheet->setCellValue('C' . $row, $impresora->num_inventario);
                $sheet->setCellValue('D' . $row, $impresora->estado_dispositivo);
                $sheet->setCellValue('E' . $row, $impresora->nombre_propietario);
                $sheet->setCellValue('F' . $row, $impresora->direccion_ip);
                $sheet->setCellValue('G' . $row, $impresora->nombre_edificio);
                $sheet->setCellValue('H' . $row, $impresora->nombre_piso);
    
                // Asignar el teléfono como texto (solo en la columna 'H')
                $sheet->setCellValueExplicit('I' . $row, $impresora->numero_sala, DataType::TYPE_STRING);
    
                $sheet->setCellValue('J' . $row, $impresora->nombre_sala);
                $sheet->setCellValue('K'. $row, $impresora->nombre_marca);
                $sheet->setCellValue('L'. $row, $impresora->nombre_modelo);
                $sheet->setCellValue('M'. $row, $impresora->tipo_impresora);
                $sheet->setCellValue('N'. $row, $impresora->candado);
                $sheet->setCellValue('O'. $row, $impresora->corriente);
                $sheet->setCellValue('P'. $row, $impresora->observaciones);
                $sheet->setCellValue('Q'. $row, $impresora->nombre_user_crea);
                $sheet->setCellValue('R'. $row, $impresora->fecha_user_crea);
                $sheet->setCellValue('S'. $row, $impresora->nombre_user_mod);
                $sheet->setCellValue('T'. $row, $impresora->fecha_user_mod);

                $row++;
            

            }
    
            // Crear un escritor y guardarlo en un archivo Excel
            $writer = new Xlsx($spreadsheet);
    
            // Descargar el archivo Excel
            $fileName = 'impresora_reporte.xlsx';
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
