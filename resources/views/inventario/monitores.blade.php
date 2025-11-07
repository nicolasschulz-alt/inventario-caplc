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
        #tablaListadoMonitor_wrapper th{
            text-align: center !important;
        }
        #tablaListadoMonitor td{
            text-align: center !important;
        }
        .detalle-listado-monitor,
        .editar-listado-monitor
        {
            white-space: nowrap;
        }

        #body_modal_detalle_monitor table td{
            /* color: #333;
            font-weight: 600; */
        }
        
    </style>

   
   
   
    <div class="row">
        <div class="col-md-12 col-sm-12 text-right mb-4">

            <button type="button" class="btn btn-info mr-4" id="btnReporteMonitorExcel" style="min-width: 6%;" route="{{ route('inventario.monitor_export_excel') }}">
                <i class="fas fa-file-excel fa-sm"></i> <span>Reporte</span>
            </button>
        
            <button type="button" id="crear_monitor" route="{{ route('inventario.include_formulario_monitor_crear') }}" class="btn btn-success" style="min-width: 6%;" data-toggle="modal">
                <i class="fas fa-desktop"></i> <span>Crear</span>
            </button>

        </div>
        <div class="col-md-12 col-sm-12">

            <div class="modal fade" id="modal_registrar_monitor"  {{-- tabindex="-1" --}} aria-labelledby="modalRegistrarMonitorLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header px-4 text-center">
                            <h5 class="modal-title h4" id="modalRegistrarMonitorLabel">Registrar Monitor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body p-4" id="body_modal_registrar_monitor">
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-12 col-sm-12">

            <div class="modal fade" id="modal_detalle_monitor"  {{-- tabindex="-1" --}} aria-labelledby="modalDetalleMonitorLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header px-4 text-center">
                            <h5 class="modal-title h4" id="modalDetalleMonitorLabel">Detalle Monitor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body p-4" id="body_modal_detalle_monitor">
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-12 col-sm-12">

            <div class="modal fade" id="modal_editar_monitor"  {{-- tabindex="-1" --}} aria-labelledby="modalEditarMonitorLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header px-4 text-center">
                            <h5 class="modal-title h4" id="modalEditarMonitorLabel">Editar Monitor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body p-4" id="body_modal_editar_monitor">
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
    </div>

    <div class="card shadow mb-4" id="listado_monitor">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado Monitores</h6>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-12 col-sm-12">
                     <input type="hidden" id="route_monitor_delete" value="{{route('inventario.monitor_delete')}}">
                    <input type="hidden" id="route_include_detalle_monitor" value="{{route('inventario.include_detalle_monitor')}}">
                    <input type="hidden" id="route_monitor_editar" value="{{route('inventario.monitor_update')}}">
                    <input type="hidden" id="route_include_editar_monitor" value="{{route('inventario.include_formulario_monitor_editar')}}">
                    <input type="hidden" id="route_obtener_salas_por_edificio_piso" value="{{ route('inventario.obtener_salas_por_edificio_piso') }}"> 
                    <input type="hidden" id="route_obtener_modelos_por_tipo" value="{{ route('inventario.obtener_modelos_por_tipo') }}">
                    <input type="hidden" id="route_obtener_modelos_por_tipo_marca" value="{{ route('inventario.obtener_modelos_por_tipo_marca') }}">
                    <input type="hidden" id="route_obtener_marca_por_modelo" value="{{ route('inventario.obtener_marca_por_modelo') }}">
                    <div id="listadoMonitor" route="{{route('inventario.monitor_list')}}"></div>
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

@endsection

@section('my-script')
    <script>
        $(document).ready(function() {

            cargarVistaTablaListadoMonitor();

            $('#crear_monitor').on('click', function (event) {
                event.preventDefault();

                //loader('show');
                $(this).prop('disabled', true);

                //alert(0);
                const route = this.getAttribute('route');
                
                console.log(route);
                
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
                    
                    $('#body_modal_registrar_monitor').html(data);

                    //setTimeout(() => {

                        //loader('hide');

                        $('#modal_registrar_monitor').modal({
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

            $('#btnReporteMonitorExcel').on('click', async function (event) {
                /* event.preventDefault();
                let ruta = $(this).attr('route');
                window.location.href = ruta;
                $(this).prop('disabled',true);
                setTimeout(() => {
                    $(this).prop('disabled',false);
                }, 2000); */
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
                    a.download = 'monitor_reporte.xlsx'; // También puedes parsear Content-Disposition si deseas
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                    //loader('hide');
                    /* Swal.fire({
                        title: "Reporte generado",
                        text: "",
                        icon: "success"
                    }); */
                    print_swal_toast_msg('Reporte generado',3000);
                } catch (err) {
                    console.error('Error al descargar el archivo:', err);
                    //loader('hide');
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
                $('#modal_detalle_monitor').modal('hide');
            }
        });

        async function cargarVistaTablaListadoMonitor(){

            loader('show');

            const div = document.getElementById('listadoMonitor');
            const route = div.getAttribute('route');

            //try {
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

                $('#listadoMonitor').html(data);

                setTimeout(() => {
                    loader('hide');
                }, 500);
                
            /* } catch (error) {
                loader('hide');
                console.error(error);
            } */

        }
    </script>
@endsection
