<?php

namespace App\Exports;

use App\Models\Impresora;
use Maatwebsite\Excel\Concerns\FromCollection; // Interface para exportar desde una colección
use Maatwebsite\Excel\Concerns\WithHeadings; // Interface para definir encabezados

class PcExport implements FromCollection, WithHeadings
{
    /**
     * Devuelve todos los registros de la tabla 'pcs'.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //return Pc::all(); // Exporta todos los registros de la tabla 'pcs'

        return Impresora::select(
                                DB::Raw('impresora.id as impresora_id'),
                                'impresora.serie',
                                'impresora.num_inventario', 
                                DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
                                'ip.direccion_ip',
                                DB::Raw('edificio.nombre as nombre_edificio'),
                                DB::Raw('piso.nombre as nombre_piso'),
                                'sala.numero_sala',
                                'sala.nombre_sala'
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
                        ->orderBy('impresora.id','desc')
                        ->get();

    }

    /**
     * Define los encabezados de las columnas del Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Id', 
            'Serie',             
            'Número Inventario', 
            'Estado',             
            'IP',
            'Edificio',
            'Piso',
            'Número sala', 
            'Nombre sala', 
        ];
    }
}
