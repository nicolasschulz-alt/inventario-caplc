<?php

namespace App\Exports;

use App\Models\Pc;
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

        return Pc::select(
                                DB::Raw('pc.id as pc_id'),
                                'pc.serie',
                                'pc.num_inventario', 
                                DB::Raw('estado_dispositivo.nombre as estado_dispositivo'),
                                'ip.direccion_ip',
                                DB::Raw('edificio.nombre as nombre_edificio'),
                                DB::Raw('piso.nombre as nombre_piso'),
                                'sala.numero_sala',
                                'sala.nombre_sala'
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
                        ->leftJoin('telefono','telefono.id','=','pc.telefono_id')
                        ->leftJoin('candado','candado.id','=','pc.candado_id')
                        ->leftJoin('corriente','corriente.id','=','pc.corriente_id')
                        ->leftJoin('orden_compra','orden_compra.id','=','pc.oc_id')
                        ->orderBy('pc.id','desc')
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
