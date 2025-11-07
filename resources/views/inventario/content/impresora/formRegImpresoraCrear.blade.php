<style>
    #modal_registrar_impresora .form-group select,
    #modal_registrar_impresora .form-group option,
    #modal_registrar_impresora .form-group input,
    #modal_registrar_impresora .form-group textarea,
    #modal_registrar_impresora .form-group label
    {
        /* font-size: 14px; */
        color: #3a3b45;
    }
    #modal_registrar_impresora .form-group label{
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

<form action="{{asset('/inventario/impresora_create')}}" id="form_registrar_impresora" route="{{ route('inventario.impresora_create') }}" novalidate>
    @csrf
    <div class="row">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="form-group mb-1">
                <label for="serie">Serie</label>
                <div class="input-group">
                    
                    <input type="text" id="serie" name="serie" placeholder="" class="form-control is-invalid" value="" required autocomplete="off">

                    <div class="input-group-append">
                        <button id="btn_comprobar_serie_impresora" class="btn btn-info btn-sm" type="button" id="button-addon2"><i class="fas fa-check-circle"></i></button>
                        <button id="btn_cambiar_serie_impresora" class="btn btn-warning btn-sm" type="button" id="button-addon2"><i class="fas fa-pen fa-sm"></i></button>
                    </div>
                    
                    <div class="serie-feedback invalid-feedback">
                        Ingrese número de serie (min. 6 caracteres)
                    </div>
                    <input type="hidden" id="route_comprobar_serie_impresora" value="{{ route('inventario.comprobar_serie_impresora') }}">
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
            
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mt-3">

            <div class="row">

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Conexión</label>
                        <div>
                            @foreach ($conexion_impresora as $key => $item)
                                <input class="{{ $key > 0 ? 'ml-3' : '' }}" type="radio" id="conexion_id_{{$item->id}}" value="{{$item->id}}">
                                <label class="pl-1" for="conexion_id_{{$item->id}}" style="color: #3a3b45 !important;">{{$item->nombre}}</label> 
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12" id="contenedor_ip">
                    <div class="form-group">
                        <label for="ip_id">IP</label>
                        
                        <select id="ip_id" name="ip_id" class="form-control" name="state">
                            <option value=""></option>
                        @foreach ($ip_list as $item)
                            <option value="{{$item->id}}">{{$item->direccion_ip}}</option>    
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12"></div>

            </div>
            
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
                    {{-- <option value="" selected>Seleccionar</option>
                    <option value="1">Lenovo</option>
                    <option value="2">HP</option> --}}
                    <option value=""></option>
                    @foreach ($marca_impresora as $item)
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
                    @foreach ($modelo_impresora as $item)
                        <option value="{{$item->id}}">{{$item->nombre_modelo}} ({{$item->nombre_marca}})</option>
                    @endforeach
                    {{-- <option value="" selected>Seleccionar</option>
                    <option value="1">10EYA02QCS</option>
                    <option value="2">10NS0006US</option>
                    <option value="3">10NS0006US</option>
                    <option value="3">10SDS0NN00</option>
                    <option value="3">10SDS13500</option>
                    <option value="3">10SDS3K300</option>
                    <option value="3">11CLS1U600</option>
                    <option value="3">205 G3 AiO</option>
                    <option value="3">aio 22-c0xx</option>
                    <option value="3">AIO 24-F0XX</option>
                    <option value="3">Elite Desktop 705 G1</option>
                    <option value="3">EliteBook 840 G4</option>
                    <option value="3">HP All-in-One 22-c0xx</option>
                    <option value="3">HP EliteBook 840 G4</option>
                    <option value="3">HP ProBook 440 G5</option>
                    <option value="3">M700Z</option>
                    <option value="3">M70a</option>
                    <option value="3">M810z</option>
                    <option value="3">M820z</option>
                    <option value="3">ProDesk 400 G3 </option> --}}
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="tipo_id">Tipo</label>
                <select class="form-control" id="tipo_id" name="tipo_id">
                    {{-- <option value="" selected>Seleccionar</option>
                    <option value="1">AIO</option>
                    <option value="2">Desktop</option>
                    <option value="3">Notebook</option> --}}
                    <option value=""></option>
                    @foreach ($tipo_impresora as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="candado_id">Estado Candado</label>
                <select class="form-control" id="candado_id" name="candado_id">
                    <option value="" selected>Seleccionar</option>
                    {{-- <option value="1">Con Candado</option>
                    <option value="2">Sin Candado</option> --}}
                    @foreach ($estado_candado as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="corriente_id">Corriente</label>
                <select class="form-control" id="corriente_id" name="corriente_id">
                    <option value="" selected>Seleccionar</option>
                    {{-- <option value="1">Respaldo</option>
                    <option value="2">Normal</option> --}}
                    @foreach ($corriente as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {{-- <div class="col-lg-4 col-md-12 col-sm-6">
            <div class="form-group">
                <label for="oc_id">Orden de Compra</label>
                <select class="form-control" id="oc_id" name="oc_id">
                    <option value="" selected>Seleccionar</option>
                    @foreach ($orden_compra as $item)
                        <option value="{{$item->id}}">{{$item->descripcion}}</option>
                    @endforeach
                </select>
            </div>
        </div> --}}
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
                    {{-- <option value="1">Activo</option>
                    <option value="2">Inactivo</option> --}}
                    @foreach ($estado_dispositivo as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 text-center">
            <button type="button" id="btn_guardar_form_impresora" route="{{ route('inventario.impresora_create') }}" class="btn btn-success btn-md">Guardar</button>
        </div>
    </div>
</form>

<script>
    var cerrar_modal_reg_impresora = false;
    $(document).ready(function () {

        //bloquea campos iniciales form registro PC
        bloqueaCamposFormRegistrarImpresora();

        $('#modal_registrar_impresora .close').on('click', function (event) {
           console.log(event);
           event.preventDefault(); // Previene el cierre del modal
           event.stopPropagation(); // Detiene la propagación del evento

           if (!cerrar_modal_reg_impresora){
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
                        cerrar_modal_reg_impresora = true;
                        $('#modal_registrar_impresora').modal('hide');
                        //$('#body_modal_registrar_impresora').html('');
                        console.log('confirma salir');
                        
                    } else {
                        cerrar_modal_reg_impresora = false;
                    }
                });
           }

        });
        
        $('#modal_registrar_impresora').on('hidden.bs.modal', function () {
            console.log('El modal crear ha sido cerrado.');
            $('#body_modal_registrar_impresora').html('');
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

        $('input[id^=conexion_id_]').on('click', function (event) {
            //event.preventDefault();
            $('input[id^=conexion_id_]').prop('checked',false);
            $(this).prop('checked',true);
            if ($(this).val() == 2) {
                //val 2 = IP
                $('#ip_id').val(null).trigger("change").prop('disabled',false);
            } else {
                $('#ip_id').val(null).trigger("change").prop('disabled',true);
            }
        });

        
        $('#numero_sala').select2({
            //placeholder: '',
            //allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            tags: true, // permite crear tags
            dropdownParent: $("#form_registrar_impresora")
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
        
        /* $('#serie').on('keyup', async function (event) {
            event.preventDefault();

            let val_serie = $('#serie').val();
                val_serie = val_serie.trim();

                if (val_serie && val_serie.length > 0 && val_serie.length < 6 ){

                    console.log('Ingrese número de serie (min. 6 caracteres)');

                    $('#serie').removeClass('is-valid').addClass('is-invalid');
                    $('#serie').next('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
                    
                    //bloqueaCamposFormRegistrarImpresora();
                    $('#btn_guardar_form_impresora').prop('disabled',true);

                } else if (val_serie && val_serie.length > 5){

                    console.log('comprobar serie');
                    
                    //await comprobar_serie_impresora(val_serie);

                } else {

                    console.log('ingrese numero de serie');
                    
                    $(this).removeClass('is-valid').addClass('is-invalid').val('');
                    $(this).next('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
                    Swal.fire({
                        icon: "error",
                        title: "Ingrese número de serie",
                        text: "-El número de serie es obligatorio"
                    });
                    //bloqueaCamposFormRegistrarImpresora();
                    $('#btn_guardar_form_impresora').prop('disabled',true);
                    
                }
            
        }); */
        $('#btn_cambiar_serie_impresora').on('click', function (event) {
            event.preventDefault();
            $('#serie').prop('disabled',false).val('').focus();
            $('#serie').removeClass('is-valid').addClass('is-invalid');
            $('#serie').parent().find('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
            bloqueaCamposFormRegistrarImpresora();
            $('#btn_comprobar_serie_impresora').prop('disabled',false);
            setTimeout(() => {
                $('#serie').focus();
            }, 150);
        });

        $('#btn_comprobar_serie_impresora').on('click',async function (event) {
           event.preventDefault();

                let val_serie = $('#serie').val();
                val_serie = val_serie.trim();

                if (val_serie && val_serie.length > 0 && val_serie.length < 6 ){

                    console.log('Ingrese número de serie (min. 6 caracteres)');

                    $('#serie').removeClass('is-valid').addClass('is-invalid');
                    $('#serie').parent().find('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
                    
                    bloqueaCamposFormRegistrarImpresora();

                    setTimeout(() => {
                        $('#serie').focus();
                    }, 150);

                } else if (val_serie && val_serie.length > 5){

                    console.log('comprobar serie');
                    
                    await comprobar_serie_impresora(val_serie);

                } else {

                    console.log('ingrese numero de serie');
                    
                    $('#serie').removeClass('is-valid').addClass('is-invalid').val('');
                    $('#serie').parent().find('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
                    
                    bloqueaCamposFormRegistrarImpresora();
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
        $('#ip_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            //minimumResultsForSearch : Infinity, // oculta el cuadro de busqueda (no permite escribir)
            //minimumInputLength: 8, 
            dropdownParent: $("#form_registrar_impresora")
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

        //buscar libre
        $('#sala_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_impresora")
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
            dropdownParent: $("#form_registrar_impresora")
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
        $('#marca_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_impresora")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            if ($(this).val()){
                console.log(e);
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');
                /* let modelo_id = $('#modelo_id').val();
                if (!modelo_id){
                    obtener_modelos_por_tipo_marca($(this).val());
                    $(`[aria-controls="select2-modelo_id-container"]`).removeClass('is-valid is-invalid');
                } */
                obtener_modelos_por_tipo_marca($(this).val());
                $(`[aria-controls="select2-modelo_id-container"]`).removeClass('is-valid is-invalid');
            } else {
                $(this).closest('td').next('td').find('select').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true).val('');

                $(`[aria-controls="select2-modelo_id-container"]`).removeClass('is-valid is-invalid');
                $('#modelo_id').val(null).trigger("change").removeClass('is-valid is-invalid');

                obtener_modelos_por_tipo();
            }
        });
        $('#modelo_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_impresora")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            if ($(this).val()){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');

                obtener_marca_por_modelo($(this).val());
            } else {
                $(this).closest('td').next('td').find('select').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true).val('');
            }
        });
        
        $('#tipo_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_impresora")
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
        
        
        $('#candado_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_impresora")
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
        $('#corriente_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_impresora")
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
            dropdownParent: $("#form_registrar_impresora")
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
            dropdownParent: $("#form_registrar_impresora")
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
        /* $('#oc_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_impresora")
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

        //minimo 2 caracteres para buscar
        $('.slc2-min2-form-pc').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            minimumInputLength: 2, 
            //dropdownParent: $("#form_registrar_impresora")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        });

        //seleccion multiple
        /* $('#apps').select2({
            placeholder: 'Agregar',
            theme: 'bootstrap4',
            multiple: true,
            //tags: true, // permite crear tags
            //dropdownParent: $("#form_registrar_impresora")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }); */

        //seleccionables
        /* $('#marca_id').select2({
            placeholder: 'Seleccionar',
            allowClear: true,
            theme: 'bootstrap4',
            minimumResultsForSearch : Infinity, // oculta el cuadro de busqueda (no permite escribir)
            //dropdownParent: $("#form_registrar_impresora")
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



       

       
        
      

        

        $('#btn_guardar_form_impresora').on('click', function (event) {
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

            if ($('input[id^=conexion_id_]:checked').val() == 2 && !document.getElementById('ip_id').value){
                // 2 Ethernet
                return_ = false;
                $('#ip_id').removeClass('is-valid is-invalid').addClass('is-invalid').focus();
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
                //antivirus_id: document.getElementById('antivirus_id').value,
                candado_id: document.getElementById('candado_id').value,
                corriente_id: document.getElementById('corriente_id').value,
                estado_id: document.getElementById('estado_id').value,
                propietario_id: document.getElementById('propietario_id').value,
                ip_id: document.getElementById('ip_id').value,
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
                tipo_id: document.getElementById('tipo_id').value,
                conexion_id: $('input[id^=conexion_id_]:checked').val(),
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
                    confirmButton: "btn btn-primary",
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

                            $('#modal_registrar_impresora').modal('hide');

                            loader('stop');
                            Swal.fire({
                                icon: "success",
                                title: "Guardado con éxito",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            await cargarVistaTablaListadoImpresora();
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

    function bloqueaCamposFormRegistrarImpresora(){

        $('#form_registrar_impresora input').prop('disabled',true);
        $('#form_registrar_impresora select').prop('disabled',true);
        $('#form_registrar_impresora textarea').prop('disabled',true);
        $('#form_registrar_impresora button').prop('disabled',true);
        $('#form_registrar_impresora #serie').prop('disabled',false);
        $('#btn_comprobar_serie_impresora').prop('disabled',false);
        $('#btn_cambiar_serie_impresora').prop('disabled',false);
        
    }
    /* async */ function ActivaCamposFormRegistrarPC(){

        //await new Promise(resolve => setTimeout(resolve, 500));
        //await new Promise(resolve => (resolve));

        $('#form_registrar_impresora input').prop('disabled',false);
        $('#form_registrar_impresora select').prop('disabled',false);
        $('#form_registrar_impresora textarea').prop('disabled',false);
        $('#form_registrar_impresora button').prop('disabled',false);
        $('#numero_sala').prop('disabled',true);
        $('#nombre_sala').prop('disabled',true);
        $('#serie').prop('disabled',true);
        $('#ip_id').prop('disabled',true);

    }
    /* async */ function bloqueaCamposAppsFormRegistrarPc(){

        //await new Promise(resolve => (resolve));

        $('#form_registrar_impresora #slc_apl_lic_so').prop('disabled',true);
        $('#form_registrar_impresora #slc_apl_lic_office').prop('disabled',true);
        $('#form_registrar_impresora #slc_apl_lic_antivirus').prop('disabled',true);
        $('#form_registrar_impresora select[id^=slc_apl_lic_app_]').prop('disabled',true);
        $('#form_registrar_impresora input[id^=licencia_app_]').prop('disabled',true);
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

    async function obtener_modelos_por_tipo(){

        const tipo_id = 2; // 2 - TIPO DISPOSITIVO IMPRESORA

        console.log(tipo_id);

        loader('show');
        try {
            const route = document.getElementById('route_obtener_modelos_por_tipo').value;
            const url = route + `/${tipo_id}`;
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
                if (data.modelos){
                    $('#modelo_id').html('<option value="" hidden selected></option>');
                    data.modelos.forEach(element => {
                        $('#modelo_id').append(`<option value="${element.id}">${element.nombre}</option>`);
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

    async function obtener_modelos_por_tipo_marca(marca_id){

        const tipo_id = 2; // 2 - TIPO DISPOSITIVO IMPRESORA

        console.log(tipo_id,marca_id);

        loader('show');
        try {
            const route = document.getElementById('route_obtener_modelos_por_tipo_marca').value;
            const url = route + `/${tipo_id}/${marca_id}`;
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
                if (data.modelos){
                    let modelo_id = $('#modelo_id').val();
                    $('#modelo_id').html('<option value="" hidden selected></option>');
                    data.modelos.forEach(element => {
                        if (element.id != modelo_id){
                            $('#modelo_id').append(`<option value="${element.id}">${element.nombre}</option>`);
                        } else {
                            $('#modelo_id').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                            $(`[aria-controls="select2-modelo_id-container"]`).addClass('is-valid');
                        }
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

    async function obtener_marca_por_modelo(modelo_id){

        console.log(modelo_id);

        loader('show');
        try {
            const route = document.getElementById('route_obtener_marca_por_modelo').value;
            const url = route + `/${modelo_id}`;
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
                if (data.marca){
                    $('#marca_id').val(data.marca.marca_id).trigger("change").prop('disabled',false);
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

    async function comprobar_serie_impresora(serie){

        console.log(serie);
        loader('show');
        try {
            
            const route = document.getElementById('route_comprobar_serie_impresora').value;
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
                    bloqueaCamposFormRegistrarImpresora();
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
                    $('#btn_comprobar_serie_impresora').prop('disabled',true);
                    
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