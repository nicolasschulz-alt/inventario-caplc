<div class="card shadow mb-4">
    <div class="card-header py-3 bg-success">
        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-user fa-sm"></i> Usuario seleccionado</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 col-sm-12" style="overflow: auto;">
                {{-- <label>Usuario seleccionado</label> --}}
                <table class="table mb-0 table-striped table-condensed">
                    <tbody>
                        <tr>
                            <th width="10%">ID:</th>
                            <td>{{$data->id}}</td>
                        </tr>
                        <tr>
                            <th width="10%">Nombre:</th>
                            <td>{{$data->name ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th width="10%">Email:</th>
                            <td>{{$data->email ?? '--'}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 mt-4 text-right">
                {{-- <button class="btn btn-sm btn-primary" onclick="adm_permiso_usuario({{$data->id}})">Administrar permisos</button> --}}
                <button class="btn btn-danger ml-2" onclick="user_delete({{$data->id}})"><i class="fas fa-trash-alt fa-sm"></i> Eliminar usuario</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 mt-4">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <a style="font-weight: 700;" class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Permisos sistemas</a>
                      {{-- <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>  --}}                     
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 my-4 text-right">
                                <button class="btn btn-success" id="crear_permiso_usuario" route="{{ route('usuario.include_formulario_permiso_user_create') }}" user_id="{{$data->id}}"><i class="fas fa-key fa-sm"></i> Permiso nuevo</button>
                            </div>
                            <div class="col-md-12 col-sm-12 mt-2" >
                                <div id="tablaPermisosUsuario" route="{{route('usuario.permiso_user_list')}}" user_id="{{$data->id}}"></div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div> --}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="modal fade" id="modal_registrar_usuario"  {{-- tabindex="-1" --}} aria-labelledby="modalRegistrarPermisoUsuarioLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header px-4 text-center">
                                <h5 class="modal-title h4" id="modalRegistrarPermisoUsuarioLabel">Asignar Permiso Sistema</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body p-4" id="body_modal_registrar_usuario">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="modal fade" id="modal_editar_permiso_user"  {{-- tabindex="-1" --}} aria-labelledby="modalEditarPermisoUsuarioLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header px-4 text-center">
                                <h5 class="modal-title h4" id="modalEditarPermisoUsuarioLabel">Editar Permiso Sistema</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body p-4" id="body_modal_editar_permiso_user">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        cargarTablaPermisoUser();

        $('#crear_permiso_usuario').on('click', function (event) {
            event.preventDefault();

            //loader('show');
            $(this).prop('disabled', true);

            //const route = this.getAttribute('route');
            const user_id = this.getAttribute('user_id');
            const route = this.getAttribute('route') + '/' + user_id;
            
            fetch(route)
            .then(response => {
                console.log(response);
                if (response.redirected){
                    location.replace("/login");
                    throw new Error('Redireccionado');
                }
                if (!response.ok) {
                    print_swal_status(response.status);
                    throw new Error('Error al hacer peticion');
                }
                return response.json();
            })
            .then(data => {
                
                $('#body_modal_registrar_usuario').html(data);

                //setTimeout(() => {

                    //loader('hide');

                    $('#modal_registrar_usuario').modal({
                        keyboard: false,
                        backdrop: 'static'
                    }).modal('show');

                //}, 200);
            })
            .catch(error => {
                //loader('hide');
                console.error('Error:', error);
            })
            .finally(() => {
                //console.log('finaliza');
                $(this).prop('disabled', false);
            });
        });

    });

    async function cargarTablaPermisoUser(){

        loader('show');

        const div = document.getElementById('tablaPermisosUsuario');
        const user_id = div.getAttribute('user_id');
        const route = div.getAttribute('route') + '/' + user_id;

        try {
            const response = await fetch(route);

            if (response.redirected){
                location.replace("/login");
                throw new Error('Redireccionado');
            }
            if (!response.ok){
                throw new Error('Error response listar tabla');
            }
            const data = await response.json();

            console.log('carga vista tabla');

            $('#tablaPermisosUsuario').html(data);

            setTimeout(() => {
                loader('hide');
            }, 1000);
            
        } catch (error) {
            loader('hide');
            console.error(error);
        }

    }

    async function user_delete(user_id){

        const route = $('#route_user_delete').val()+`/${user_id}`;

        console.log(route);

        console.log('eliminar user:',user_id);


        Swal.fire({
            title: "¿Seguro de Eliminar \n el usuario seleccionado?",
                /* text: "",
                icon: "error",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, Eliminar",
                cancelButtonText: "No", */
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
                loader('show');
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

                        loader('hide');
                        
                        Swal.fire({
                            title: "Eliminado con éxito",
                            text: "",
                            icon: "success"
                        }).then(async(result) => {
                            if (result.isConfirmed) {                                
                                $(`#eliminar_permiso_user_${user_id}`).tooltip('hide'); //cierro el tooltip antes de actualizar la tabla (ya que o si no el boton no existirá)
                                //await cargarVistaTablaListadoPc();
                                const route_gestion_usuarios = $('#route_gestion_usuarios').val();
                                window.location.href = route_gestion_usuarios;
                            }
                        });

                    } else {
                        loader('hide');
                    }
                } catch (error) {
                    loader('hide');
                    console.error(error);
                    Swal.fire({
                        icon: "error",
                        title: "Error al Eliminar",
                        text: ""
                    });
                }
            } else {
                $(`#eliminar_permiso_user_${user_id}`).tooltip('show');
                setTimeout(() => {
                    $(`#eliminar_permiso_user_${user_id}`).blur().tooltip('hide');
                    console.log('cancela eliminacion');
                }, 800);
                
                
            }
        });
    }

    
</script>