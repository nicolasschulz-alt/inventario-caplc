<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- {{ __('Dashboard') }} --}}
            Sistemas
        </h2>
    </x-slot>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/fontawesome-add/v6.6.0/css/all.css')}}">

    <!-- Custom styles for this template-->
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100" style="display: flex;flex-wrap: wrap;">
                    {{-- {{ __("You're logged in!") }} --}}
                    {{-- Estás logeado! --}}
                    <style>

                        .modulo-sistema-activo {
                            -webkit-text-size-adjust: 100%;
                            text-align: center;
                            tab-size: 4;
                            font-feature-settings: normal;
                            font-variation-settings: normal;
                            -webkit-tap-highlight-color: transparent;
                            font-family: Figtree, ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", Segoe UI Symbol, "Noto Color Emoji";
                            -webkit-font-smoothing: antialiased;
                            box-sizing: border-box;
                            border-style: solid;
                            --tw-border-spacing-x: 0;
                            --tw-border-spacing-y: 0;
                            --tw-translate-x: 0;
                            --tw-translate-y: 0;
                            --tw-rotate: 0;
                            --tw-skew-x: 0;
                            --tw-skew-y: 0;
                            --tw-scale-x: 1;
                            --tw-scale-y: 1;
                            --tw-pan-x: ;
                            --tw-pan-y: ;
                            --tw-pinch-zoom: ;
                            --tw-scroll-snap-strictness: proximity;
                            --tw-gradient-from-position: ;
                            --tw-gradient-via-position: ;
                            --tw-gradient-to-position: ;
                            --tw-ordinal: ;
                            --tw-slashed-zero: ;
                            --tw-numeric-figure: ;
                            --tw-numeric-spacing: ;
                            --tw-numeric-fraction: ;
                            --tw-ring-inset: ;
                            --tw-ring-offset-width: 0px;
                            --tw-ring-offset-color: #fff;
                            --tw-ring-color: rgb(59 130 246 / .5);
                            --tw-ring-offset-shadow: 0 0 #0000;
                            --tw-ring-shadow: 0 0 #0000;
                            --tw-shadow: 0 0 #0000;
                            --tw-shadow-colored: 0 0 #0000;
                            --tw-blur: ;
                            --tw-brightness: ;
                            --tw-contrast: ;
                            --tw-grayscale: ;
                            --tw-hue-rotate: ;
                            --tw-invert: ;
                            --tw-saturate: ;
                            --tw-sepia: ;
                            --tw-drop-shadow: ;
                            --tw-backdrop-blur: ;
                            --tw-backdrop-brightness: ;
                            --tw-backdrop-contrast: ;
                            --tw-backdrop-grayscale: ;
                            --tw-backdrop-hue-rotate: ;
                            --tw-backdrop-invert: ;
                            --tw-backdrop-opacity: ;
                            --tw-backdrop-saturate: ;
                            --tw-backdrop-sepia: ;
                            --tw-contain-size: ;
                            --tw-contain-layout: ;
                            --tw-contain-paint: ;
                            --tw-contain-style: ;
                            text-decoration: inherit;
                            display: flex;
                            border-radius: .375rem;
                            border-width: 1px;
                            border-color: transparent;
                            --tw-bg-opacity: 1;
                            padding-left: 1.5rem;
                            padding-right: 1.5rem;
                            padding-top: .5rem;
                            padding-bottom: .5rem;
                            font-size: .75rem;
                            line-height: 1rem;
                            font-weight: 600;
                            text-transform: uppercase;
                            letter-spacing: .1em;
                            --tw-text-opacity: 1;
                            color: rgb(255 255 255 / var(--tw-text-opacity));
                            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-backdrop-filter;
                            transition-duration: .15s;
                            transition-timing-function: cubic-bezier(.4,0,.2,1);
                            margin: 8px 12px;
                            height: 130px;
                            width: 260px;
                            background-color: rgb(99 102 241 / 1);
                            align-items: center;
                            flex-direction: column;
                            justify-content: center;
                        }
                        .modulo-sistema-inactivo{
                            -webkit-text-size-adjust: 100%;
                            tab-size: 4;
                            font-feature-settings: normal;
                            font-variation-settings: normal;
                            -webkit-tap-highlight-color: transparent;
                            font-family: Figtree, ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", Segoe UI Symbol, "Noto Color Emoji";
                            -webkit-font-smoothing: antialiased;
                            box-sizing: border-box;
                            border-style: solid;
                            --tw-border-spacing-x: 0;
                            --tw-border-spacing-y: 0;
                            --tw-translate-x: 0;
                            --tw-translate-y: 0;
                            --tw-rotate: 0;
                            --tw-skew-x: 0;
                            --tw-skew-y: 0;
                            --tw-scale-x: 1;
                            --tw-scale-y: 1;
                            --tw-pan-x: ;
                            --tw-pan-y: ;
                            --tw-pinch-zoom: ;
                            --tw-scroll-snap-strictness: proximity;
                            --tw-gradient-from-position: ;
                            --tw-gradient-via-position: ;
                            --tw-gradient-to-position: ;
                            --tw-ordinal: ;
                            --tw-slashed-zero: ;
                            --tw-numeric-figure: ;
                            --tw-numeric-spacing: ;
                            --tw-numeric-fraction: ;
                            --tw-ring-inset: ;
                            --tw-ring-offset-width: 0px;
                            --tw-ring-offset-color: #fff;
                            --tw-ring-color: rgb(59 130 246 / .5);
                            --tw-ring-offset-shadow: 0 0 #0000;
                            --tw-ring-shadow: 0 0 #0000;
                            --tw-shadow: 0 0 #0000;
                            --tw-shadow-colored: 0 0 #0000;
                            --tw-blur: ;
                            --tw-brightness: ;
                            --tw-contrast: ;
                            --tw-grayscale: ;
                            --tw-hue-rotate: ;
                            --tw-invert: ;
                            --tw-saturate: ;
                            --tw-sepia: ;
                            --tw-drop-shadow: ;
                            --tw-backdrop-blur: ;
                            --tw-backdrop-brightness: ;
                            --tw-backdrop-contrast: ;
                            --tw-backdrop-grayscale: ;
                            --tw-backdrop-hue-rotate: ;
                            --tw-backdrop-invert: ;
                            --tw-backdrop-opacity: ;
                            --tw-backdrop-saturate: ;
                            --tw-backdrop-sepia: ;
                            --tw-contain-size: ;
                            --tw-contain-layout: ;
                            --tw-contain-paint: ;
                            --tw-contain-style: ;
                            text-decoration: inherit;
                            display: flex;
                            border-radius: .375rem;
                            border-width: 1px;
                            border-color: transparent;
                            --tw-bg-opacity: 1;
                            background-color: rgb(107 114 128 / var(--tw-bg-opacity));
                            padding-left: 1.5rem;
                            padding-right: 1.5rem;
                            padding-top: .5rem;
                            padding-bottom: .5rem;
                            font-size: .75rem;
                            line-height: 1rem;
                            font-weight: 600;
                            text-transform: uppercase;
                            letter-spacing: .1em;
                            --tw-text-opacity: 1;
                            color: rgb(255 255 255 / var(--tw-text-opacity));
                            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-backdrop-filter;
                            transition-duration: .15s;
                            transition-timing-function: cubic-bezier(.4,0,.2,1);
                            margin: 8px 12px;
                            height: 130px;
                            width: 260px;
                            align-items: center;
                            flex-direction: column;
                            justify-content: center;
                        }

                        small{
                            /* color: #000000; */
                            font-weight: normal;
                        }
                        .modulo-sistema:hover{
                            cursor: pointer;
                        }

                    </style>
                    @php
                        $ruta = '';
                        $icono = '';
                        foreach ($sistemas_user as $value) {
                            /* 
                            
                            RECORDAR LISTAR SISTEMAS A LOS QUE SE TIENE ACCESSO 
                            TENIENDO EN CUENTAS LOS PERMISOS QUE TIENE EL USUARIO 
                            Y A LOS QUE NO TENGA PERMISOS MOSTRARLOS IGUALMENTE PERO DE OTRO COLOR Y DESHABILITADO
                            
                            */

                            switch ($value->sistema_id) {
                                case 1: // MODULO UNIDAD TIC
                                    $ruta = route('tic.index');
                                    $icono = '<i class="fa-solid fa-computer"></i>';
                                    break;
                                case 2: // GESTION USUARIOS
                                    $ruta = route('usuario.index');
                                    $icono = '<i class="fa-solid fa-user-shield"></i>';
                                    break;
                                case 3: //EQUIPOS MEDICOS
                                    $ruta = 'javascript:void(0)';
                                    $icono = '<i class="fa-solid fa-suitcase-medical"></i>';
                                    break;
                                case 4: //CALIDAD
                                    $ruta = 'javascript:void(0)';
                                    $icono = '<i class="fa-solid fa-clipboard-check"></i>';
                                    break;
                                case 5://INTRANET
                                    $ruta = 'javascript:void(0)';
                                    $icono = '<i class="fa-solid fa-network-wired"></i>';
                                    break;
                                case 6://CONTROL CENTRALIZADO
                                    $ruta = 'javascript:void(0)';
                                    $icono = '<i class="fa-solid fa-walkie-talkie"></i>';
                                    break;
                                case 7://MANTENIMIENTO
                                    $ruta = 'javascript:void(0)';
                                    $icono = '<i class="fa-solid fa-screwdriver-wrench"></i>';
                                    break;
                                default:
                                    $ruta = 'javascript:void(0)';
                                    $icono = '<i class="fa-solid fa-circle-question"></i>';
                                    break;
                            }

                            if ($value->acceso == true){
                                //echo '<a href="'.$ruta.'" style="background-color: rgb(59 130 246 / var(--tw-bg-opacity, 1));" class="py-2 px-3 bg-blue-500 text-white text-sm font-semibold rounded-md shadow-lg shadow-blue-500/50 focus:outline-none">'.$value->nombre_sistema.'</a>';
                                echo '  <div class="modulo-sistema modulo-sistema-activo" route="'.$ruta.'" >
                                            <div style="font-size: 20px;padding-bottom: 10px;">'.$icono.'</div>
                                            <div style="font-size: 16px;padding-bottom: 2px;">' . $value->nombre_sistema.'</div>
                                            <div style=""><small>Perfil: '.$value->nombre_rol.' </small></div>
                                        </div>';
                            } else {
                                
                                //echo '<div class="modulo-sistema modulo-sistema-inactivo" route="javascript:void(0);">' . $icono . '&nbsp;' . $value->nombre_sistema.'</a>';
                                echo '  <div class=" modulo-sistema-inactivo" route="'.$ruta.'" >
                                        <div style="font-size: 20px;padding-bottom: 10px;">'.$icono.'</div>
                                        <div style="font-size: 16px;padding-bottom: 2px;text-align: center;">' . $value->nombre_sistema.'</div>
                                        <div style=""><small>Modulo Inactivo</small></div>
                                    </div>';
                            }

                        }
                    @endphp
                    {{-- <a href="{{route($ruta)}}" class="inline-flex items-center px-6 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Modulo Unidad TIC</a> --}}                                    
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
        <script>
            $(document).ready(function () {

                $('.modulo-sistema').on('click', function () {
                    const route = $(this).attr('route');
                    console.log(route);
                    location.href = route;
                });

            });
        </script>
    </div>
</x-app-layout>

