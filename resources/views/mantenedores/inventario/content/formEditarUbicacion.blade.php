<style>
    #modal_editar_ubicacion .form-group select,
    #modal_editar_ubicacion .form-group option,
    #modal_editar_ubicacion .form-group input,
    #modal_editar_ubicacion .form-group textarea,
    #modal_editar_ubicacion .form-group label
    {
        /* font-size: 14px; */
        color: #3a3b45;
    }
    #modal_editar_ubicacion .form-group label{
        font-weight: 700;
        color: #4e73df;
        font-size: 14px;
    }
    .lbl-chck{
        font-size: 16px !important;
        font-weight: 600 !important;
        user-select: none;
        text-decoration: none !important;
        color: #3a3b45 !important;
    }
    .lbl-chck:hover{
        text-decoration: underline;
        border-bottom: 1px solid #3a3b45;
        /* cursor: pointer; */
    }
    .lbl-chck-active{
        /* font-weight: 700 !important; */
        border-bottom: 1px solid #1cc88a !important;
        
    }

    .is-valid{
        /* border-color: #1cc88a !important; */
        border: 2px solid #1cc88a !important;
        /* font-weight: 700 !important; */
    }
    .is-valid:focus{
        border-color: #1cc88a !important;
        box-shadow: 0 0 0 .2rem rgba(28, 200, 138, .25) !important;
    }
    .is-invalid{
        border: 1px solid #e74a3b !important;
        /* font-weight: 700 !important; */
    }
    .is-invalid:focus{
        border-color: #e74a3b !important;
        box-shadow: 0 0 0 .2rem rgb(231 74 59 / 25%) !important;
    }
</style>


<form action="{{asset('/inventario/mantenedor/ubicacion_editar')}}" id="form_editar_ubicacion" route="{{ route('inventario.mantenedor.ubicacion_update') }}" novalidate>
    @csrf
    <div class="row">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="edificio_piso">Edificio/Piso</label>
                <input type="text" class="form-control ipt_slc_value" placeholder="" value="{{$data->nombre_edificio}}{{$data->nombre_piso}}" disabled>                
            </div>
        </div>
        <div class="col-lg-3 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="numero_sala">Número Sala</label>
                <input type="text" class="form-control ipt_slc_value" placeholder="" value="{{$data->numero_sala}}" disabled>                
            </div>
        </div>
        <div class="col-lg-5 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="nombre_sala">Nombre Sala</label>
                <input type="text" class="form-control ipt_slc_value" placeholder="" name="nombre_sala" id="nombre_sala" value="{{$data->nombre_sala}}" autocomplete="off" >
            </div>
        </div>
    </div>
        
    <div class="row">
        <div class="col-lg-12 col-md-12 text-center">
            <button type="button" id="btn_editar_form_ubicacion" route="{{ route('inventario.mantenedor.ubicacion_update') }}" class="btn btn-warning btn-md">Editar</button>
            <input type="hidden" id="ubicacion_id_editar" name="ubicacion_id_editar" value="{{$sala_id}}">
        </div>
    </div>
</form>

<script>
    var cerrar_modal_edit_ubicacion = false;
    $(document).ready(function () {

        $('#modal_editar_ubicacion .close').on('click', function (event) {
           console.log(event);
           event.preventDefault(); // Previene el cierre del modal
           event.stopPropagation(); // Detiene la propagación del evento

           if (!cerrar_modal_edit_ubicacion){
                Swal.fire({
                    title: "¿Seguro que desea salir?",
                    text: "Se perderán los cambios efectuados",
                    icon: "warning",
                    showCancelButton: true,
                    //confirmButtonColor: "#3085d6",
                    //cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, salir",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-secondary"
                    },
                    cancelButtonText: "No",
                }).then((result) => {
                    if (result.isConfirmed) {
                        cerrar_modal_edit_ubicacion = true;
                        $('#modal_editar_ubicacion').modal('hide');
                        console.log('confirma salir');
                        
                    } else {
                        cerrar_modal_edit_ubicacion = false;
                    }
                });
           }

        });

        $('#modal_editar_ubicacion').on('hidden.bs.modal', function (event) {
            console.log('El modal editar ha sido cerrado.');
            $('#body_modal_editar_ubicacion').html('');
        });

        $('.ipt_slc_value').on('input', function (event) {
            event.preventDefault();
            let val_this = $(this).val();
            val_this = val_this.trim();
            if (val_this){
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid is-invalid');
            }
        });

        $('#nombre_sala').on('input', function () {
            let numero_sala = $('#numero_sala').val();
            let val_this = $(this).val();
            val_this = val_this.trim();
            if (numero_sala){
                if (!val_this){
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            }
        });

        $('#btn_editar_form_ubicacion').on('click', function (event) {
            event.preventDefault();

            return_ = true;
            if (!document.getElementById('nombre_sala').value){

                return_ = false;
                $('#nombre_sala').removeClass('is-valid is-invalid').addClass('is-invalid').focus();
                Swal.fire({
                    title: "Complete los campos requeridos!",
                    text: "",
                    icon: "warning"
                });

            }

            if (!return_){
                return false;
            }
        
            const objeto_data = {
                sala_id : document.getElementById('ubicacion_id_editar').value,
                nombre_sala: document.getElementById('nombre_sala').value,
                _token:  document.querySelector('meta[name="csrf-token"]').content
            };

            console.log(objeto_data);

            const route = this.getAttribute('route');

            Swal.fire({
                title: "¿Desea editar?",
                text: "",
                icon: "question",
                showCancelButton: true,
                //confirmButtonColor: "#3085d6",
                //cancelButtonColor: "#d33",
                customClass: {
                    confirmButton: "btn btn-warning",
                    cancelButton: "btn btn-secondary"
                },
                confirmButtonText: "Sí, editar",
                cancelButtonText: "Cancelar",
            }).then(async(result) => {      
                if (result.isConfirmed && route) {
                    loader('show');
                    try {
                        const response = await fetch(route, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(objeto_data)
                        });

                        if (response.redirected){
                            location.replace("/login");
                            throw new Error('Redireccionado');
                        }
                        if (!response.ok){
                            throw new Error('Error al obtener datos');
                        }
                        const data = await response.json();
                        console.log(data);
                        if (data.status == 201){

                            console.log('Datos editados correctamente:', data);

                            await cargarVistaTablaListadoUbicacion();

                            loader('hide');

                            Swal.fire({
                                title: "Guardado con éxito",
                                text: "",
                                icon: "success"
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    $('#modal_editar_ubicacion').modal('hide');
                                }
                            });

                        }
                    } catch (error) {
                        loader('hide');
                        console.error(error);
                        Swal.fire({
                            icon: "error",
                            title: "Error al editar",
                            text: ""
                        });
                    }
                    
                } else {

                    Swal.fire({
                        icon: "info",
                        title: "Acción Cancelada",
                        text: ""
                    });
                    
                }
            });

        });


    });

    
</script>