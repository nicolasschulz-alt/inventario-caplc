@extends('layouts.app-laravel')

@section('plugin-extra-css')
    {{-- <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css"> --}}
    <link rel="stylesheet" href="{{asset('assets/fontawesome-add/v6.6.0/css/all.css')}}">

@endsection

@section('menu-content')
    @include('menu.content.menu-content-tic')
@endsection


@section('title')
    Sistema Unidad Tic
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
    .flex-card-dash-inven a{
        color: #6b7280;
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
        color: #6b7280;
    }
    .disp-card-dash-body.active{
        color: #3a3b45;
    }
    .disp-card-dash-footer{
        color: #fff;
        border-radius: 12px;
        margin-top: 6px;
        background: linear-gradient(180deg, #6b7280, #85879691);
    }
    .disp-card-dash-footer.active{
        background: linear-gradient(180deg, #375ece, #3057c991);
    }
    .disp-card-dash-footer-extra{

    }

    .disp-card-dash-head i {
        font-size: 36px;
        height: 36px;
        width: 36px;
        color: #6b7280;
    }
    .disp-card-dash-head.active i {
        color: #4d72de;
    }
    .icon-svg-pers-dash{
        font-size: 36px;
        height: 36px;
        fill: #6b7280;
    }
    .icon-svg-pers-dash.active{
        fill: #4d72de;
    }
    .icon-svg-pers-dash.active path{
        fill: #4d72de;
    }
</style>



<section>
    
    <div>
        <h4 class="title-section-dashboard">Inventario</h4>
    </div>
    <div class="flex-card-dash-inven">
        <a href="{{route('inventario.pc')}}" class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head active">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-svg-pers-dash active" viewBox="0 0 640 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M384 96V320H64L64 96H384zM64 32C28.7 32 0 60.7 0 96V320c0 35.3 28.7 64 64 64H181.3l-10.7 32H96c-17.7 0-32 14.3-32 32s14.3 32 32 32H352c17.7 0 32-14.3 32-32s-14.3-32-32-32H377.3l-10.7-32H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm464 0c-26.5 0-48 21.5-48 48V432c0 26.5 21.5 48 48 48h64c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48H528zm16 64h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H544c-8.8 0-16-7.2-16-16s7.2-16 16-16zm-16 80c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H544c-8.8 0-16-7.2-16-16zm32 224c-17.7 0-32-14.3-32-32s14.3-32 32-32s32 14.3 32 32s-14.3 32-32 32z"/></svg>
                        </div>
                        <div class="disp-card-dash-body active">PC</div>
                        <div class="disp-card-dash-footer active" id="cantidad_pc">{{$pc}}</div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{route('inventario.impresoras')}}" class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head active">
                            <i class="fas fa-print active"></i>
                        </div>
                        <div class="disp-card-dash-body active">Impresoras</div>
                        <div class="disp-card-dash-footer active" id="cantidad_impresoras">{{$impresoras}}</div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{route('inventario.anexos')}}" class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head active">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="disp-card-dash-body active">Anexos Minsal</div>
                        <div class="disp-card-dash-footer active" id="cantidad_anexos">{{$anexos}}</div>
                    </div>
                </div>
            </div>
        </a>
        {{-- <div class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head"><i class="fas fa-fingerprint"></i></div>
                        <div class="disp-card-dash-body active">Huelleros</div>
                        <div class="disp-card-dash-footer">0</div>
                    </div>
                </div>
            </div>
        </div> --}}
        <a href="{{route('inventario.huelleros')}}" class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head active">
                            <i class="fas fa-fingerprint active"></i>
                        </div>
                        <div class="disp-card-dash-body active">Huelleros Minsal</div>
                        <div class="disp-card-dash-footer active" id="cantidad_huelleros">{{$huelleros}}</div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{route('inventario.monitores')}}" class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head active">
                            <i class="fas fa-desktop active"></i>
                        </div>
                        <div class="disp-card-dash-body active">Monitores</div>
                        <div class="disp-card-dash-footer active" id="cantidad_monitores">{{$monitores}}</div>
                    </div>
                </div>
            </div>
        </a>
        <div class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head">
                            {{-- <i class="fas fa-desktop"></i> --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-svg-pers-dash" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 36 36" version="1.1" preserveAspectRatio="xMidYMid meet">
                                <title>network-switch-solid</title>
                                <path d="M33.91,18.47,30.78,8.41A2,2,0,0,0,28.87,7H7.13A2,2,0,0,0,5.22,8.41L2.09,18.48a2,2,0,0,0-.09.59V27a2,2,0,0,0,2,2H32a2,2,0,0,0,2-2V19.06A2,2,0,0,0,33.91,18.47ZM8.92,25H7.12V22h1.8Zm5,0h-1.8V22h1.8Zm5,0h-1.8V22h1.8Zm5,0H22.1V22h1.8Zm5,0H27.1V22h1.8ZM31,19.4H5V18H31Z" class="clr-i-solid clr-i-solid-path-1"/>
                                <rect x="0" y="0" width="36" height="12" fill-opacity="0"/>
                            </svg>
                        </div>
                        <div class="disp-card-dash-body">Switch</div>
                        <div class="disp-card-dash-footer">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head">
                            
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-svg-pers-dash" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#6b7280" version="1.1" id="Layer_1" viewBox="0 0 512 512" xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M486.4,290.133h-59.733V55.467c0-7.066-5.726-12.8-12.8-12.8c-7.074,0-12.8,5.734-12.8,12.8v234.667H110.933V55.467    c0-7.066-5.726-12.8-12.8-12.8c-7.074,0-12.8,5.734-12.8,12.8v234.667H25.6c-14.14,0-25.6,11.46-25.6,25.6v128    c0,14.14,11.46,25.6,25.6,25.6h460.8c14.14,0,25.6-11.46,25.6-25.6v-128C512,301.594,500.54,290.133,486.4,290.133z     M486.4,443.733H25.6v-128h460.8V443.733z"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="311.467" cy="379.733" r="12.8"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="362.667" cy="379.733" r="12.8"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="413.867" cy="379.733" r="12.8"/>
                                    </g>
                                </g>
                                </svg>

                            
                        </div>
                        <div class="disp-card-dash-body">Router</div>
                        <div class="disp-card-dash-footer">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="icon-svg-pers-dash" viewBox="0 0 24 24" fill="none">
                                <path d="M9.2255 5.33199C8.92208 5.86298 8.93352 6.58479 9.55278 6.89443C10.3201 7.27808 10.7664 6.59927 11.1323 6.04284C11.4473 5.56389 11.8013 5.11292 12.2071 4.70711C13.0981 3.8161 14.3588 3 16 3C17.6412 3 18.9019 3.8161 19.7929 4.70711C20.1967 5.11095 20.5495 5.5595 20.8632 6.03593C21.2289 6.59127 21.6809 7.27759 22.4472 6.89443C23.0634 6.58633 23.0765 5.86043 22.7745 5.33199C22.7019 5.20497 22.5962 5.02897 22.4571 4.8203C22.1799 4.40465 21.7643 3.8501 21.2071 3.29289C20.0981 2.1839 18.3588 1 16 1C13.6412 1 11.9019 2.1839 10.7929 3.29289C10.2357 3.8501 9.82005 4.40465 9.54295 4.8203C9.40383 5.02897 9.29809 5.20497 9.2255 5.33199Z" fill="#0F0F0F"/>
                                <path d="M14.4762 6.71292C14.2768 6.90911 14.1223 7.10809 14.0182 7.2579C13.6696 7.75991 13.1966 8.23817 12.5294 7.88235C11.9766 7.58751 11.8923 6.8973 12.193 6.39806C12.2358 6.327 12.2967 6.23053 12.3755 6.1171C12.5319 5.89191 12.7649 5.59089 13.0738 5.28708C13.6809 4.68987 14.6689 4 15.9999 4C17.3309 4 18.3189 4.68986 18.9261 5.28706C19.235 5.59087 19.468 5.89188 19.6244 6.11707C19.7031 6.2305 19.764 6.32697 19.8069 6.39803C20.1082 6.8983 20.0212 7.58858 19.4705 7.88233C18.8032 8.23829 18.3304 7.76001 17.9817 7.25793C17.8776 7.10812 17.7231 6.90913 17.5236 6.71294C17.1141 6.31014 16.6021 6 15.9999 6C15.3977 6 14.8857 6.31013 14.4762 6.71292Z" fill="#0F0F0F"/>
                                <path d="M5 18C4.44772 18 4 18.4477 4 19C4 19.5523 4.44772 20 5 20C5.55228 20 6 19.5523 6 19C6 18.4477 5.55228 18 5 18Z" fill="#0F0F0F"/>
                                <path d="M7 19C7 18.4477 7.44771 18 8 18C8.55229 18 9 18.4477 9 19C9 19.5523 8.55229 20 8 20C7.44771 20 7 19.5523 7 19Z" fill="#0F0F0F"/>
                                <path d="M10 19C10 18.4477 10.4477 18 11 18C11.5523 18 12 18.4477 12 19C12 19.5523 11.5523 20 11 20C10.4477 20 10 19.5523 10 19Z" fill="#0F0F0F"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15 8C15 7.44771 15.4477 7 16 7C16.5523 7 17 7.44771 17 8V15H20C21.6569 15 23 16.3431 23 18V20C23 21.6569 21.6569 23 20 23H4C2.34315 23 1 21.6569 1 20V18C1 16.3431 2.34315 15 4 15H15V8ZM20 17C20.5523 17 21 17.4477 21 18V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V18C3 17.4477 3.44772 17 4 17H20Z" fill="#0F0F0F"/>
                            </svg> --}}
                            <i class="fa-solid fa-router"></i>
                        </div>
                        <div class="disp-card-dash-body">AP</div>
                        <div class="disp-card-dash-footer">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-svg-pers-dash" version="1.0" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">

                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#6b7280" stroke="none">
                                <path d="M323 3675 c-152 -41 -269 -158 -309 -309 -20 -74 -20 -1247 0 -1321 19 -74 52 -132 107 -190 89 -94 197 -135 356 -135 l93 0 0 -114 c0 -106 2 -115 24 -139 44 -48 108 -48 152 0 22 24 24 33 24 139 l0 114 1784 0 1783 0 5 -107 c5 -119 14 -145 58 -168 38 -19 65 -19 100 2 42 24 50 53 50 168 l0 105 93 0 c159 0 267 41 356 135 57 60 85 111 106 192 23 86 22 1231 0 1318 -42 158 -168 281 -323 314 -38 8 -654 11 -2230 10 -1843 0 -2185 -2 -2229 -14z m4441 -207 c53 -16 121 -84 135 -134 16 -58 15 -1203 -1 -1258 -16 -53 -81 -118 -134 -134 -60 -18 -4348 -18 -4408 0 -53 16 -121 84 -135 134 -15 54 -15 1204 0 1258 13 47 82 118 129 133 53 17 4357 18 4414 1z"/>
                                <path d="M4160 3115 c-119 -34 -212 -111 -268 -223 -36 -74 -37 -79 -37 -187 0 -108 1 -113 38 -187 156 -316 601 -313 757 6 29 58 35 82 38 156 5 107 -12 172 -67 257 -45 70 -125 135 -202 164 -70 27 -189 33 -259 14z m188 -211 c147 -61 179 -261 58 -361 -92 -76 -204 -69 -288 17 -58 61 -77 128 -54 202 20 67 49 103 108 132 60 30 121 34 176 10z"/>
                                <path d="M583 3060 c-50 -30 -55 -65 -51 -378 3 -293 5 -301 52 -333 18 -12 191 -14 1069 -17 721 -2 1061 1 1088 8 28 8 46 21 59 43 19 30 20 52 20 320 0 238 -3 293 -15 317 -33 63 30 60 -1132 60 -1031 0 -1059 -1 -1090 -20z m2027 -355 l0 -165 -935 0 -935 0 0 165 0 165 935 0 935 0 0 -165z"/>
                                <path d="M3164 2776 c-51 -51 -43 -119 18 -156 47 -29 228 -29 274 -1 46 28 61 80 37 128 -26 54 -51 63 -181 63 l-114 0 -34 -34z"/>
                                </g>
                            </svg>
                        </div>
                        <div class="disp-card-dash-body">NVR/DVR</div>
                        <div class="disp-card-dash-footer">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head">
                            
                            <i class="fa-solid fa-camera-web"></i>
                        </div>
                        <div class="disp-card-dash-body">Videoconferencias</div>
                        <div class="disp-card-dash-footer">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-svg-pers-dash" viewBox="0 0 576 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 128C0 92.7 28.7 64 64 64l256 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2l0 256c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1l0-17.1 0-128 0-17.1 14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"/></svg>
                        </div>
                        <div class="disp-card-dash-body">Cámaras</div>
                        <div class="disp-card-dash-footer">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head"><i class="fa-solid fa-server"></i></div>
                        <div class="disp-card-dash-body">Servidores</div>
                        <div class="disp-card-dash-footer">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head"><i class="fas fa-tv"></i></div>
                        <div class="disp-card-dash-body">TV</div>
                        <div class="disp-card-dash-footer">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head"><i class="fa-solid fa-projector"></i></div>
                        <div class="disp-card-dash-body">Proyector</div>
                        <div class="disp-card-dash-footer">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head"><i class="fa-solid fa-laptop"></i></div>
                        <div class="disp-card-dash-body">Notebook</div>
                        <div class="disp-card-dash-footer">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head"><i class="fa-solid fa-tablet"></i></div>
                        <div class="disp-card-dash-body">Tablets</div>
                        <div class="disp-card-dash-footer">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head"><i class="fa-solid fa-mobile"></i></div>
                        <div class="disp-card-dash-body">Celulares</div>
                        <div class="disp-card-dash-footer">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-inven card shadow mb-4 mr-2">
            <div class="card-body-dashboard-inven card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="disp-card-dash-head"><i class="fa-solid fa-mobile"></i></div>
                        <div class="disp-card-dash-body">Relojes</div>
                        <div class="disp-card-dash-footer">0</div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

<section>
    <div>
        <h4 class="title-section-dashboard">{{-- Otras secciones --}}</h4>
    </div>
</section>

@endsection

@section('my-script')
    <script>
        $(document).ready(function () {
            //loader('show');
        });

    </script>

@endsection

