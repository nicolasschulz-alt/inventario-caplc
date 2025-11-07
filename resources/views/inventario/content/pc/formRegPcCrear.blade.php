<style>
    #modal_registrar_pc .form-group select,
    #modal_registrar_pc .form-group option,
    #modal_registrar_pc .form-group input,
    #modal_registrar_pc .form-group textarea,
    #modal_registrar_pc .form-group label
    {
        /* font-size: 14px; */
        color: #3a3b45;
    }
    #modal_registrar_pc .form-group label{
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
        color: #fff !important;
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

<form action="{{asset('/inventario/pc_create')}}" id="form_registrar_pc" route="{{ route('inventario.pc_create') }}" novalidate>
    @csrf
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group mb-1">
                <label for="serie">Serie</label>
                <div class="input-group">
                    
                    <input type="text" id="serie" name="serie" placeholder="" class="form-control is-invalid" value="" required autocomplete="off">

                    <div class="input-group-append">
                        <button id="btn_comprobar_serie_pc" class="btn btn-info btn-sm" type="button" id="button-addon2"><i class="fas fa-check-circle"></i></button>
                        <button id="btn_cambiar_serie_pc" class="btn btn-warning btn-sm" type="button" id="button-addon2"><i class="fas fa-pen fa-sm"></i></button>
                    </div>
                    
                    <div class="serie-feedback invalid-feedback">
                        Ingrese número de serie (min. 6 caracteres)
                    </div>
                    <input type="hidden" id="route_comprobar_serie_pc" value="{{ route('inventario.comprobar_serie_pc') }}">
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="num_inventario">Número de Inventario</label>
                <input type="text" id="num_inventario" name="num_inventario" placeholder="" class="form-control ipt_slc_value" value="" autocomplete="off">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
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
        <div class="col-md-12 col-sm-12">
            <div class="row">
                <div class="col-md-4 col-sm-12 mt-3">
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

                <div class="col-md-8 col-sm-12 mt-3">
                    <div class="row" style="display: block;">
                        <div class="col-md-12 col-sm-12 py-0">
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
                </div>

                
            </div>
            
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="nombre_equipo">Nombre de Equipo</label>
                <input type="text" class="form-control ipt_slc_value" placeholder="" name="nombre_equipo" id="nombre_equipo" value="" autocomplete="off">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="nombre_usuario_ad">Nombre de Usuario AD</label>
                <input type="text" name="nombre_usuario_ad" id="nombre_usuario_ad" placeholder="" class="form-control ipt_slc_value" value="" autocomplete="off">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="marca_id">Marca</label>
                <select class="form-control" id="marca_id" name="marca_id">
                    {{-- <option value="" selected>Seleccionar</option>
                    <option value="1">Lenovo</option>
                    <option value="2">HP</option> --}}
                    <option value=""></option>
                    @foreach ($marca_pc as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="modelo_id">Modelo</label>
                <select class="form-control" id="modelo_id" name="modelo_id">
                    <option value=""></option>
                    @foreach ($modelo_pc as $item)
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
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="tipo_id">Tipo</label>
                <select class="form-control" id="tipo_id" name="tipo_id">
                    {{-- <option value="" selected>Seleccionar</option>
                    <option value="1">AIO</option>
                    <option value="2">Desktop</option>
                    <option value="3">Notebook</option> --}}
                    <option value=""></option>
                    @foreach ($tipo_pc as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="cpu_id">CPU</label>
                <select class="form-control" id="cpu_id" name="cpu_id">
                    <option value="" selected>Seleccionar</option>
                    @foreach ($cpu_pc as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                    {{-- <option value="1">AMD A4-9125</option>
                    <option value="1">AMD A8 Pro</option>
                    <option value="1">intel celeron j4005</option>
                    <option value="1">intel core i3-9100t</option>
                    <option value="1">Intel Core I5 10400</option>
                    <option value="1">Intel Core I5 8400</option>
                    <option value="1">Intel Core I5-6400T</option>
                    <option value="1">Intel Core I5-6500</option>
                    <option value="1">Intel Core I7-6700</option>
                    <option value="1">Intel Core I5-7400</option>
                    <option value="1">Intel Core I7-7600</option>
                    <option value="1">Intel Core I5-7700</option>
                    <option value="1">intel core i5-8400</option>
                    <option value="1">Intel Core I5-9400</option>
                    <option value="1">Intel Core I5-9500</option>
                    <option value="1">Intel Core i7 7600U</option>
                    <option value="1">Intel Core i7 8550U</option>                                                                    
                    <option value="1">Intel Core I7-7700</option> --}}
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="ram_id">RAM</label>
                <select class="form-control" id="ram_id" name="ram_id">
                    <option value="" selected>Seleccionar</option>
                    @foreach ($ram_pc as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                    {{-- <option value="1">2GB</option>
                    <option value="1">4GB</option>
                    <option value="1">8GB</option>
                    <option value="1">16GB</option> --}}
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="disco_id">Disco</label>
                <select class="form-control" id="disco_id" name="disco_id">
                    <option value="" selected>Seleccionar</option>
                    @foreach ($disco_pc as $item)
                        <option value="{{$item->id}}">{{$item->nombre_disco}} ({{$item->nombre_tipo_disco}})</option>
                    @endforeach
                    {{-- <option value="1">240GB</option>
                    <option value="1">250GB</option>
                    <option value="1">256GB</option>
                    <option value="1">480GB</option>
                    <option value="1">500GB</option>
                    <option value="1">512GB</option>
                    <option value="1">960GB</option>
                    <option value="1">1TB</option>
                    <option value="1">2TB</option>
                    <option value="1">4TB</option> --}}
                </select>
            </div>
        </div>
        
        
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                
                {{-- <select class="form-control" id="apps" multiple="multiple">
                    <option>Bizagi Modeler</option>
                    <option>Adobe Photoshop</option>
                    <option>Autocad</option>
                    <option>Access</option>
                    <option>Rni</option>
                    <option>Visio</option>
                    <option>SIRH</option>
                </select> --}}

                <div id="div_app">

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col_overflow_auto">

                            <div class="row">


                                <div class="col-md-12 col-sm-12">
                                        <label for="so_id">Sistema operativo</label>
                                        {{-- <select class="form-control" id="so_id" name="so_id">
                                            <option value="" selected>Seleccionar</option>
                                            <option value="1">Win 10 Home</option>
                                            <option value="1">Win 10 Pro</option>
                                            <option value="1">Win 11 Home</option>
                                            <option value="1">Win 11 Pro</option>
                                            <option value="1">Win 7 Pro</option>
                                        </select> --}}
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <table class="table table-bordered text-white">
                                        <thead class="">
                                            <tr>
                                                <th class="p-tabla-head" width="50%">Sistema operativo</th>
                                                <th class="p-tabla-head">Aplica Licencia</th>
                                                <th class="p-tabla-head">Licencia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <tr>
                                                <td scope="row" nowrap width="50%">
                                                    <select class="form-control" id="so_id" name="so_id">
                                                        <option value="" selected>Seleccionar</option>
                                                        @foreach ($sistema_operativo as $item)
                                                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                        @endforeach
                                                        {{-- <option value="1">Win 10 Home</option>
                                                        <option value="2">Win 10 Pro</option>
                                                        <option value="3">Win 11 Home</option>
                                                        <option value="4">Win 11 Pro</option>
                                                        <option value="5">Win 7 Pro</option> --}}
                                                    </select>
                                                </td>
                                                <td nowrap>
                                                    <div class="form-group no-margen-bottom">
                                                        <select disabled class="form-control ancho-wbk-fill-av" id="slc_apl_lic_so" >
                                                            <option value="" selected hidden>--</option>
                                                            <option value="1">Con licencia</option>
                                                            <option value="0">Sin licencia</option>
                                                            <option value="2">No aplica</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td nowrap>
                                                    <input disabled type="text" class="form-control ancho-wbk-fill-av" id="licencia_so" placeholder="--" autocomplete="off">
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-12 col-sm-12 col_overflow_auto">

                            <div class="row">
                        
                                <div class="col-md-12 col-sm-12">
                                    <label for="office_id">Office</label>
                                    {{-- <select class="form-control" id="office_id" name="office_id">
                                        <option value="" selected>Seleccionar</option>
                                        <option value="1">Office 365 empresa</option>
                                        <option value="1">Office LTSC STANDARD 2021</option>
                                        <option value="1">Office H&B 2019</option>
                                        <option value="1">Office H&B 2016</option>
                                        <option value="1">Office H&B 2021</option>
                                        <option value="1">Office PRO 2016</option>
                                    </select> --}}
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <table class="table table-bordered">
                                        <thead class="">
                                            <tr>
                                                <th class="p-tabla-head" width="50%">Office</th>
                                                <th class="p-tabla-head">Aplica Licencia</th>
                                                <th class="p-tabla-head">Licencia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td scope="row" nowrap width="50%">
                                                    <select class="form-control" id="office_id" name="office_id">
                                                        <option value="" selected>Seleccionar</option>
                                                        @foreach ($office as $item)
                                                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                        @endforeach
                                                        {{-- <option value="1">Office 365 empresa</option>
                                                        <option value="2">Office LTSC STANDARD 2021</option>
                                                        <option value="3">Office H&B 2019</option>
                                                        <option value="4">Office H&B 2016</option>
                                                        <option value="5">Office H&B 2021</option>
                                                        <option value="6">Office PRO 2016</option> --}}
                                                        
                                                    </select>
                                                </td>
                                                <td nowrap>
                                                    <div class="form-group no-margen-bottom">
                                                        <select disabled class="form-control ancho-wbk-fill-av" id="slc_apl_lic_office" >
                                                        <option value="" selected hidden>--</option>
                                                        <option value="1">Con licencia</option>
                                                        <option value="0">Sin licencia</option>
                                                        <option value="2">No aplica</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td nowrap>
                                                    <input disabled type="text" class="form-control ancho-wbk-fill-av licencia_app" id="licencia_office" placeholder="--" autocomplete="off">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col_overflow_auto">

                            <div class="row">

                                <div class="col-md-12 col-sm-12">
                                        <label for="antivirus_id">Antivirus</label>
                                        {{-- <select class="form-control" id="antivirus_id" name="antivirus_id">
                                            <option value="" selected>Seleccionar</option>
                                            <option value="1">Bitdefender</option>
                                            <option value="2">Windows Defender</option>
                                        </select> --}}
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <table class="table table-bordered">
                                        <thead class="">
                                            <tr>
                                                <th class="p-tabla-head" width="50%">Antivirus</th>
                                                <th class="p-tabla-head">Aplica Licencia</th>
                                                <th class="p-tabla-head">Licencia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td scope="row" nowrap width="50%">
                                                    <select class="form-control" id="antivirus_id" name="antivirus_id">
                                                        {{-- <option value="" selected>--</option>
                                                        <option value="1">Bitdefender</option>
                                                        <option value="2">Windows Defender</option> --}}
                                                        <option value="" selected>Seleccionar</option>
                                                        @foreach ($antivirus as $item)
                                                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td nowrap>
                                                    <div class="form-group no-margen-bottom">
                                                        <select disabled class="form-control ancho-wbk-fill-av licencia_app" id="slc_apl_lic_antivirus" >
                                                            <option value="" selected hidden>--</option>
                                                            <option value="1">Con licencia</option>
                                                            <option value="0">Sin licencia</option>
                                                            <option value="2">No aplica</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td nowrap>
                                                    <input disabled type="text" class="form-control ancho-wbk-fill-av" id="licencia_antivirus" placeholder="--" autocomplete="off">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col_overflow_auto">

                            <div class="row">
                        

                                <div class="col-md-12 col-sm-12">
                                    <label for="apps">Aplicativos</label>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <table id="apps" class="table table-bordered table-hover">
                                        <thead class="">
                                            <tr>
                                                <th class="p-tabla-head" width="50%">App</th>
                                                <th class="p-tabla-head">Aplica Licencia</th>
                                                <th class="p-tabla-head">Licencia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($app_ecritorio as $item)
                                            <tr>
                                                <th scope="row" nowrap>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="{{$item->id}}" id="input_check_app_{{$item->id}}">
                                                        <label class="lbl-chck form-check-label" for="input_check_app_{{$item->id}}">
                                                            {{$item->nombre}}
                                                        </label>
                                                    </div>
                                                </th>
                                                <td nowrap>
                                                    <div class="form-group no-margen-bottom">
                                                        <select disabled class="form-control ancho-wbk-fill-av" id="slc_apl_lic_app_{{$item->id}}" >
                                                            <option value="" selected hidden>--</option>
                                                            <option value="1">Con licencia</option>
                                                            <option value="0">Sin licencia</option>
                                                            <option value="2">No aplica</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td nowrap>
                                                    <input disabled type="text" class="form-control ancho-wbk-fill-av" id="licencia_app_{{$item->id}}" placeholder="--" autocomplete="off">
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="text" placeholder="" class="form-control ipt_slc_value" id="correo" name="correo" value="" autocomplete="off">
            </div>
        </div> --}}
        {{-- <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="telefono_id">Teléfono</label>
                <select class="form-control" id="telefono_id" name="telefono_id">
                    <option value=""></option>
                    @foreach ($anexo as $item)
                        <option value="{{$item->id}}">{{$item->anexo}}</option>
                    @endforeach
                </select>
                <input type="hidden" id="anexo" value="">
            </div>
        </div> --}}
        <div class="col-md-4 col-sm-12">
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
        <div class="col-md-4 col-sm-12">
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
        {{-- <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label for="segunda_pantalla">Segunda Pantalla</label>
                <select class="form-control" id="segunda_pantalla" name="segunda_pantalla">
                    <option value="" selected>Seleccionar</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
        </div> --}}
        <div class="col-md-4 col-sm-6">
            <div class="form-group">
                <label for="oc_id">Orden de Compra</label>
                <select class="form-control" id="oc_id" name="oc_id">
                    <option value="" selected>Seleccionar</option>
                    {{-- <option value="1">Orden de compra 1</option>
                    <option value="1">Orden de compra 2</option> --}}
                    @foreach ($orden_compra as $item)
                        <option value="{{$item->id}}">{{$item->descripcion}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
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
        <div class="col-md-12 text-center">
            <button type="button" id="btn_guardar_form_pc" route="{{ route('inventario.pc_create') }}" class="btn btn-success btn-md">Guardar</button>
        </div>
    </div>
</form>

<script>
    var cerrar_modal_reg_pc = false;
    $(document).ready(function () {

        //bloquea campos iniciales form registro PC
        bloqueaCamposFormRegistrarPC();

        $('#modal_registrar_pc .close').on('click', function (event) {
           console.log(event);
           event.preventDefault(); // Previene el cierre del modal
           event.stopPropagation(); // Detiene la propagación del evento

           if (!cerrar_modal_reg_pc){
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
                        cerrar_modal_reg_pc = true;
                        $('#modal_registrar_pc').modal('hide');
                        //$('#body_modal_registrar_pc').html('');
                        console.log('confirma salir');
                        
                    } else {
                        cerrar_modal_reg_pc = false;
                    }
                });
           }

        });
        
        $('#modal_registrar_pc').on('hidden.bs.modal', function () {
            console.log('El modal crear ha sido cerrado.');
            $('#body_modal_registrar_pc').html('');
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
            dropdownParent: $("#form_registrar_pc")
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

        /* $('#telefono_id').select2({
            //placeholder: '',
            //allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            tags: true, // permite crear tags
            dropdownParent: $("#form_registrar_pc")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();

            let optionNotValue = $('<option>', {
                value: '',
                text: 'Select / crear'
            });
            $('#telefono_id option:first').replaceWith(optionNotValue);            
            $('#telefono_id').val('').trigger("change");

        }).on('select2:close', function(e) {
            if (!$(this).val()){
                console.log('Select2 se ha cerrado');
                let optionNotValue = $('<option>', {
                    value: '',
                    text: ''
                });
                $('#telefono_id option:first').replaceWith(optionNotValue);
                $('#telefono_id').val(null).trigger("change");
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid is-invalid');
            }

        }).on('change', function (e) {
            //console.log(e,e.target.value);
            let val_this = $(this).val();
            //let tag = false;
            const solo_numeros = /^\d+$/;
            if (val_this){

                console.log(val_this);
                //$('#telefono_id option[value=""]').text('Select / crear');
                

                if (solo_numeros.test(val_this)){
                    $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-invalid').addClass('is-valid');
                } else {
                    //$('#numero_sala').val(null).trigger("change").prop('disabled',false);
                    $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid').addClass('is-invalid');
                }

                if ($("#telefono_id option:selected").attr('data-select2-tag')){
                    console.log('es tag telefono');
                    document.getElementById('anexo').value = val_this;
                }

            } else {
                //$('#nombre_sala').prop('disabled',true).val('').removeClass('is-invalid is-valid');
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid').addClass('is-invalid');
            }
        }); */

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
                    
                    //bloqueaCamposFormRegistrarPC();
                    $('#btn_guardar_form_pc').prop('disabled',true);

                } else if (val_serie && val_serie.length > 5){

                    console.log('comprobar serie');
                    
                    //await comprobar_serie_pc(val_serie);

                } else {

                    console.log('ingrese numero de serie');
                    
                    $(this).removeClass('is-valid').addClass('is-invalid').val('');
                    $(this).next('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
                    Swal.fire({
                        icon: "error",
                        title: "Ingrese número de serie",
                        text: "-El número de serie es obligatorio"
                    });
                    //bloqueaCamposFormRegistrarPC();
                    $('#btn_guardar_form_pc').prop('disabled',true);
                    
                }
            
        }); */
        $('#btn_cambiar_serie_pc').on('click', function (event) {
            event.preventDefault();
            $('#serie').prop('disabled',false).val('').focus();
            $('#serie').removeClass('is-valid').addClass('is-invalid');
            $('#serie').parent().find('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
            bloqueaCamposFormRegistrarPC();
            $('#btn_comprobar_serie_pc').prop('disabled',false);
            setTimeout(() => {
                $('#serie').focus();
            }, 150);
        });

        $('#btn_comprobar_serie_pc').on('click',async function (event) {
           event.preventDefault();

                let val_serie = $('#serie').val();
                val_serie = val_serie.trim();

                if (val_serie && val_serie.length > 0 && val_serie.length < 6 ){

                    console.log('Ingrese número de serie (min. 6 caracteres)');

                    $('#serie').removeClass('is-valid').addClass('is-invalid');
                    $('#serie').parent().find('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
                    
                    bloqueaCamposFormRegistrarPC();

                    setTimeout(() => {
                        $('#serie').focus();
                    }, 150);

                } else if (val_serie && val_serie.length > 5){

                    console.log('comprobar serie');
                    
                    await comprobar_serie_pc(val_serie);

                } else {

                    console.log('ingrese numero de serie');
                    
                    $('#serie').removeClass('is-valid').addClass('is-invalid').val('');
                    $('#serie').parent().find('.serie-feedback').removeClass('valid-feedback').addClass('invalid-feedback').html('Ingrese número de serie (min. 6 caracteres)');
                    
                    bloqueaCamposFormRegistrarPC();
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
            dropdownParent: $("#form_registrar_pc")
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
            dropdownParent: $("#form_registrar_pc")
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
            dropdownParent: $("#form_registrar_pc")
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
            dropdownParent: $("#form_registrar_pc")
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
        $('#disco_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_pc")
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
        /* $('#telefono_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_pc")
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
        $('#marca_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_pc")
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
        $('#tipo_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_pc")
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
        $('#cpu_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_pc")
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
        $('#ram_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_pc")
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
        $('#so_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_pc")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            console.log(typeof $(this).val());
            if ($(this).val()){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('placeholder','--').prop('disabled',false).val('');
            } else {
                $(this).closest('td').next('td').find('select').removeClass('is-invalid is-valid').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').removeClass('is-invalid is-valid').prop('placeholder','--').prop('disabled',true).val('');
            }
        });
        $('#office_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_pc")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            if ($(this).val()){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');
            } else {
                $(this).closest('td').next('td').find('select').removeClass('is-invalid is-valid').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').removeClass('is-invalid is-valid').prop('disabled',true).val('');
            }
        });
        $('#antivirus_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_pc")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            if ($(this).val()){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');
            } else {
                $(this).closest('td').next('td').find('select').removeClass('is-invalid is-valid').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').removeClass('is-invalid is-valid').prop('disabled',true).val('');
            }
        });
        $('#candado_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_pc")
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
            dropdownParent: $("#form_registrar_pc")
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
            dropdownParent: $("#form_registrar_pc")
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
            dropdownParent: $("#form_registrar_pc")
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
        $('#oc_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#form_registrar_pc")
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
            //dropdownParent: $("#form_registrar_pc")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        });

        //seleccion multiple
        /* $('#apps').select2({
            placeholder: 'Agregar',
            theme: 'bootstrap4',
            multiple: true,
            //tags: true, // permite crear tags
            //dropdownParent: $("#form_registrar_pc")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }); */

        //seleccionables
        /* $('#marca_id').select2({
            placeholder: 'Seleccionar',
            allowClear: true,
            theme: 'bootstrap4',
            minimumResultsForSearch : Infinity, // oculta el cuadro de busqueda (no permite escribir)
            //dropdownParent: $("#form_registrar_pc")
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



        $('input[id^=input_check_app_]').on('click', function () {
            //console.log($(this).prop('checked'));
            if ($(this).prop('checked')){
                $(this).closest('tr').find('th').find('.lbl-chck').addClass('lbl-chck-active');
                $(this).closest('tr').find('select').prop('disabled',false).removeClass('is-valid').addClass('is-invalid');
                $(this).closest('tr').find('select option[value=""]').html('Seleccione');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true);
            } else {
                $(this).closest('tr').find('th').find('.lbl-chck').removeClass('lbl-chck-active');
                $(this).closest('tr').find('select').prop('disabled',true).removeClass('is-valid is-invalid').find('option:selected').prop('selected', false);
                $(this).closest('tr').find('select option[value=""]').html('--');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true).removeClass('is-valid is-invalid').prop('placeholder','--').val('');
            }
        });

        $('select[id=slc_apl_lic_so]').on('change', function () {
            //console.log($(this));
            let val_this = $(this).val();
            if (val_this){
                $(this).removeClass('is-invalid').addClass('is-valid');
                if (val_this == 1){
                    //con licencia
                    $(this).closest('tr').find('input[type="text"]').prop('disabled',false).prop('placeholder','Escriba Licencia').addClass('is-invalid').val('').focus();
                } else {
                    $(this).closest('tr').find('input[type="text"]').prop('disabled',true).removeClass('is-valid is-invalid').prop('placeholder','--').val('');
                }
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        });
        $('select[id=slc_apl_lic_office]').on('change', function () {
           //console.log($(this));
            let val_this = $(this).val();
            if (val_this){
                $(this).removeClass('is-invalid').addClass('is-valid');
                if (val_this == 1){
                    //con licencia
                    $(this).closest('tr').find('input[type="text"]').prop('disabled',false).prop('placeholder','Escriba Licencia').addClass('is-invalid').val('').focus();
                } else {
                    $(this).closest('tr').find('input[type="text"]').prop('disabled',true).removeClass('is-valid is-invalid').prop('placeholder','--').val('');
                }
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        });
        $('select[id=slc_apl_lic_antivirus]').on('change', function () {
            //console.log($(this));
            let val_this = $(this).val();
            if (val_this){
                $(this).removeClass('is-invalid').addClass('is-valid');
                if (val_this == 1){
                    //con licencia
                    $(this).closest('tr').find('input[type="text"]').prop('disabled',false).prop('placeholder','Escriba Licencia').addClass('is-invalid').val('').focus();
                } else {
                    $(this).closest('tr').find('input[type="text"]').prop('disabled',true).removeClass('is-valid is-invalid').prop('placeholder','--').val('');
                }
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        });
        $('select[id^=slc_apl_lic_app_]').on('change', function () {
            //console.log($(this));
            let val_this = $(this).val();
            if (val_this){
                $(this).removeClass('is-invalid').addClass('is-valid');
                if (val_this == 1){
                    //con licencia
                    $(this).closest('tr').find('input[type="text"]').prop('disabled',false).prop('placeholder','Escriba Licencia').addClass('is-invalid').val('').focus();
                } else {
                    $(this).closest('tr').find('input[type="text"]').prop('disabled',true).removeClass('is-valid is-invalid').prop('placeholder','--').val('');
                }
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        });

        $('input[id^=licencia_app_],#licencia_antivirus,#licencia_office,#licencia_so').on('input', function () {
            //console.log($(this));
            let val_this = $(this).val();
            val_this = val_this.trim();
            if (val_this){
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid').val('');
            }
        });

        $('#btn_guardar_form_pc').on('click', function (event) {
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
                        })

                    }

                    if (!document.getElementById('nombre_sala').value){

                        return_ = false;
                        $('#nombre_sala').removeClass('is-valid is-invalid').addClass('is-invalid').focus();
                        Swal.fire({
                            title: "Complete los campos requeridos!",
                            text: "",
                            icon: "warning"
                        })

                    }                

                }        

            }

            if (!return_){
                return false;
            }

            const objeto_data = {
                //antivirus_id: document.getElementById('antivirus_id').value,
                candado_id: document.getElementById('candado_id').value,
                //correo: document.getElementById('correo').value,
                corriente_id: document.getElementById('corriente_id').value,
                cpu_id: document.getElementById('cpu_id').value,
                disco_id: document.getElementById('disco_id').value,
                estado_id: document.getElementById('estado_id').value,
                ip_id: document.getElementById('ip_id').value,
                marca_id: document.getElementById('marca_id').value,
                modelo_id: document.getElementById('modelo_id').value,
                nombre_equipo: document.getElementById('nombre_equipo').value,
                nombre_usuario_ad: document.getElementById('nombre_usuario_ad').value,
                num_inventario: document.getElementById('num_inventario').value,
                observaciones: document.getElementById('observaciones').value,
                oc_id: document.getElementById('oc_id').value,
                //office_id: document.getElementById('office_id').value,
                ram_id: document.getElementById('ram_id').value,

                sala_id: document.getElementById('sala_id').value,

                edificio_piso: document.getElementById('edificio_piso').value,
                numero_sala: document.getElementById('numero_sala').value,
                nombre_sala: document.getElementById('nombre_sala').value,
                
                serie: document.getElementById('serie').value,
                //so_id: document.getElementById('so_id').value,
                 
                //telefono_id: document.getElementById('telefono_id').value,
                //anexo: document.getElementById('anexo').value,
                tipo_id: document.getElementById('tipo_id').value,
                propietario_id: document.getElementById('propietario_id').value,
                apps: [],
                _token:  document.querySelector('meta[name="csrf-token"]').content
            };

            //hacer recorrido que capture las apps seleccionables y enviarlas en un array de objetos dentro de un atributo dentro del objeto general
            let apps = [];
            $('#apps input[id^=input_check_app_]').each(function (index, element) {
                if ($(element).prop('checked')){
                    let id = $(element).val();
                    if (id){
                        apps.push({
                            app_id: id,
                            apl_licencia: $(`#slc_apl_lic_app_${id}`).val(),
                            licencia: $(`#licencia_app_${id}`).val()
                        });
                    }
                }
            });

            if (document.getElementById('so_id').value){
                apps.push({
                    app_id: document.getElementById('so_id').value,
                    apl_licencia: $(`#slc_apl_lic_so`).val(),
                    licencia: $(`#licencia_so`).val()
                });
            }
            if (document.getElementById('office_id').value){
                apps.push({
                    app_id: document.getElementById('office_id').value,
                    apl_licencia: $(`#slc_apl_lic_office`).val(),
                    licencia: $(`#licencia_office`).val()
                });
            }
            if (document.getElementById('antivirus_id').value){
                apps.push({
                    app_id: document.getElementById('antivirus_id').value,
                    apl_licencia: $(`#slc_apl_lic_antivirus`).val(),
                    licencia: $(`#licencia_antivirus`).val()
                });
            }

            objeto_data.apps = apps;

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

                            $('#modal_registrar_pc').modal('hide');

                            loader('stop');
                            Swal.fire({
                                icon: "success",
                                title: "Guardado con éxito",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            await cargarVistaTablaListadoPc();
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

    

        





    function bloqueaCamposFormRegistrarPC(){

        $('#form_registrar_pc input').prop('disabled',true);
        $('#form_registrar_pc select').prop('disabled',true);
        $('#form_registrar_pc textarea').prop('disabled',true);
        $('#form_registrar_pc button').prop('disabled',true);
        $('#form_registrar_pc #serie').prop('disabled',false);
        $('#btn_comprobar_serie_pc').prop('disabled',false);
        $('#btn_cambiar_serie_pc').prop('disabled',false);
        
    }
    /* async */ function ActivaCamposFormRegistrarPC(){

        //await new Promise(resolve => setTimeout(resolve, 500));
        //await new Promise(resolve => (resolve));

        $('#form_registrar_pc input').prop('disabled',false);
        $('#form_registrar_pc select').prop('disabled',false);
        $('#form_registrar_pc textarea').prop('disabled',false);
        $('#form_registrar_pc button').prop('disabled',false);
        $('#numero_sala').prop('disabled',true);
        $('#nombre_sala').prop('disabled',true);
        $('#serie').prop('disabled',true);
        

    }
    /* async */ function bloqueaCamposAppsFormRegistrarPc(){

        //await new Promise(resolve => (resolve));

        $('#form_registrar_pc #slc_apl_lic_so').prop('disabled',true);
        $('#form_registrar_pc #slc_apl_lic_office').prop('disabled',true);
        $('#form_registrar_pc #slc_apl_lic_antivirus').prop('disabled',true);
        $('#form_registrar_pc select[id^=slc_apl_lic_app_]').prop('disabled',true);
        $('#form_registrar_pc input[id^=licencia_app_]').prop('disabled',true);
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

    async function comprobar_serie_pc(serie){

        console.log(serie);
        loader('show');
        try {
            
            const route = document.getElementById('route_comprobar_serie_pc').value;
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
                    bloqueaCamposFormRegistrarPC();
                    Swal.fire({
                        icon: "warning",
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
                    $('#btn_comprobar_serie_pc').prop('disabled',true);
                    
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