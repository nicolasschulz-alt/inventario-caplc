

  <div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <table class="table mb-0 table-striped table-condensed">
            <tbody>
                <tr>
                    <th class="w-30 text-primary">ID:</th>
                    <td class="text_black">{{$data->pc_id}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Serie:</th>
                    <td class="text_black">{{$data->serie ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Número Inventario:</th>
                    <td class="text_black">
                        @if (isset($data->num_inventario) && !empty($data->num_inventario))
                            {{$data->num_inventario}}
                        @else
                            {{ "--" }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">IP:</th>
                    <td class="text_black">
                        @if (isset($data->direccion_ip) && !empty($data->direccion_ip))
                            {{$data->direccion_ip}}
                        @else
                            {{ "--" }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Estado:</th>
                    
                    @if (isset($data->estado_id))

                        @if ($data->estado_id == 1)
                            <td class="text_black"><span class="badge badge-success p-1"  style="font-size: .875rem;">{{$data->estado_dispositivo}}</span></td>
                        @elseif($data->estado_id == 2)
                            <td class="text_black"><span class="badge badge-danger p-1"  style="font-size: .875rem;">{{$data->estado_dispositivo}}</span></td>
                        @elseif($data->estado_id == 3)
                            <td class="text_black"><span class="badge badge-dark p-1"  style="font-size: .875rem;">{{$data->estado_dispositivo}}</span></td>
                        @else
                            <td class="text_black"><span class="badge badge-default p-1"  style="font-size: .875rem;">--</span></td>
                        @endif
                    @else 
                        <td class="text_black"><span class="badge badge-default p-1"  style="font-size: .875rem;">--</span></td>
                    @endif
                </tr>
                <tr>
                    <th class="w-30 text-primary">Propietario:</th>
                    
                    <td class="text_black">
                        @if (isset($data->nombre_propietario) && !empty($data->nombre_propietario))
                            {{$data->nombre_propietario}}
                        @else
                            {{ "--" }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Ubicación:</th>
                    <td class="text_black">
                        @if (isset($data->sala_id))
                            {{$data->nombre_edificio}}{{$data->nombre_piso}}.{{$data->numero_sala}} ({{$data->nombre_sala}})
                        @else
                            {{ "--" }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Nombre de Equipo:</th>
                    <td class="text_black">{{$data->nombre_equipo ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Nombre de Usuario AD:</th>
                    <td class="text_black">{{$data->nombre_usuario_ad ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Marca:</th>
                    <td class="text_black">{{$data->nombre_marca ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Modelo:</th>
                    <td class="text_black">{{$data->nombre_modelo ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Tipo:</th>
                    <td class="text_black">{{$data->tipo_pc ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">CPU:</th>
                    <td class="text_black">{{$data->cpu ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">RAM:</th>
                    <td class="text_black">{{$data->ram ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Disco:</th>
                    <td class="text_black">{{$data->disco ?? '--'}}</td>
                </tr>
               {{--  <tr>
                    <th class="w-30 text-primary">Correo:</th>
                    <td class="text_black">{{$data->correo ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Anexo:</th>
                    <td class="text_black">{{$data->anexo ?? '--'}}</td>
                </tr> --}}
                <tr>
                    <th class="w-30 text-primary">Candado:</th>
                    <td class="text_black">{{$data->candado ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Corriente:</th>
                    <td class="text_black">{{$data->corriente ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Orden de Compra:</th>
                    <td class="text_black">{{$data->orden_compra ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Observaciones:</th>
                    <td class="text_black">{{$data->observaciones ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Usuario crea:</th>
                    <td class="text_black">{{$data->nombre_user_crea ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Fecha crea:</th>
                    <td class="text_black">{{$data->fecha_user_crea ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Usuario mod:</th>
                    <td class="text_black">{{$data->nombre_user_mod ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Fecha mod:</th>
                    <td class="text_black">{{$data->fecha_user_mod ?? '--'}}</td>
                </tr>
            </tbody>
          </table>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Sistema Operativo</h6>
                    </div>
                    <div class="card-body">
                        @php 
                            if (isset($data->sistema_operativo)){
                                echo '
                                <table class="table mb-0">
                                    <tbody>
                                        '; 
                                        foreach ($data->sistema_operativo as $item){
                                            echo '<tr>
                                                    <td class="text_black">'.$item->nombre.'</td>
                                                    <td class="text_black">';
                                                        $tiene_licencia = '';
                                                        switch($item->tiene_licencia){
                                                            case 1:
                                                                $tiene_licencia = 'Con licencia';
                                                                break;
                                                            case 0:
                                                                $tiene_licencia = 'Sin licencia';
                                                                break;
                                                            case 2:
                                                                $tiene_licencia = 'No aplica';
                                                                break;
                                                            default:
                                                            break;
                                                        }
                                                        echo $tiene_licencia;
                                                    echo '
                                                    </td>
                                                    <td class="text_black">';
                                                        if (isset($item->licencia)){
                                                            echo $item->licencia; 
                                                        } else {
                                                            echo '--';
                                                        }
                                                    echo '
                                                    </td>
                                            </tr>
                                            ';
                                        }
                                        echo '
                                    </tbody>
                                </table>';
                            } else {
                                echo '
                                  <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td colspan="3">--</td>
                                        </tr>
                                    </tbody>
                                </table>  
                                ';
                            } 
                        @endphp                        
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary ">Office</h6>
                    </div>
                    <div class="card-body">
                        @php 
                            if (isset($data->office)){
                                echo '
                                <table class="table mb-0">
                                    <tbody>
                                        '; 
                                        foreach ($data->office as $item){
                                            echo '<tr>
                                                    <td class="text_black">'.$item->nombre.'</td>
                                                    <td class="text_black">';
                                                        $tiene_licencia = '';
                                                        switch($item->tiene_licencia){
                                                            case 1:
                                                                $tiene_licencia = 'Con licencia';
                                                                break;
                                                            case 0:
                                                                $tiene_licencia = 'Sin licencia';
                                                                break;
                                                            case 2:
                                                                $tiene_licencia = 'No aplica';
                                                                break;
                                                            default:
                                                            break;
                                                        }
                                                        echo $tiene_licencia;
                                                    echo '
                                                    </td>
                                                    <td class="text_black">';
                                                        if (isset($item->licencia)){
                                                            echo $item->licencia; 
                                                        } else {
                                                            echo '--';
                                                        }
                                                    echo '
                                                    </td>
                                            </tr>
                                            ';
                                        }
                                        echo '
                                    </tbody>
                                </table>';
                            } else {
                                echo '
                                  <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td colspan="3">--</td>
                                        </tr>
                                    </tbody>
                                </table>  
                                ';
                            } 
                        @endphp                        
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Antivirus</h6>
                    </div>
                    <div class="card-body">
                        @php 
                            if (isset($data->antivirus)){
                                echo '
                                <table class="table mb-0">
                                    <tbody>
                                        '; 
                                        foreach ($data->antivirus as $item){
                                            echo '<tr>
                                                    <td class="text_black">'.$item->nombre.'</td>
                                                    <td class="text_black">';
                                                        $tiene_licencia = '';
                                                        switch($item->tiene_licencia){
                                                            case 1:
                                                                $tiene_licencia = 'Con licencia';
                                                                break;
                                                            case 0:
                                                                $tiene_licencia = 'Sin licencia';
                                                                break;
                                                            case 2:
                                                                $tiene_licencia = 'No aplica';
                                                                break;
                                                            default:
                                                            break;
                                                        }
                                                        echo $tiene_licencia;
                                                    echo '
                                                    </td>
                                                    <td class="text_black">';
                                                        if (isset($item->licencia)){
                                                            echo $item->licencia; 
                                                        } else {
                                                            echo '--';
                                                        }
                                                    echo '
                                                    </td>
                                            </tr>
                                            ';
                                        }
                                        echo '
                                    </tbody>
                                </table>';
                            } else {
                                echo '
                                  <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td colspan="3">--</td>
                                        </tr>
                                    </tbody>
                                </table>  
                                ';
                            } 
                        @endphp                        
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">App</h6>
                    </div>
                    <div class="card-body">
                        @php 
                            if (isset($data->app_ecritorio)){
                                echo '
                                <table class="table mb-0">
                                    <tbody>
                                        '; 
                                        foreach ($data->app_ecritorio as $item){
                                            echo '<tr>
                                                    <td class="text_black">'.$item->nombre.'</td>
                                                    <td class="text_black">';
                                                        $tiene_licencia = '';
                                                        switch($item->tiene_licencia){
                                                            case 1:
                                                                $tiene_licencia = 'Con licencia';
                                                                break;
                                                            case 0:
                                                                $tiene_licencia = 'Sin licencia';
                                                                break;
                                                            case 2:
                                                                $tiene_licencia = 'No aplica';
                                                                break;
                                                            default:
                                                            break;
                                                        }
                                                        echo $tiene_licencia;
                                                    echo '
                                                    </td>
                                                    <td class="text_black">';
                                                        if (isset($item->licencia)){
                                                            echo $item->licencia; 
                                                        } else {
                                                            echo '--';
                                                        }
                                                    echo '
                                                    </td>
                                            </tr>
                                            ';
                                        }
                                        echo '
                                    </tbody>
                                </table>';
                            } else {
                                echo '
                                  <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td colspan="3">--</td>
                                        </tr>
                                    </tbody>
                                </table>  
                                ';
                            } 
                        @endphp                        
                    </div>
                </div>
            </div>
        </div>
    </div>    
  </div>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
        <button onclick="editar_pc({{$data->pc_id}},1)" type="button" class="btn btn-outline-warning mt-3 btn-sm"><i class="fas fa-pen fa-sm"></i> Editar </button>
    </div>
  </div>