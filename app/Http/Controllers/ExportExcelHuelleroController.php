<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Huellero;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportExcelHuelleroController extends Controller
{

    public function export()
    {

        //try {

            $huellero_list = Huellero::select(
                DB::Raw('huellero.id as huellero_id'),
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
            //->orderBy('pc.id','desc')

            ->orderBy('edificio.nombre','asc')
            ->orderBy('piso.nombre','asc')
            ->orderBy('sala.numero_sala','asc')
            ->orderBy('sala.nombre_sala','asc')

            ->get();
    
            // Crear una nueva instancia de Spreadsheet
            $spreadsheet = new Spreadsheet();
    
            // Obtener la hoja activa
            $sheet = $spreadsheet->getActiveSheet();

            $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L' , 'M', 'N', 'O','P'];
            foreach ($columns as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
    
            // Definir los encabezados de las columnas
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Serie');
            $sheet->setCellValue('C1', 'Número Inventario');
            $sheet->setCellValue('D1', 'Estado');
            $sheet->setCellValue('E1', 'Propietario');
            $sheet->setCellValue('F1', 'Edificio');
            $sheet->setCellValue('G1', 'Piso');
            $sheet->setCellValue('H1', 'Sala');
            $sheet->setCellValue('I1', 'Nombre Sala');
            $sheet->setCellValue('J1', 'Nombre Marca');
            $sheet->setCellValue('K1', 'Nombre Modelo');
            $sheet->setCellValue('L1', 'Observaciones');
            $sheet->setCellValue('M1', 'Usuario crea');
            $sheet->setCellValue('N1', 'Fecha crea');
            $sheet->setCellValue('O1', 'Usuario mod');
            $sheet->setCellValue('P1', 'Fecha mod');
    
            // Poner en negrita los encabezados
            $sheet->getStyle('A1:P1')->getFont()->setBold(true);
    
            // Centrar los encabezados
            $sheet->getStyle('A1:P1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
            // Rellenar las filas con los datos de los usuarios
            $row = 2; // Comenzamos en la fila 2, porque la fila 1 es para los encabezados
            foreach ($huellero_list as $huellero) {
                $sheet->setCellValue('A' . $row, $huellero->huellero_id);
                $sheet->setCellValue('B' . $row, $huellero->serie);
                $sheet->setCellValue('C' . $row, $huellero->num_inventario);
                $sheet->setCellValue('D' . $row, $huellero->estado_dispositivo);
                $sheet->setCellValue('E' . $row, $huellero->nombre_propietario);
                $sheet->setCellValue('F' . $row, $huellero->nombre_edificio);
                $sheet->setCellValue('G' . $row, $huellero->nombre_piso);
    
                // Asignar el teléfono como texto (solo en la columna 'H')
                $sheet->setCellValueExplicit('H' . $row, $huellero->numero_sala, DataType::TYPE_STRING);

                $sheet->setCellValue('I'. $row, $huellero->nombre_sala);
                $sheet->setCellValue('J'. $row, $huellero->nombre_marca);
                $sheet->setCellValue('K'. $row, $huellero->nombre_modelo);
                $sheet->setCellValue('L'. $row, $huellero->observaciones);
                $sheet->setCellValue('M'. $row, $huellero->nombre_user_crea);
                $sheet->setCellValue('N'. $row, $huellero->fecha_user_crea);
                $sheet->setCellValue('O'. $row, $huellero->nombre_user_mod);
                $sheet->setCellValue('P'. $row, $huellero->fecha_user_mod);

                $row++;

            }
    
            // Crear un escritor y guardarlo en un archivo Excel
            $writer = new Xlsx($spreadsheet);
    
            // Descargar el archivo Excel
            $fileName = 'huellero_reporte.xlsx';
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
