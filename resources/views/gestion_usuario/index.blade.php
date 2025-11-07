@extends('layouts.app-laravel')

@section('plugin-extra-css')
    <link href="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugin/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/plugin/css/select2-bootstrap4.min.css')}}" rel="stylesheet"/>
    {{-- <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css"> --}}
    <link href="{{ asset('assets/fontawesome-add/v6.6.0/css/all.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('menu-content')
    @include('menu.content.menu-content-usuarios')
@endsection

@section('title')
    Gestión Usuarios
@endsection

@section('title-content')
    Dashboard
@endsection

@section('after-text-title-content')
    
@endsection

@section('content')

<style>
    .title-section-dashboard{
        text-align: center;
        padding-top: 30px;
        padding-bottom: 10px;
    }

    .flex-card-dash-inven{
        display: flex !important;
        flex-wrap: wrap;
        justify-content: center;
    }
    .card-dashboard-inven{
        min-width: 300px;
        max-width: 300px;
        flex: auto;
    }
    .card-dashboard-inven:hover{
        transition: all 0.3s ease;
        transform: scale(1.05);
        z-index: 2;
    }
    .card-body-dashboard-inven{
        text-align: center;
    }
    .disp-card-dash-head{

    }
    .disp-card-dash-body{
        padding-top: 10px;
        font-weight: 800;
        color: #3a3b45;
    }
    .disp-card-dash-footer{
        color: #fff;
        border-radius: 12px;
        margin-top: 6px;
        background: linear-gradient(180deg, #375ece, #3057c991);
    }
    .disp-card-dash-footer-extra{

    }

    .disp-card-dash-head i {
        font-size: 36px;
        height: 36px;
        width: 36px;
        color: #4d72de;
    }
    .icon-svg-pers-dash{
        font-size: 36px;
        height: 36px;
        fill: #4d72de;
    }
    .icon-svg-pers-dash path{
        fill: #4d72de;
    }
</style>



<section>
    <input type="hidden" id="route_gestion_usuarios" value="{{route('usuario.index')}}">
    <input type="hidden" id="route_include_buscar_user" value="{{route('usuario.include_buscar_user')}}">
    <input type="hidden" id="route_user_delete" value="{{route('usuario.user_delete')}}">
    <input type="hidden" id="route_permiso_user_delete" value="{{route('usuario.permiso_user_delete')}}">
    <input type="hidden" id="route_include_form_permiso_user_update" value="{{route('usuario.include_form_permiso_user_update')}}">
    <input type="hidden" id="route_permiso_user_update" value="{{route('usuario.permiso_user_update')}}">

    <div>
        <h4 class="title-section-dashboard">Gestión Usuarios</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card shadow mb-4" id="buscar_user">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Buscar Usuario</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group mb-0">
                                <label for="user_id">Usuarios</label>
                                <select id="user_id" name="user_id" class="form-control" name="state">
                                    <option value=""></option>
                                    @foreach ($users as $item)
                                        <option value="{{$item->id}}">
                                            {{$item->name}} ({{$item->email}})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row" >
                        <div class="col-md-12 col-sm-12 mt-4" id="selected_user">

                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12" id="selected_user">
            
        </div>
    </div>
    
    
</section>

@endsection

@section('plugin-extra-js')
    <script src="{{asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugin/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/plugin/js/select2_es.js')}}"></script>
@endsection

@section('my-script')

<script>
    $(document).ready(function () {

        

        $('#user_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            language: 'es',
            dropdownParent: $("#buscar_user")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            let user_id = $(this).val();
            if (user_id){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');

                //deshabilita campos ubicacion manual
                //$('#edificio_piso').val(null).trigger("change").removeClass('is-valid is-invalid');
                //$('#numero_sala').val('').prop('disabled',true).removeClass('is-valid is-invalid');
                //$('#nombre_sala').val('').prop('disabled',true).removeClass('is-valid is-invalid');
                user_selected(user_id);

            } else {
                $(this).closest('td').next('td').find('select').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true).val('');

                $('#selected_user').hide().html('');
            }
        });
        
    });

    async function user_selected(user_id) {
        
        loader('show');
        const route = $('#route_include_buscar_user').val()+`/${user_id}`;
        try {
            const response = await fetch(route);

            if (response.redirected){
                location.replace("/login");
                throw new Error('Redireccionado');
            }
            if (!response.ok){
                throw new Error('Error response eliminar');
            }
            const data = await response.json();
            
            $('#selected_user').html(data);
            loader('hide');
            
        } catch (error) {
            loader('hide');
            console.error(error);
        }
        
    }

   
</script>

@endsection

