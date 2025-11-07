

  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <table class="table mb-0 table-striped table-condensed">
            <tbody>
                <tr>
                    <th class="w-30 text-primary">ID:</th>
                    <td class="text_black">{{$data->huellero_id}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Serie:</th>
                    <td class="text_black">
                        @if (isset($data->serie) && !empty($data->serie))
                            {{$data->serie}}
                        @else
                            {{ "--" }}
                        @endif
                    </td>
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
                    <th class="w-30 text-primary">Marca:</th>
                    <td class="text_black">{{$data->nombre_marca ?? '--'}}</td>
                </tr>
                <tr>
                    <th class="w-30 text-primary">Modelo:</th>
                    <td class="text_black">{{$data->nombre_modelo ?? '--'}}</td>
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
  </div>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
        <button onclick="editar_huellero({{$data->huellero_id}},1)" type="button" class="btn btn-outline-warning mt-3 btn-sm"><i class="fas fa-pen fa-sm"></i> Editar </button>
    </div>
  </div>