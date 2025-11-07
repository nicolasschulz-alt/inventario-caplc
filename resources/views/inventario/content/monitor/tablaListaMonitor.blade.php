<table id="tablaListadoMonitor" route="{{route('inventario.monitor_list')}}" class="table table-striped table-bordered table-hover" style="width:100%">
    @foreach ($monitor_list as $item)
        <tr>
            <td>{{$item->monitor_id}}</td>
            <td>                
                @if (isset($item->nombre_modelo) && !empty($item->nombre_modelo))
                    {{$item->nombre_modelo}}
                @else
                    {{ "--" }}
                @endif
            </td>
            <td>{{$item->serie}}</td>
            <td>
                @if (isset($item->sala_id))
                    {{$item->nombre_edificio}}{{$item->nombre_piso}}.{{$item->numero_sala}} ({{$item->nombre_sala}})
                @else
                    {{ "--" }}
                @endif
            </td>
            <td>
                @if ($item->estado_id == 1)
                    <span class="badge badge-success p-1"  style="font-size: .875rem;">{{$item->estado_dispositivo}}</span>
                @elseif ($item->estado_id == 2)
                    <span class="badge badge-danger p-1"  style="font-size: .875rem;">{{$item->estado_dispositivo}}</span>
                @elseif ($item->estado_id == 3)
                    <span class="badge badge-dark p-1"  style="font-size: .875rem;">{{$item->estado_dispositivo}}</span>
                @else
                    <span class="badge badge-default p-1"  style="font-size: .875rem;">--</span>
                @endif
            </td>
            <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button onclick="monitor_detalle({{$item->monitor_id}})"  type="button" class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Detalle"><i class="fas fa-eye fa-sm"></i></button>
                    <button onclick="editar_monitor({{$item->monitor_id}})"   type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen fa-sm"></i></button>
                    <button onclick="eliminar_monitor({{$item->monitor_id}})" type="button" id="eliminar_monitor_{{$item->monitor_id}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Borrar"><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>
        </tr>
    @endforeach
</table>

<script>
    $(document).ready(function () {

        $('#tablaListadoMonitor').DataTable({
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
                {title: 'Modelo'},
                {title: 'Serie'},
                {title: 'Ubicación'},
                {title: 'Estado'},
                {title: 'Acciones'},
            ],
            headerCallback: function(thead, data, start, end, display) {
                $(thead).find('th').addClass('text-primary');
            },
            drawCallback: function(settings) {
                $('#tablaListadoMonitor tbody td').addClass('text_black');
            },
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

    async function monitor_detalle(monitor_id){
        loader('show');
        console.log('detalle monitor:',monitor_id);
        const route = $('#route_include_detalle_monitor').val()+`/${monitor_id}`;
        try {
            const response = await fetch(route);

            if (response.redirected){
                location.replace("/login");
                throw new Error('Redireccionado');
            }
            if (!response.ok){
                print_swal_status(response.status);
                throw new Error('Error response eliminar');
            }
            const data = await response.json();
            
            $('#body_modal_detalle_monitor').html(data);

            setTimeout(() => {

                loader('hide');

                $('#modal_detalle_monitor').modal({
                    keyboard: true
                }).modal('show');

            }, 200);
            
        } catch (error) {
            loader('hide');
            console.error(error);
        }
    }

    async function editar_monitor(monitor_id,cerrar_detalle = null){
        if (cerrar_detalle){
            $('#modal_detalle_monitor').modal('hide');
        }
        console.log('editar monitor:',monitor_id);
        loader('show');
        const route = $('#route_include_editar_monitor').val()+`/${monitor_id}`;
        try {
            const response = await fetch(route);

            if (response.redirected){
                location.replace("/login");
                throw new Error('Redireccionado');
            }
            if (!response.ok){
                console.log(response.status);
                print_swal_status(response.status);
                throw new Error('Error response editar');
            }
            const data = await response.json();

            $('#body_modal_editar_monitor').html(data);

            setTimeout(() => {

                loader('hide');

                $('#modal_editar_monitor').modal({
                    keyboard: false,
                    backdrop: 'static'
                }).modal('show');

            }, 200);
            
        } catch (error) {
            loader('hide');
            console.error(error);
        }
    }

    async function eliminar_monitor(monitor_id){

        $(`#eliminar_monitor_${monitor_id}`).blur();

        const route = $('#route_monitor_delete').val()+`/${monitor_id}`;

        console.log(route);

        console.log('eliminar monitor:',monitor_id);
        //boton azul : 3085d6
        //boton rojo : d33
        //boton azul : 3085d6
        Swal.fire({
            title: "¿Desea Eliminar?",
                text: "",
                icon: "question",
                showCancelButton: true,
                //confirmButtonColor: "#d33",
                //cancelButtonColor: "#d33",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-secondary"
                },
                confirmButtonText: "Sí, Eliminar",
                cancelButtonText: "No",
        }).then(async(result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch(route, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    if (response.redirected){
                        location.replace("/login");
                        throw new Error('Redireccionado');
                    }
                    if (!response.ok){
                        print_swal_status(response.status);
                        throw new Error('Error response eliminar');
                    }
                    const data = await response.json();
                    console.log(data);
                    if (data.status == 200){

                        console.log('Eliminacion correcta:', data);

                        loader('stop');
                        Swal.fire({
                            title: "Eliminado con éxito",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        await cargarVistaTablaListadoMonitor();
                        loader('continue');

                    }
                } catch (error) {
                    console.error(error);
                }
            }
        });
    }
</script>