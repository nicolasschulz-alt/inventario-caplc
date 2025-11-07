<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Anexo;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportExcelAnexoController extends Controller
{

    public function export()
    {

        //try {

            $anexo_list = Anexo::select(
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
                'user_crea.name as nombre_user_crea',
                DB::Raw("DATE_FORMAT(anexo.fecha_crea, '%d/%m/%Y %H:%i') as fecha_user_crea"),
                'user_mod.name as nombre_user_mod',
                DB::Raw("DATE_FORMAT(anexo.fecha_mod, '%d/%m/%Y %H:%i') as fecha_user_mod"),
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
            ->leftJoin('users as user_crea','user_crea.id','=','anexo.user_crea_id')
            ->leftJoin('users as user_mod','user_mod.id','=','anexo.user_mod_id')
            ->leftJoin('propietario','propietario.id','=','anexo.propietario_id')
            //->orderBy('pc.id','desc')

            ->orderBy('edificio.nombre','asc')
            ->orderBy('piso.nombre','asc')
            ->orderBy('sala.numero_sala','asc')
            ->orderBy('sala.nombre_sala','asc')

            ->get();
            //dd($anexo_list);
    
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
            $sheet->setCellValue('D1', 'Mac');
            $sheet->setCellValue('E1', 'Anexo');
            $sheet->setCellValue('F1', 'Identificador');
            $sheet->setCellValue('G1', 'Estado');
            $sheet->setCellValue('H1', 'Propietario');
            $sheet->setCellValue('I1', 'Edificio');
            $sheet->setCellValue('J1', 'Piso');
            $sheet->setCellValue('K1', 'Sala');
            $sheet->setCellValue('L1', 'Nombre sala');
            $sheet->setCellValue('M1', 'Nombre Marca');
            $sheet->setCellValue('N1', 'Nombre Modelo');
            $sheet->setCellValue('O1', 'Categoría');
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
            foreach ($anexo_list as $anexo) {

                $sheet->setCellValue('A' . $row, $anexo->anexo_id);
                $sheet->setCellValue('B' . $row, $anexo->serie);
                $sheet->setCellValue('C' . $row, $anexo->num_inventario);

                $sheet->setCellValue('D' . $row, $anexo->mac);
                $sheet->setCellValue('E' . $row, $anexo->anexo);
                $sheet->setCellValue('F' . $row, $anexo->identificador);

                $sheet->setCellValue('G' . $row, $anexo->estado_dispositivo);
                $sheet->setCellValue('H' . $row, $anexo->nombre_propietario);
                $sheet->setCellValue('I' . $row, $anexo->nombre_edificio);
                $sheet->setCellValue('J' . $row, $anexo->nombre_piso);
    
                // Asignar el teléfono como texto (solo en la columna 'H')
                $sheet->setCellValueExplicit('K' . $row, $anexo->numero_sala, DataType::TYPE_STRING);
    
                $sheet->setCellValue('L' . $row, $anexo->nombre_sala);
                $sheet->setCellValue('M'. $row, $anexo->nombre_marca);
                $sheet->setCellValue('N'. $row, $anexo->nombre_modelo);
                $sheet->setCellValue('O'. $row, $anexo->categoria_anexo);
                $sheet->setCellValue('P'. $row, $anexo->observaciones);
                $sheet->setCellValue('Q'. $row, $anexo->nombre_user_crea);
                $sheet->setCellValue('R'. $row, $anexo->fecha_user_crea);
                $sheet->setCellValue('S'. $row, $anexo->nombre_user_mod);
                $sheet->setCellValue('T'. $row, $anexo->fecha_user_mod);

                $row++;
            

            }
    
            // Crear un escritor y guardarlo en un archivo Excel
            $writer = new Xlsx($spreadsheet);
    
            // Descargar el archivo Excel
            $fileName = 'anexo_reporte.xlsx';
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
