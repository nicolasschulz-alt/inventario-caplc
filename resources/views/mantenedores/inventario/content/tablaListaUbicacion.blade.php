<table id="tablaListadoUbicacion" route="{{route('inventario.mantenedor.ubicacion_list')}}" class="table table-striped table-bordered table-hover" style="width:100%">
    @foreach ($sala_list as $item)
        <tr>
            <td width="8%">{{$item->id}}</td>
            <td>                
                {{$item->nombre_edificio}}{{$item->nombre_piso}}.{{$item->numero_sala}} 
                @if (isset($item->nombre_sala))
                    ({{$item->nombre_sala}}) 
                @else
                    (Nombre sala No asignado)
                @endif
            </td>
            <td width="8%">
                <div class="btn-group" role="group" aria-label="Basic example">
                    {{-- <button onclick="ubicacion_detalle({{$item->id}})"  type="button" class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Detalle"><i class="fas fa-eye fa-sm"></i></button> --}}
                    <button onclick="editar_ubicacion({{$item->id}})"   type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen fa-sm"></i></button>
                    {{-- <button onclick="eliminar_ubicacion({{$item->id}})" type="button" id="eliminar_ubicacion_{{$item->id}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Borrar"><i class="fas fa-trash-alt"></i></button> --}}
                </div>
            </td>
        </tr>
    @endforeach

</table>

<script>

    $(document).ready(function () {

        

        $('#tablaListadoUbicacion').DataTable({
            paging: true,
            scrollCollapse: true,
            scrollY: '50vh',
            scrollX: true,
            autoWidth: true,
            columnDefs: [
                { width: 'auto', targets: '_all' }
            ]
            ,columns: [
                {title: 'ID'},
                {title: 'Ubicación'},
                {title: 'Acciones'},
            ],

            language: {
                "lengthMenu": "_MENU_ registros por página",
                "zeroRecords": "No se encontraron registros",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(filtrados de un total de _MAX_ registros)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            order: [[0, 'desc']] //ordena por la primera columna
        }).on('draw', function () {
            $('[data-toggle="tooltip"]').tooltip('dispose'); // Limpia tooltips antiguos
            $('[data-toggle="tooltip"]').tooltip({ boundary: 'window' });          // Inicializa los nuevos
        });

        //$(function () {
            $('[data-toggle="tooltip"]').tooltip({ boundary: 'window' });
        //});    
        
    });

    async function editar_ubicacion(sala_id,cerrar_detalle = null){
        if (cerrar_detalle){
            $('#modal_detalle_ubicacion').modal('hide');
        }
        console.log('editar ubicacion:',sala_id);
        loader('show');
        const route = $('#route_include_editar_ubicacion').val()+`/${sala_id}`;
        try {
            const response = await fetch(route);

            if (response.redirected){
                location.replace("/login");
                throw new Error('Redireccionado');
            }
            if (!response.ok){
                throw new Error('Error response editar');
            }
            const data = await response.json();

            $('#body_modal_editar_ubicacion').html(data);

            setTimeout(() => {

                loader('hide');

                $('#modal_editar_ubicacion').modal({
                    keyboard: false,
                    backdrop: 'static'
                }).modal('show');

            }, 1000);
            
        } catch (error) {
            loader('hide');
            console.error(error);
        }
    }

    
</script>