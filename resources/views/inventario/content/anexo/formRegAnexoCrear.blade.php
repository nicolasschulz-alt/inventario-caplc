<style>
    #modal_registrar_anexo .form-group select,
    #modal_registrar_anexo .form-group option,
    #modal_registrar_anexo .form-group input,
    #modal_registrar_anexo .form-group textarea,
    #modal_registrar_anexo .form-group label
    {
        /* font-size: 14px; */
        color: #3a3b45;
    }
    #modal_registrar_anexo .form-group label{
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

<form action="{{asset('/inventario/anexo_create')}}" id="form_registrar_anexo" route="{{ route('inventario.anexo_create') }}" novalidate>
    @csrf
    <div class="row">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="form-group mb-1">
                <label for="serie">Serie</label>
                <div class="input-group">
                    
                    <input type="text" id="serie" name="serie" placeholder="" class="form-control is-invalid" value="" required autocomplete="off">

                    <div class="input-group-append">
                        <button id="btn_comprobar_serie_anexo" class="btn btn-info btn-sm" type="button" id="button-addon2"><i class="fas fa-check-circle"></i></button>
                        <button id="btn_cambiar_serie_anexo" class="btn btn-warning btn-sm" type="button" id="button-addon2"><i class="fas fa-pen fa-sm"></i></button>
                    </div>
                    
                    <div class="serie-feedback invalid-feedback">
                        Ingrese número de serie (min. 6 caracteres)
                    </div>
                    <input type="hidden" id="route_comprobar_serie_anexo" value="{{ route('inventario.comprobar_serie_anexo') }}">
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="num_inventario">Número de Inventario</label>
                <input type="text" id="num_inventario" name="num_inventario" placeholder="" class="form-control ipt_slc_value" value="" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="mac">Mac</label>
                <input type="text" id="mac" name="mac" placeholder="" class="form-control ipt_slc_value" value="" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="anexo">Anexo</label>
                <input type="text" id="anexo" name="anexo" placeholder="" class="form-control ipt_slc_value" value="" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="identificador">Identificador</label>
                <input type="text" id="identificador" name="identificador" placeholder="" class="form-control ipt_slc_value" value="" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            
        </div>
       
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12 mt-3">
                    <div class="form-group mb-0">
                        <label for="sala_id">Ubicación existente</label>
                        <select id="sala_id" name="sala_id" class="form-control" name="state">
                            <option value=""></option>
                            @foreach ($sala_list as $item)
                                <option value="{{$item->id}}">{{$item->nombre_edificio}}{{$item->nombre_piso}}.{{$item->numero_sala}} 
                                    @if (isset($item->nombre_sala))
                                        ({{$item->nombre_sala}}) 
                                    @else
                                        (Nombre sala No asignado)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-8 col-md-12 col-sm-12 mt-3">
                    <div class="row" style="display: block;">
                        <div class="col-lg-12 col-md-12 col-sm-12 py-0">
                            <div class="form-group mb-0">
                                <label>Ubicación Manual</label>
                            </div>                            
                            <div class="form-group mb-0">
                                <button type="button" id="ubicacion_manual"  class="btn btn-md btn-info mb-0" style="font-size: 12px;height: 38px;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;">
                                    <i class='fas fa-angle-right' id="icono_ubicacion_manual"></i>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                        <div class="card mb-3 mt-0" style="margin-left: 12px !important;margin-right: 12px !important;border-top-left-radius: 0px;border-top-right-radius: 0px;">
                            <div class="card-body p-0">
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 pt-3" id="col_ubicacion_manual">
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
                </div>
                
            </div>
            
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="marca_id">Marca</label>
                <select class="form-control" id="marca_id" name="marca_id">
                    <option value=""></option>
                    @foreach ($marca_anexo as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="modelo_id">Modelo</label>
                <select class="form-control" id="modelo_id" name="modelo_id">
                    <option value=""></option>
                    @foreach ($modelo_anexo as $item)
                        <option value="{{$item->id}}">{{$item->nombre_modelo}} ({{$item->nombre_marca}})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="categoria_id">Categoría</label>
                <select class="form-control" id="categoria_id" name="categoria_id">
                    <option value=""></option>
                    @foreach ($categoria_anexo as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea class="form-control ipt_slc_value" placeholder="" id="observaciones" name="observaciones" rows="3" autocomplete="off"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label for="propietario_id">Propietario</label>
                <select class="form-control" id="propietario_id" name="propietario_id">
                    <option value="" selected>Seleccionar</option>
                    @foreach ($propietario as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label for="estado_id">Estado</label>
                <select class="form-control" id="estado_id" name="estado_id">
                    <option value="" selected>Seleccionar</option>
                    @foreach ($estado_dispositivo as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 text-center">
            <button type="button" id="btn_guardar_form_anexo" route="{{ route('inventario.anexo_create') }}" class="btn btn-success btn-md">Guardar</button>
        </div>
    </div>
</form>

<script>
    var cerrar_modal_reg_anexo = false;
    $(document).ready(function () {

        //bloquea campos iniciales form registro PC
        bloqueaCamposFormRegistrarAnexo();

        $('#modal_registrar_anexo .close').on('click', function (event) {
           console.log(event);
           event.preventDefault(); // Previene el cierre del modal
           event.stopPropagation(); // Detiene la propagación del evento

           if (!cerrar_modal_reg_anexo){
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
                        cerrar_modal_reg_anexo = true;
                        $('#modal_registrar_anexo').modal('hide');
                        //$('#body_modal_registrar_anexo').html('');
                        console.log('confirma salir');
                        
                    } else {
                        cerrar_modal_reg_anexo = false;
                    }
                });
           }

        });
        
        $('#modal_registrar_anexo').on('hidden.bs.modal', function () {
            console.log('El modal crear ha sido cerrado.');
            $('#body_modal_registrar_anexo').html('');
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
            dropdownParent: $("#form_registrar_anexo")
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
                } else {
                    let edificio_piso = document.getElementById('edificio_piso').value;
                    let nombre_sala = obtenerNombreSala(val_this,edificio_piso);
                    $('#nombre_sala').prop('disabled',true).removeClass('is-invalid').addClass('is-valid');
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
        
        
        $('#btn_cambiar_serie_anexo').on('click', function (event) {
            event.preventDefault();
            $('#serie').prop('disabled',false).val('').focus();
            $('#serie').removeClass('is-valid').addClass('is-invalid');
            $('#serie').parent().find('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
            bloqueaCamposFormRegistrarAnexo();
            $('#btn_comprobar_serie_anexo').prop('disabled',false);
            setTimeout(() => {
                $('#serie').focus();
            }, 150);
        });

        $('#btn_comprobar_serie_anexo').on('click',async function (event) {
           event.preventDefault();

                let val_serie = $('#serie').val();
                val_serie = val_serie.trim();

                if (val_serie && val_serie.length > 0 && val_serie.length < 6 ){

                    console.log('Ingrese número de serie (min. 6 caracteres)');

                    $('#serie').removeClass('is-valid').addClass('is-invalid');
                    $('#serie').parent().find('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
                    
                    bloqueaCamposFormRegistrarAnexo();

                    setTimeout(() => {
                        $('#serie').focus();
                    }, 150);

                } else if (val_serie && val_serie.length > 5){

                    console.log('comprobar serie');
                    
                    await comprobar_serie_anexo(val_serie);

                } else {

                    console.log('ingrese numero de serie');
                    
                    $('#serie').removeClass('is-valid').addClass('is-invalid').val('');
                    $('#serie').parent().find('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
                    
                    bloqueaCamposFormRegistrarAnexo();
                    Swal.fire({
                        icon: "info",
                        title: "Ingrese número de serie",
                        text: "El número de serie es obligatorio"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            setTimeout(() => {
                                $('#serie').focus();
                            }, 50);
                        }
                    });
                    
                }


        });


        //select2

        //buscar ip
       /*  $('#ip_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            //minimumResultsForSearch : Infinity, // oculta el cuadro de busqueda (no permite escribir)
            //minimumInputLength: 8, 
            dropdownParent: $("#form_registrar_anexo")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            if ($(this).val()){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');
            } else {
                $(this).closest('td').next('td').find('select').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true).val('');
            }
        }); */

       
        $('#anexo').on('keyup', function (event) {

            let val_serie = $(this).val();
            val_serie = val_serie.trim();
            const solo_numeros = /^[a-zA-Z0-9]+$/;
            if (val_serie){

                if (!solo_numeros.test(val_serie)){

                    $(this).removeClass('is-valid').addClass('is-invalid').val('');
                    $(this).parent().find('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
                        
                    Swal.fire({
                        icon: "error",
                        title: "Anexo incorrecto",
                        text: "-El anexo debe ser numérico"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            setTimeout(() => {
                                $('#anexo').focus();
                            }, 50);
                        }
                    });
                    return false;

                }

            }
            
        }).on('blur', function (event) {
            event.preventDefault();
            let val_serie = $(this).val();
            val_serie = val_serie.trim();
            console.log(val_serie.length);
            const solo_numeros = /^[a-zA-Z0-9]+$/;
            if (val_serie){

                if (!solo_numeros.test(val_serie)){

                    $(this).removeClass('is-valid').addClass('is-invalid').val('');
                    $(this).parent().find('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
                        
                    Swal.fire({
                        icon: "error",
                        title: "Anexo incorrecto",
                        text: "-El anexo debe ser numérico"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            setTimeout(() => {
                                $('#anexo').focus();
                            }, 50);
                        }
                    });
                    return false;

                }

                if (val_serie.length != 6){

                    $(this).removeClass('is-valid').addClass('is-invalid').val('');
                    $(this).parent().find('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
                        
                    Swal.fire({
                        icon: "error",
                        title: "Anexo incorrecto",
                        text: "-El anexo debe ser de 6 caracteres"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            setTimeout(() => {
                                $('#anexo').focus();
                            }, 50);
                        }
                    });

                }
            }
        });

        //buscar libre
        $('#sala_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_anexo")
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
            dropdownParent: $("#form_registrar_anexo")
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
        $('#modelo_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_anexo")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            if ($(this).val()){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');
            } else {
                $(this).closest('td').next('td').find('select').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true).val('');
            }
        });
        $('#categoria_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_anexo")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            if ($(this).val()){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');
            } else {
                $(this).closest('td').next('td').find('select').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true).val('');
            }
        });
       
        $('#marca_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_anexo")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            if ($(this).val()){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');
            } else {
                $(this).closest('td').next('td').find('select').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true).val('');
            }
        });
       
        $('#propietario_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_anexo")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            if ($(this).val()){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');
            } else {
                $(this).closest('td').next('td').find('select').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true).val('');
            }
        });
        $('#estado_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_anexo")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            if ($(this).val()){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');
            } else {
                $(this).closest('td').next('td').find('select').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true).val('');
            }
        });
        

        //minimo 2 caracteres para buscar
        $('.slc2-min2-form-pc').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            minimumInputLength: 2, 
            //dropdownParent: $("#form_registrar_anexo")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        });



       

       
        
      

        

        $('#btn_guardar_form_anexo').on('click', function (event) {
            event.preventDefault();

            return_ = true;
            if (!document.getElementById('sala_id').value){

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

            }

            /* if ($('input[id^=conexion_id_]:checked').val() == 2 && !document.getElementById('ip_id').value){
                // 2 Ethernet
                return_ = false;
                $('#ip_id').removeClass('is-valid is-invalid').addClass('is-invalid').focus();
                Swal.fire({
                    title: "Complete los campos requeridos!",
                    text: "",
                    icon: "warning"
                });
            } */

            if (!return_){
                return false;
            }

            const objeto_data = {
                //antivirus_id: document.getElementById('antivirus_id').value,
                //candado_id: document.getElementById('candado_id').value,
                //corriente_id: document.getElementById('corriente_id').value,
                propietario_id: document.getElementById('propietario_id').value,
                estado_id: document.getElementById('estado_id').value,
                //ip_id: document.getElementById('ip_id').value,
                marca_id: document.getElementById('marca_id').value,
                modelo_id: document.getElementById('modelo_id').value,
                num_inventario: document.getElementById('num_inventario').value,
                observaciones: document.getElementById('observaciones').value,
                //oc_id: document.getElementById('oc_id').value,
                //office_id: document.getElementById('office_id').value,

                sala_id: document.getElementById('sala_id').value,

                edificio_piso: document.getElementById('edificio_piso').value,
                numero_sala: document.getElementById('numero_sala').value,
                nombre_sala: document.getElementById('nombre_sala').value,
                
                serie: document.getElementById('serie').value,
                mac: document.getElementById('mac').value,
                anexo: document.getElementById('anexo').value,
                identificador: document.getElementById('identificador').value,
                categoria_id: document.getElementById('categoria_id').value,
                //tipo_id: document.getElementById('tipo_id').value,
                //conexion_id: $('input[id^=conexion_id_]:checked').val(),
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

                            $('#modal_registrar_anexo').modal('hide');

                            loader('stop');
                            Swal.fire({
                                icon: "success",
                                title: "Guardado con éxito",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            await cargarVistaTablaListadoAnexo();
                            loader('continue');

                        }
                    } catch (error) {
                        console.error(error);
                        Swal.fire({
                            icon: "error",
                            title: "Error al Guardar",
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

    

        





    function bloqueaCamposFormRegistrarAnexo(){

        $('#form_registrar_anexo input').prop('disabled',true);
        $('#form_registrar_anexo select').prop('disabled',true);
        $('#form_registrar_anexo textarea').prop('disabled',true);
        $('#form_registrar_anexo button').prop('disabled',true);
        $('#form_registrar_anexo #serie').prop('disabled',false);
        $('#btn_comprobar_serie_anexo').prop('disabled',false);
        $('#btn_cambiar_serie_anexo').prop('disabled',false);
        
    }
    /* async */ function ActivaCamposFormRegistrarPC(){

        //await new Promise(resolve => setTimeout(resolve, 500));
        //await new Promise(resolve => (resolve));

        $('#form_registrar_anexo input').prop('disabled',false);
        $('#form_registrar_anexo select').prop('disabled',false);
        $('#form_registrar_anexo textarea').prop('disabled',false);
        $('#form_registrar_anexo button').prop('disabled',false);
        $('#numero_sala').prop('disabled',true);
        $('#nombre_sala').prop('disabled',true);
        $('#serie').prop('disabled',true);
        $('#ip_id').prop('disabled',true);

    }
    /* async */ function bloqueaCamposAppsFormRegistrarPc(){

        //await new Promise(resolve => (resolve));

        $('#form_registrar_anexo #slc_apl_lic_so').prop('disabled',true);
        $('#form_registrar_anexo #slc_apl_lic_office').prop('disabled',true);
        $('#form_registrar_anexo #slc_apl_lic_antivirus').prop('disabled',true);
        $('#form_registrar_anexo select[id^=slc_apl_lic_app_]').prop('disabled',true);
        $('#form_registrar_anexo input[id^=licencia_app_]').prop('disabled',true);
        $('#licencia_so').prop('disabled',true);
        $('#licencia_office').prop('disabled',true);
        $('#licencia_antivirus').prop('disabled',true);

    }

    

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

    async function comprobar_serie_anexo(serie){

        console.log(serie);
        loader('show');
        try {
            
            const route = document.getElementById('route_comprobar_serie_anexo').value;
            const url = route + `/${serie}`;
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
                    
                if (data.serie){

                    console.log('serie existe',data.serie);
                    $('#serie').removeClass('is-valid').addClass('is-invalid').val('');
                    $('#serie').parent().find('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('El número de serie ingresado ya existe');
                    bloqueaCamposFormRegistrarAnexo();
                    Swal.fire({
                        icon: "error",
                        title: "El número de serie \n ingresado ya existe",
                        text: ""
                    }).then((result) => {
                        if (result.isConfirmed) {
                            setTimeout(() => {
                                $('#serie').focus();
                            }, 50);
                        }
                    });
                    
                } else {

                    console.log('serie no existe',data.serie);
                    $('#serie').removeClass('is-invalid').addClass('is-valid');
                    $('#serie').parent().find('.serie-feedback').removeClass('invalid-feedback').addClass('valid-feedback').html('El número de serie es válido.');
                    /* await */ ActivaCamposFormRegistrarPC();
                    /* await */ bloqueaCamposAppsFormRegistrarPc();
                    $('#btn_comprobar_serie_anexo').prop('disabled',true);
                    
                }

                loader('hide');
                
            } else {
                loader('hide');
            }
            
        } catch (error) {
            loader('hide');
            console.error('Error:', error);
        }

    }

    
</script>