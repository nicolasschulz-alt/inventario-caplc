@extends('layouts.app-laravel')

@section('plugin-extra-css')
    <link href="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugin/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/plugin/css/select2-bootstrap4.min.css')}}" rel="stylesheet"/>
    {{-- <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css"> --}}
    <link rel="stylesheet" href="{{asset('assets/fontawesome-add/v6.6.0/css/all.css')}}">
    
@endsection

@section('menu-content')
    @include('menu.content.menu-content-tic')
@endsection

@section('title')
    Sistema de Inventario
@endsection

@section('title-content')
    Inventario
@endsection

@section('after-text-title-content')
    
@endsection

@section('content')
    <style>
        #tablaListadoImpresora_wrapper th{
            text-align: center !important;
        }
        #tablaListadoImpresora td{
            text-align: center !important;
        }
        .detalle-listado-impresora,
        .editar-listado-impresora
        {
            white-space: nowrap;
        }

        #body_modal_detalle_impresora table td{
            /* color: #333;
            font-weight: 600; */
        }
        
    </style>

   
   
   
    <div class="row">
        <div class="col-md-12 col-sm-12 text-right mb-4">

            <button type="button" class="btn btn-info mr-4" id="btnReporteImpresoraExcel" style="min-width: 6%;" route="{{ route('inventario.impresora_export_excel') }}">
                <i class="fas fa-file-excel fa-sm"></i> <span>Reporte</span>
            </button>
        
            <button type="button" id="crear_impresora" route="{{ route('inventario.include_formulario_impresora_crear') }}" class="btn btn-success" style="min-width: 6%;" data-toggle="modal" {{-- data-target="#modal_registrar_impresora" --}}>
                <i class="fas fa-print"></i> <span>Crear</span>
            </button>

        </div>
        <div class="col-md-12 col-sm-12">

            <div class="modal fade" id="modal_registrar_impresora"  {{-- tabindex="-1" --}} aria-labelledby="modalRegistrarImpresoraLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header px-4 text-center">
                            <h5 class="modal-title h4" id="modalRegistrarImpresoraLabel">Registrar Impresora</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body p-4" id="body_modal_registrar_impresora">
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-12 col-sm-12">

            <div class="modal fade" id="modal_detalle_impresora"  {{-- tabindex="-1" --}} aria-labelledby="modalDetalleImpresoraLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header px-4 text-center">
                            <h5 class="modal-title h4" id="modalDetalleImpresoraLabel">Detalle Impresora</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body p-4" id="body_modal_detalle_impresora">
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-12 col-sm-12">

            <div class="modal fade" id="modal_editar_impresora"  {{-- tabindex="-1" --}} aria-labelledby="modalEditarImpresoraLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header px-4 text-center">
                            <h5 class="modal-title h4" id="modalEditarImpresoraLabel">Editar Impresora</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body p-4" id="body_modal_editar_impresora">
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
    </div>

    <div class="card shadow mb-4" id="listado_impresora">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado Impresoras</h6>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <input type="hidden" id="route_impresora_delete" value="{{route('inventario.impresora_delete')}}">
                    <input type="hidden" id="route_include_detalle_impresora" value="{{route('inventario.include_detalle_impresora')}}">
                    <input type="hidden" id="route_impresora_editar" value="{{route('inventario.impresora_update')}}">
                    <input type="hidden" id="route_include_editar_impresora" value="{{route('inventario.include_formulario_impresora_editar')}}">
                    <input type="hidden" id="route_obtener_salas_por_edificio_piso" value="{{ route('inventario.obtener_salas_por_edificio_piso') }}">
                    <input type="hidden" id="route_obtener_modelos_por_tipo" value="{{ route('inventario.obtener_modelos_por_tipo') }}">
                    <input type="hidden" id="route_obtener_modelos_por_tipo_marca" value="{{ route('inventario.obtener_modelos_por_tipo_marca') }}">
                    <input type="hidden" id="route_obtener_marca_por_modelo" value="{{ route('inventario.obtener_marca_por_modelo') }}">
                    <div id="listadoImpresora" route="{{route('inventario.impresora_list')}}">
                        
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
        /* $(document).on('select2:open', function(e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }); */
        $(document).ready(function() {

            cargarVistaTablaListadoImpresora();
            

            $('#crear_impresora').on('click', function (event) {
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
                        print_swal_status(response.status);
                        throw new Error('Error al hacer peticion');
                    }
                    return response.json();
                })
                .then(data => {
                    
                    $('#body_modal_registrar_impresora').html(data);

                    //setTimeout(() => {

                        //loader('hide');

                        $('#modal_registrar_impresora').modal({
                            keyboard: false,
                            backdrop: 'static'
                        }).modal('show');

                    //}, 200);

                    //const modalContent = document.querySelector('#body_modal_registrar_impresora');
                    //modalContent.innerHTML = data; // Insertar el HTML en el modal
                    //$('#modal_registrar_impresora').modal('show'); // Mostrar el modal
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

            $('#btnReporteImpresoraExcel').on('click', async function (event) {
                event.preventDefault();
                const $btn = $(this);
                $btn.prop('disabled', true);

                const ruta = $btn.attr('route');
                //loader('show');
                try {
                    const response = await fetch(ruta);
                    if (!response.ok) throw new Error('Error en la descarga');

                    const blob = await response.blob();

                    // Usa el filename del header, si quieres
                    const a = document.createElement('a');
                    const url = window.URL.createObjectURL(blob);
                    a.href = url;
                    a.download = 'impresora_reporte.xlsx'; // También puedes parsear Content-Disposition si deseas
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                    /* Swal.fire({
                        title: "Reporte generado",
                        text: "",
                        icon: "success"
                    }); */
                    print_swal_toast_msg('Reporte generado',3000);
                } catch (err) {
                    console.error('Error al descargar el archivo:', err);
                    Swal.fire({
                        icon: "error",
                        title: "Error de descarga",
                        text: "-Hubo un error al descargar el archivo"
                    });
                } finally {
                    console.log('finally');
                    //loader('hide');
                    $btn.prop('disabled', false);
                }
            });

            

        }).on('keydown', function(event) {
            if (event.key === "Escape" || event.keyCode === 27) {
                $('#modal_detalle_impresora').modal('hide');
            }
        });

        async function cargarVistaTablaListadoImpresora(){

            loader('show');

            const div = document.getElementById('listadoImpresora');
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

                $('#listadoImpresora').html(data);

                setTimeout(() => {
                    loader('hide');
                }, 500);
                
            } catch (error) {
                loader('hide');
                console.error(error);
            }

        }
    </script>
@endsection
