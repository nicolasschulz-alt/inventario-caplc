<style>
    #modal_registrar_ubicacion .form-group select,
    #modal_registrar_ubicacion .form-group option,
    #modal_registrar_ubicacion .form-group input,
    #modal_registrar_ubicacion .form-group textarea,
    #modal_registrar_ubicacion .form-group label
    {
        /* font-size: 14px; */
        color: #3a3b45;
    }
    #modal_registrar_ubicacion .form-group label{
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
    .col_overflow_auto{
        overflow: auto;
    }
        .no-margen-bottom{
        margin-bottom: 0px !important;
        }
    .ancho-max-content{
        width: max-content;
    }
    .ancho-wbk-fill-av{
        width: -webkit-fill-available;
    }
    .p-tabla-head{
        padding: 3px 12px !important;
        font-weight: 500;
        color: #fff;
        background-color: #4e73df;
        border: 1px solid #4e73df !important;
    }
    /* campo active */
   /*  .campo_active {
        background-color: #1cc88a1f !important;
        font-weight: 700;
        color: #3a3b45 !important;
        border: 1px solid #1cc88a !important;
    } */

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

    
    /*quita check verde de select (lo agrega bootstrap los que tienen la clase is-valid) */
    select.form-control.is-valid,
    select.form-control.is-invalid
    {
        padding: .375rem .75rem !important;
        background-image: none !important;
    }
    

    /* ancho select2 */
    .select2-container{
        /* width: 100% !important; */
    }
    .select2-selection__clear{
        margin-right: 30px !important;
        color: black !important;
    }
    .select2-container .select2-selection--multiple .select2-selection__rendered{
        display: block !important;
    }
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove{
        border: 1px solid #bdc6d0 !important;
    }
    .select2-container .select2-selection--multiple .select2-selection__rendered {
        display: flex !important;
        flex-wrap: wrap !important;
    }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        color: #3a3b45 !important;
    }
    /* .select2-container--bootstrap4 .select2-selection{
        border: 2px solid #ced4da;
    } */

    /* input.form-control,
    textarea.form-control
    {
        border: 2px solid #d1d3e2;
    } */
    
    .campo-selected{
        border: 2px solid #1cc88a !important;
        font-weight: 700 !important;
    }
    #ubicacion_manual{
        width: 60px;
    }
</style>


{{-- {{$ip_list}} --}}

<form action="{{asset('/inventario/mantenedor/ubicacion_create')}}" id="form_registrar_ubicacion" route="{{ route('inventario.mantenedor.ubicacion_create') }}" novalidate>
    @csrf
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="row" style="display: block;">
                <div class="col-md-12 col-sm-12 pt-3" id="col_ubicacion_manual">
                    <div class="row">
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="edificio_piso">Edificio/Piso</label>
                                <select id="edificio_piso" name="edificio_piso" class="form-control" name="state">
                                    <option value=""></option>
                                    @foreach ($edificio_piso as $item)
                                        <option value="{{$item->id}}">{{$item->nombre_edificio}}{{$item->nombre_piso}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="numero_sala">Número Sala</label>
                                {{-- <input type="text" class="form-control ipt_slc_value" placeholder="" name="numero_sala" id="numero_sala" value="" autocomplete="off" disabled> --}}
                                <select id="numero_sala" name="numero_sala" class="form-control" name="state" disabled>
                                    <option value=""></option>
                                </select>
                                <input type="hidden" id="route_obtener_nombre_sala" value="{{ route('inventario.obtener_nombre_sala') }}">
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="nombre_sala">Nombre Sala</label>
                                <input type="text" class="form-control ipt_slc_value" placeholder="" name="nombre_sala" id="nombre_sala" value="" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <button type="button" id="btn_guardar_form_ubicacion" route="{{ route('inventario.mantenedor.ubicacion_create') }}" class="btn btn-success btn-md">Guardar</button>
        </div>
    </div>
</form>

<script>
    var cerrar_modal_reg_ubicacion = false;
    $(document).ready(function () {

        $('#modal_registrar_ubicacion .close').on('click', function (event) {
           console.log(event);
           event.preventDefault(); // Previene el cierre del modal
           event.stopPropagation(); // Detiene la propagación del evento

           if (!cerrar_modal_reg_ubicacion){
                Swal.fire({
                    title: "¿Seguro que desea salir?",
                    text: "Se perderán los datos ingresados",
                    icon: "warning",
                    showCancelButton: true,
                    //confirmButtonColor: "#3085d6",
                    //cancelButtonColor: "#d33",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-secondary"
                    },
                    confirmButtonText: "Sí, salir",
                    cancelButtonText: "No",
                }).then((result) => {
                    if (result.isConfirmed) {
                        cerrar_modal_reg_ubicacion = true;
                        $('#modal_registrar_ubicacion').modal('hide');
                        //$('#body_modal_registrar_ubicacion').html('');
                        console.log('confirma salir');
                        
                    } else {
                        cerrar_modal_reg_ubicacion = false;
                    }
                });
           }

        });
        
        $('#modal_registrar_ubicacion').on('hidden.bs.modal', function () {
            console.log('El modal crear ha sido cerrado.');
            $('#body_modal_registrar_ubicacion').html('');
        });

        $('#ubicacion_manual').on('click', function () {
            $('#col_ubicacion_manual').toggle();
            if ($('#col_ubicacion_manual').css('display') == 'none'){
                $('#icono_ubicacion_manual').removeClass('fa-angle-down').addClass('fa-angle-right');
            } else {
                $('#icono_ubicacion_manual').removeClass('fa-angle-right').addClass('fa-angle-down');
                
            }
        });

        $('.ipt_slc_value').on('input', function (event) {
            //console.log(event);
            event.preventDefault();
            let val_this = $(this).val();
            val_this = val_this.trim();
            if (val_this){
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid is-invalid');
            }
        });

        
        $('#numero_sala').select2({
            //placeholder: '',
            //allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            tags: true, // permite crear tags
            dropdownParent: $("#form_registrar_ubicacion")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change', function (e) {
            //console.log(e,e.target.value);
            let val_this = $(this).val();
            const solo_numeros = /^[a-zA-Z0-9]+$/;
            if (val_this){

                if (solo_numeros.test(val_this)){
                    $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $('#numero_sala').val(null).trigger("change").prop('disabled',false);
                    $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid').addClass('is-invalid');
                }

                if ($("#numero_sala option:selected").attr('data-select2-tag')){
                    console.log('es tag');
                    $('#nombre_sala').prop('disabled',false).val('').removeClass('is-valid').addClass('is-invalid');
                    setTimeout(() => {
                        $('#nombre_sala').focus();
                    }, 150);
                    $('#btn_guardar_form_ubicacion').prop('disabled',false);
                } else {
                    let edificio_piso = document.getElementById('edificio_piso').value;
                    let nombre_sala = obtenerNombreSala(val_this,edificio_piso);
                    $('#nombre_sala').prop('disabled',true).removeClass('is-invalid').addClass('is-valid');
                    $('#btn_guardar_form_ubicacion').prop('disabled',true);
                }

            } else {
                $('#nombre_sala').prop('disabled',true).val('').removeClass('is-invalid is-valid');
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid').addClass('is-invalid');
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
        
       




        //select2

        //buscar libre
        $('#sala_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_ubicacion")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            if ($(this).val()){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');

                //deshabilita campos ubicacion manual
                $('#edificio_piso').val(null).trigger("change").removeClass('is-valid is-invalid');
                $('#numero_sala').val('').prop('disabled',true).removeClass('is-valid is-invalid');
                $('#nombre_sala').val('').prop('disabled',true).removeClass('is-valid is-invalid');

            } else {
                $(this).closest('td').next('td').find('select').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true).val('');
            }
        });
        $('#edificio_piso').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_ubicacion")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',async function(e){
            if ($(this).val()){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');

                $('#sala_id').val(null).trigger("change").removeClass('is-valid is-invalid');
                $('#numero_sala').val(null).trigger("change").prop('disabled',false);
                $(`[aria-controls="select2-numero_sala-container"]`).removeClass('is-valid').addClass('is-invalid').focus();
                $(`[aria-controls="select2-numero_sala-container"] .select2-selection__placeholder`).html('Selec / crear');
                
                //$('#nombre_sala').prop('disabled',false);

                obtener_salas_por_edificio_piso($(this).val());

            } else {
                $(this).closest('td').next('td').find('select').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true).val('');

                $('#numero_sala').val(null).trigger("change").prop('disabled',true).removeClass('is-valid is-invalid');
                $(`[aria-controls="select2-numero_sala-container"]`).removeClass('is-valid is-invalid');
                $(`[aria-controls="select2-numero_sala-container"] .select2-selection__placeholder`).html('');
                $('#nombre_sala').val('').prop('disabled',true).removeClass('is-valid is-invalid');

                $('#numero_sala').empty().append('<option value=""></option>');

            }
        });
        


        //minimo 2 caracteres para buscar
        $('.slc2-min2-form-pc').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            minimumInputLength: 2, 
            //dropdownParent: $("#form_registrar_ubicacion")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        });



        $('#btn_guardar_form_ubicacion').on('click', function (event) {
            event.preventDefault();

            return_ = true;
            //if (!document.getElementById('sala_id').value){
                if (!document.getElementById('edificio_piso').value){

                    return_ = false;
                    $('#edificio_piso').removeClass('is-valid is-invalid').addClass('is-invalid').focus();
                    Swal.fire({
                        title: "Complete los campos requeridos!",
                        text: "",
                        icon: "warning"
                    });

                }

                if (document.getElementById('edificio_piso').value){

                    if (!document.getElementById('numero_sala').value){

                        return_ = false;
                        $('#numero_sala').removeClass('is-valid is-invalid').addClass('is-invalid').focus();
                        Swal.fire({
                            title: "Complete los campos requeridos!",
                            text: "",
                            icon: "warning"
                        });

                    }

                    if (!document.getElementById('nombre_sala').value){

                        return_ = false;
                        $('#nombre_sala').removeClass('is-valid is-invalid').addClass('is-invalid').focus();
                        Swal.fire({
                            title: "Complete los campos requeridos!",
                            text: "",
                            icon: "warning"
                        });

                    }                

                }

            //}

            if (!return_){
                return false;
            }

            const objeto_data = {

                edificio_piso: document.getElementById('edificio_piso').value,
                numero_sala: document.getElementById('numero_sala').value,
                nombre_sala: document.getElementById('nombre_sala').value,

                _token:  document.querySelector('meta[name="csrf-token"]').content
            };

            console.log(objeto_data);

            const route = this.getAttribute('route');

            //return false;

            Swal.fire({
                title: "¿Desea Guardar?",
                text: "",
                icon: "question",
                showCancelButton: true,
                //confirmButtonColor: "#3085d6",
                //cancelButtonColor: "#d33",
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-secondary"
                },
                confirmButtonText: "Sí, Guardar",
                cancelButtonText: "Cancelar",
            }).then(async(result) => {      
                if (result.isConfirmed && route) {

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

                            console.log('Datos insertados correctamente:', data);

                            await cargarVistaTablaListadoUbicacion();

                            loader('hide');

                            Swal.fire({
                                title: "Guardado con éxito",
                                text: "",
                                icon: "success"
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    $('#modal_registrar_ubicacion').modal('hide');
                                }
                            });

                        } else if (data.status == 200){

                            Swal.fire({
                                title: "Esta ubicación ya existe",
                                text: "Debe ingresar una nueva ubicación",
                                icon: "info"
                            });

                        }
                    } catch (error) {
                        console.error(error);
                        /* Swal.fire({
                            icon: "error",
                            title: "Error al Guardar",
                            text: ""
                        }); */
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

    

    async function obtener_salas_por_edificio_piso(edificio_piso){

        console.log(edificio_piso);
        loader('show');
        try {
            const route = document.getElementById('route_obtener_salas_por_edificio_piso').value;
            const url = route + `/${edificio_piso}`;
            const response = await fetch(url);
            if (response.redirected){
                location.replace("/login");
                throw new Error('Redireccionado');
            }
            if (!response.ok) {
                throw new Error('Error al obtener datos');
            }
            const data = await response.json();
            console.log(data);
            if (data.status == 200){
                if (data.data){
                    $('#numero_sala').html('<option value="" hidden selected>Selec / crear</option>');
                    data.data.forEach(element => {
                        $('#numero_sala').append(`<option value="${element.numero_sala}">${element.numero_sala}</option>`);
                    });
                    loader('hide');
                } else {
                    loader('hide');
                }
            } else {
                loader('hide');
            }
        } catch (error) {
            loader('hide');
            console.error('Error:', error);
        }

    }

    async function obtenerNombreSala(numero_sala,edificio_piso){

        console.log(numero_sala,edificio_piso);
        loader('show');
        try {
            const route = document.getElementById('route_obtener_nombre_sala').value;
            const url = route + `/${numero_sala}/${edificio_piso}`;
            const response = await fetch(url);
            if (response.redirected){
                location.replace("/login");
                throw new Error('Redireccionado');
            }
            if (!response.ok) {
                throw new Error('Error al obtener datos');
            }
            const data = await response.json();
            console.log(data);
            if (data.status == 200){
                if (data.data){
                    $('#nombre_sala').val(data.data.nombre_sala);
                    loader('hide');
                } else {
                    loader('hide');
                }
            } else {
                loader('hide');
            }
        } catch (error) {
            loader('hide');
            console.error('Error:', error);
        }

    }

    
</script>