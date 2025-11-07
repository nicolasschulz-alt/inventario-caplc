<table id="tablaListadoPermisoUsuario" class="table table-dark table-striped table-bordered table-hover" style="width:100%">
    @foreach ($permiso_user_list as $item)
        <tr>
            <td>{{$item->permiso_id}}</td>
            <td>{{$item->nombre_sistema}}</td>
            <td>{{$item->nombre_rol}}</td>
            <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button onclick="editar_permiso_user({{$item->permiso_id}})"   type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen fa-sm"></i></button>
                    <button onclick="eliminar_permiso_user({{$item->permiso_id}})" type="button" id="eliminar_permiso_user_{{$item->permiso_id}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Borrar"><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>
        </tr>
    @endforeach
</table>

<script>
    $(document).ready(function () {

        $('#tablaListadoPermisoUsuario').DataTable({
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
                {title: 'Sistema'},
                {title: 'Rol'},
                {title: 'Acciones'},
            ],

            language: {
                "lengthMenu": "_MENU_ registros por página",
                "zeroRecords": "No se encontraron registros de Permisos",
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

        
        $('[data-toggle="tooltip"]').tooltip({ boundary: 'window' });

    });

    async function editar_permiso_user(permiso_id){
        console.log('editar permiso:',permiso_id);
        loader('show');
        const route = $('#route_include_form_permiso_user_update').val()+`/${permiso_id}`;
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

            $('#body_modal_editar_permiso_user').html(data);

            setTimeout(() => {

                loader('hide');

                $('#modal_editar_permiso_user').modal({
                    keyboard: false,
                    backdrop: 'static'
                }).modal('show');

            }, 200);
            
        } catch (error) {
            loader('hide');
            console.error(error);
        }
    }

    async function eliminar_permiso_user(permiso_id){

        $(`#eliminar_permiso_${permiso_id}`).blur();

        const route = $('#route_permiso_user_delete').val()+`/${permiso_id}`;

        console.log(route);

        console.log('eliminar permiso:',permiso_id);
        

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
                        throw new Error('Error response eliminar');
                    }
                    const data = await response.json();
                    console.log(data);
                    if (data.status == 200){

                        console.log('Eliminacion correcta:', data);

                        /* loader('hide');
                        
                        Swal.fire({
                            title: "Eliminado con éxito",
                            text: "",
                            icon: "success"
                        }).then(async(result) => {
                            if (result.isConfirmed) {
                                $(`#eliminar_permiso_user_${permiso_id}`).tooltip('hide'); //cierro el tooltip antes de actualizar la tabla (ya que o si no el boton no existirá)
                                await cargarTablaPermisoUser();
                            }
                        }); */

                        loader('stop');
                        Swal.fire({
                            title: "Eliminado con éxito",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        await cargarTablaPermisoUser();
                        loader('continue');

                    } /* else {
                        loader('hide');
                    } */
                } catch (error) {
                    //loader('hide');
                    console.error(error);
                    /* Swal.fire({
                        icon: "error",
                        title: "Error al Eliminar",
                        text: ""
                    }); */
                }
            } /* else {
                $(`#eliminar_permiso_user_${permiso_id}`).tooltip('show');
                setTimeout(() => {
                    $(`#eliminar_permiso_user_${permiso_id}`).blur().tooltip('hide');
                    console.log('cancela eliminacion');
                }, 800);
            } */
        });
    }

    
</script>