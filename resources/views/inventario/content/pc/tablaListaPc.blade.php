<table id="tablaListadoPc" route="{{route('inventario.pc_list')}}" class="table table-striped table-bordered table-hover" style="width:100%">
    @foreach ($pc_list as $item)
        <tr>
            <td>{{$item->pc_id}}</td>
            <td>{{$item->serie}}</td>
            <td>
                @if (isset($item->num_inventario) && !empty($item->num_inventario))
                    {{$item->num_inventario}}
                @else
                    {{ "--" }}
                @endif
            </td>
            <td>
                @if (isset($item->direccion_ip) && !empty($item->direccion_ip))
                    {{$item->direccion_ip}}
                @else
                    {{ "--" }}
                @endif
            </td>
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
                    <button onclick="pc_detalle({{$item->pc_id}})"  type="button" class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Detalle"><i class="fas fa-eye fa-sm"></i></button>
                    <button onclick="editar_pc({{$item->pc_id}})"   type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen fa-sm"></i></button>
                    <button onclick="eliminar_pc({{$item->pc_id}})" type="button" id="eliminar_pc_{{$item->pc_id}}" class="btn btn-danger btn-sm" data-toggle="tooltip-{{$item->pc_id}}" data-placement="top" title="Borrar"><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>
        </tr>
    @endforeach
</table>

<script>
    $(document).ready(function () {

        $('#tablaListadoPc').DataTable({
            paging: true,
            scrollCollapse: true,
            scrollY: '50vh',
            scrollX: true,
            autoWidth: true,
            columnDefs: [
                { width: 'auto', targets: '_all' }
            ],
            columns: [
                {title: 'ID'},
                {title: 'Serie'},
                {title: 'Inventario'},
                {title: 'Ip'},
                {title: 'Ubicación'},
                {title: 'Estado'},
                {title: 'Acciones'},
            ],
            headerCallback: function(thead, data, start, end, display) {
                $(thead).find('th').addClass('text-primary');
            },
            drawCallback: function(settings) {
                $('#tablaListadoPc tbody td').addClass('text_black');
            },
            language: {
                "lengthMenu": "_MENU_ registros por página",
                "zeroRecords": "No se encontraron registros",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(filtrados de un total de _MAX_ registros)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Prgimero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            order: [[0, 'desc']] //ordena por la primera columna
        }).on('draw', function () {
            $('[data-toggle^="tooltip"]').tooltip('dispose'); // Limpia tooltips antiguos
            $('[data-toggle^="tooltip"]').tooltip({ boundary: 'window' });          // Inicializa los nuevos
        });

        //$(function () {
            $('[data-toggle^="tooltip"]').tooltip({ boundary: 'window' });
        //});

        /* $('#listado_pc').on('click','button[id^="eliminar_pc_"]', function (event) {
            console.log(event);
            $(this).tooltip('hide');
        }); */
        
        /* $('#listado_pc').on('click','button[id^="eliminar_pc_"]', function (event) {
            console.log(event);
            $(this).tooltip('hide');
            //setTimeout(() => {
            //    $(this).tooltip('hide');
            //    $(this).blur();
            //}, 100);
            
        }); */
        
    });

    async function pc_detalle(pc_id){
        loader('show');
        console.log('detalle pc:',pc_id);
        const route = $('#route_include_detalle_pc').val()+`/${pc_id}`;
        try {
            const response = await fetch(route);

            if (response.redirected){
                location.replace("/login");
                throw new Error('Redireccionado');
            }
            if (!response.ok){
                print_swal_status(response.status);
                throw new Error('Error response detalle');
            }
            const data = await response.json();
            
            $('#body_modal_detalle_pc').html(data);

            setTimeout(() => {

                loader('hide');

                $('#modal_detalle_pc').modal({
                    keyboard: true
                }).modal('show');

            }, 200);
            
        } catch (error) {
            loader('hide');
            console.error(error);
        }
    }

    async function editar_pc(pc_id,cerrar_detalle = null){
        if (cerrar_detalle){
            $('#modal_detalle_pc').modal('hide');
        }
        console.log('editar pc:',pc_id);
        loader('show');
        const route = $('#route_include_editar_pc').val()+`/${pc_id}`;
        try {
            const response = await fetch(route);

            if (response.redirected){
                location.replace("/login");
                throw new Error('Redireccionado');
            }
            if (!response.ok){
                print_swal_status(response.status);
                throw new Error('Error response editar');
            }
            const data = await response.json();

            $('#body_modal_editar_pc').html(data);

            setTimeout(() => {

                loader('hide');

                $('#modal_editar_pc').modal({
                    keyboard: false,
                    backdrop: 'static'
                }).modal('show');

            }, 200);
            
        } catch (error) {
            loader('hide');
            console.error(error);
        }
    }

    async function eliminar_pc(pc_id){

        $(`#eliminar_pc_${pc_id}`).blur();
        //$(`[data-toggle="tooltip-${pc_id}"]`).tooltip('disable');

        const route = $('#route_pc_delete').val()+`/${pc_id}`;

        console.log(route);

        console.log('eliminar pc:',pc_id);

        Swal.fire({
            title: "¿Desea Eliminar?",
                text: "",
                icon: "question",
                showCancelButton: true,
                //confirmButtonColor: "#3085d6",
                //cancelButtonColor: "#d33",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-secondary"
                },
                confirmButtonText: "Sí, Eliminar",
                cancelButtonText: "No",
        }).then(async(result) => {
            if (result.isConfirmed) {
                //loader('show');
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

                        $(`[data-toggle="tooltip-${pc_id}"]`).tooltip('dispose');
                        loader('stop');
                        Swal.fire({
                            title: "Eliminado con éxito",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        await cargarVistaTablaListadoPc();
                        loader('continue');

                    }
                } catch (error) {
                    console.error(error);
                }
            }
        });
    }
</script>