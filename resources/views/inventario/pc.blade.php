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
        #tablaListadoPc_wrapper th{
            text-align: center !important;
        }
        #tablaListadoPc td{
            text-align: center !important;
        }
        .detalle-listado-pc,
        .editar-listado-pc
        {
            white-space: nowrap;
        }

        #body_modal_detalle_pc table td{
            /* color: #333;
            font-weight: 600; */
        }
        
    </style>

   
   
   
    <div class="row">
        <div class="col-md-12 col-sm-12 text-right mb-4">

            <button type="button" class="btn btn-info mr-4" id="btnReportePcExcel" style="min-width: 6%;" route="{{ route('inventario.pc_export_excel') }}">
                <i class="fas fa-file-excel fa-sm"></i> <span>Reporte</span>
            </button>
        
            <button type="button" id="crear_pc" route="{{ route('inventario.include_formulario_pc_crear') }}" class="btn btn-success" style="min-width: 6%;" data-toggle="modal" {{-- data-target="#modal_registrar_pc" --}}>
                <i class="fas fa-computer fa-sm"></i> <span>Crear</span>
            </button>

        </div>
        <div class="col-md-12 col-sm-12">

            <div class="modal fade" id="modal_registrar_pc"  {{-- tabindex="-1" --}} aria-labelledby="modalRegistrarPcLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header px-4 text-center">
                            <h5 class="modal-title h4" id="modalRegistrarPcLabel">Registrar PC</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body p-4" id="body_modal_registrar_pc">
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-12 col-sm-12">

            <div class="modal fade" id="modal_detalle_pc"  {{-- tabindex="-1" --}} aria-labelledby="modalDetallePcLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header px-4 text-center">
                            <h5 class="modal-title h4" id="modalDetallePcLabel">Detalle PC</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body p-4" id="body_modal_detalle_pc">
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-12 col-sm-12">

            <div class="modal fade" id="modal_editar_pc"  {{-- tabindex="-1" --}} aria-labelledby="modalEditarPcLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header px-4 text-center">
                            <h5 class="modal-title h4" id="modalEditarPcLabel">Editar PC</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body p-4" id="body_modal_editar_pc">
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
    </div>

    <div class="card shadow mb-4" id="listado_pc">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado PC</h6>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <input type="hidden" id="route_pc_delete" value="{{route('inventario.pc_delete')}}">
                    <input type="hidden" id="route_include_detalle_pc" value="{{route('inventario.include_detalle_pc')}}">
                    <input type="hidden" id="route_pc_editar" value="{{route('inventario.pc_update')}}">
                    <input type="hidden" id="route_include_editar_pc" value="{{route('inventario.include_formulario_pc_editar')}}">
                    <input type="hidden" id="route_obtener_salas_por_edificio_piso" value="{{ route('inventario.obtener_salas_por_edificio_piso') }}">
                    <input type="hidden" id="route_obtener_modelos_por_tipo_marca" value="{{ route('inventario.obtener_modelos_por_tipo_marca') }}">
                    <div id="listadoPc" route="{{route('inventario.pc_list')}}">
                        
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

            cargarVistaTablaListadoPc();

            $('#crear_pc').on('click', function (event) {
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
                    
                    $('#body_modal_registrar_pc').html(data);

                    //setTimeout(() => {

                        //loader('hide');

                        $('#modal_registrar_pc').modal({
                            keyboard: false,
                            backdrop: 'static'
                        }).modal('show');

                    //}, 200);

                    //const modalContent = document.querySelector('#body_modal_registrar_pc');
                    //modalContent.innerHTML = data; // Insertar el HTML en el modal
                    //$('#modal_registrar_pc').modal('show'); // Mostrar el modal
                })
                .catch(error => {
                    //loader('hide');
                    console.error('Error:', error);
                })
                .finally(() => {
                    console.log('finaliza');
                    $(this).prop('disabled', false);
                });
            });

            $('#btnReportePcExcel').on('click', async function (event) {
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
                    a.download = 'pc_reporte.xlsx'; // También puedes parsear Content-Disposition si deseas
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
                $('#modal_detalle_pc').modal('hide');
            }
        });

        async function cargarVistaTablaListadoPc(){

            loader('show');

            const div = document.getElementById('listadoPc');
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

                $('#listadoPc').html(data);

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
