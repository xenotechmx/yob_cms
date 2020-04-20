@extends('back.layout.dashboard')

@section('contentTitle', 'Paquetes')

@section('topButton')
    @if( $permitions["create"] )
        <a href="{{ route('paquetes.create') }}" class="m-l-15"><button type="button" class="btn btn-info d-none d-lg-block"><i class="fa fa-plus-circle"></i> Nuevo paquete</button></a>
    @endif
@stop


{{-- Main Content --}}
@section('content_dashboard')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_principal" order-by='Orden' class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Orden</th>
                                    <th>Nombre</th>
                                    <th>Días de duración del plan</th>
                                    <th>Empleos permitidos para publicar</th>
                                    <th>Identidades</th>
                                    <th>Días de duración de la vacante</th>
                                    <th>Publicaciones destacadas</th>
                                    <th>Precio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->id  }}</td>
                                        <td>{{ $item->order  }}</td>
                                        <td>{{ $item->name  }}</td>
                                        <td>{{ $item->duration_plan_in_days  }}</td>
                                        <td>{{ ($item->total_jobs_to_post == -1) ? "Ilimitado" : $item->total_jobs_to_post }}</td>
                                        <td>{{ ($item->total_profiles_to_view == -1) ? "Ilimitado" : $item->total_profiles_to_view }}</td>
                                        <td>{{ ($item->duration_in_days == -1) ? "Ilimitado" : $item->duration_in_days }}</td>

                                        <td>{{ ($item->destacable == -1) ? "Ilimitado" : $item->destacable }}</td>

                                        <td>$ {{ number_format(floor($item->price*pow(10,2))/pow(10,2),2) }}</td>
                                        <td>
                                            @if( $permitions["edit"] )
                                                <a href="{{ route('paquetes.edit', base64_encode($item->id)) }}"><button type="button" class="btn waves-effect waves-light btn-success"><i class="fas fa-edit"></i> Editar</button></a>
                                            @endif
                                            @if( $permitions["delete"] )
                                                <a href="{{ route('paquetes.destroy',  base64_encode($item->id)) }}" class="btn-delete"><button type="button" class="btn waves-effect waves-light btn-danger"><i class="fas fa-minus-circle"></i> Eliminar</button></a>
                                            @endif
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

@stop

{{-- Page JS --}}
@section('JS')
    {{ Html::script('system/js/table.js')  }}
@stop
