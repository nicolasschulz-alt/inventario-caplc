@extends('layouts.app-laravel')

@section('plugin-extra-css')
    <link href="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugin/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/plugin/css/select2-bootstrap4.min.css')}}" rel="stylesheet"/>
    {{-- <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css"> --}}
    <link href="{{ asset('assets/fontawesome-add/v6.6.0/css/all.css') }}" rel="stylesheet" type="text/css">
    
@endsection

@section('menu-content')
    @include('menu.content.menu-content-tic')
@endsection

@section('title')
    Sistema de Inventario
@endsection

@section('title-content')
    Mantenedor Ubicaciones
@endsection

@section('after-text-title-content')
    
@endsection

@section('content')
    <style>
        #tablaListadoUbicacion_wrapper th{
            text-align: center !important;
        }
        #tablaListadoUbicacion td{
            text-align: center !important;
        }
        .detalle-listado-ubicacion,
        .editar-listado-ubicacion
        {
            white-space: nowrap;
        }
        .list-group-item{
            padding: 0.3rem 1.25rem !important;
        }
    </style>


    <div class="row">

        <div class="col-md-12 col-sm-12 text-right mb-4">
        
            <button type="button" id="crear_ubicacion" route="{{ route('inventario.mantenedor.include_formulario_ubicacion_crear') }}" class="btn btn-success" style="min-width: 6%;" data-toggle="modal" {{-- data-target="#modal_registrar_anexo" --}}>
                <i class="fas fa-building"></i> <span>Crear</span>
            </button>

        </div>

        <div class="col-md-12 col-sm-12">

            <div class="modal fade" id="modal_registrar_ubicacion"  {{-- tabindex="-1" --}} aria-labelledby="modalRegistrarUbicacionLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header px-4 text-center">
                            <h5 class="modal-title h4" id="modalRegistrarUbicacionLabel">Registrar Ubicación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body p-4" id="body_modal_registrar_ubicacion">
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
        <div class="col-md-12 col-sm-12">

            <div class="modal fade" id="modal_editar_ubicacion"  {{-- tabindex="-1" --}} aria-labelledby="modalEditarUbicacionLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header px-4 text-center">
                            <h5 class="modal-title h4" id="modalEditarUbicacionLabel">Editar Ubicación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body p-4" id="body_modal_editar_ubicacion">
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-12 col-sm-12">

            <div class="card shadow mb-4" id="listado_impresora">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Listado Ubicaciones</h6>
                </div>
                <div class="card-body">
        
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                           
                            <input type="hidden" id="route_ubicacion_editar" value="{{route('inventario.mantenedor.ubicacion_update')}}">
                            <input type="hidden" id="route_include_editar_ubicacion" value="{{route('inventario.mantenedor.include_formulario_ubicacion_editar')}}">
                            <input type="hidden" id="route_obtener_salas_por_edificio_piso" value="{{ route('inventario.obtener_salas_por_edificio_piso') }}">
                            <input type="hidden" id="route_obtener_modelos_por_tipo_marca" value="{{ route('inventario.obtener_modelos_por_tipo_marca') }}">

                            <div id="listadoUbicacion" route="{{route('inventario.mantenedor.ubicacion_list')}}">
                                
                            </div>
                        </div>
                    </div>
        
                </div>
            </div>

        </div>


    </div>  

    

@endsection

@section('plugin-extra-js')
    <script src="{{asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugin/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/plugin/js/select2_es.js')}}"></script>
    

    <!-- Incluye jQuery -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <!-- Incluye el JS de Select2 -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

@endsection

@section('my-script')
    <script>
        $(document).ready(function() {

            cargarVistaTablaListadoUbicacion();

            $('#crear_ubicacion').on('click', function (event) {
                event.preventDefault();

                //loader('show');
                $(this).prop('disabled', true);

                const route = this.getAttribute('route');
                
                fetch(route)
                .then(response => {
                    console.log(response);
                    if (response.redirected){
                        location.replace("/login");
                        throw new Error('Redireccionado');
                    }
                    if (!response.ok) {
                        throw new Error('Error al hacer peticion');
                    }
                    return response.json();
                })
                .then(data => {
                    
                    $('#body_modal_registrar_ubicacion').html(data);

                    //setTimeout(() => {

                        //loader('hide');

                        $('#modal_registrar_ubicacion').modal({
                            keyboard: false,
                            backdrop: 'static'
                        }).modal('show');

                    //}, 1000);

                    //const modalContent = document.querySelector('#body_modal_registrar_ubicacion');
                    //modalContent.innerHTML = data; // Insertar el HTML en el modal
                    //$('#modal_registrar_ubicacion').modal('show'); // Mostrar el modal
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

        async function cargarVistaTablaListadoUbicacion(){

            loader('show');

            const div = document.getElementById('listadoUbicacion');
            const route = div.getAttribute('route');

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

                $('#listadoUbicacion').html(data);

                setTimeout(() => {
                    loader('hide');
                }, 1000);
                
            } catch (error) {
                loader('hide');
                console.error(error);
            }

        }

            
    </script>
@endsection
