@extends('back.layout.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Reservaciones
@stop

{{-- Content Title --}}
@section('contentTitle')
    Reservaciones desde sitio web
@stop

{{-- Page Top Button --}}
@section('pageTopButton')
    {{--<a href="{{ url('cms/dashboard/reservaciones/reservaciones_web/create') }}" class="btn btn-info"><i class="icofont icofont-plus-circle"></i> Nueva Oferta</a>--}}
@stop

{{-- Main Content --}}
@section('mainContent')
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Cliente</th>
                                <th>Habitacion</th>
                                <th>Total de noches</th>
                                <th>Tipo de pago</th>
                                <th>Status de pago</th>
                                <th>Check In / Check Out</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $item->SKU }}</td>
                                    <td>{{ $item->client["nombre_completo"] }}</td>
                                    <td>{{ $item->room["name"] }}</td>
                                    <td>{{ $item->total_noches }}</td>
                                    <td>{{ $item->tipo_pago }}</td>
                                    <td>{{ $item->payment_status }}</td>
                                    <td>{{ date("d/m/Y", strtotime($item->fecha_entrada)) }} - {{ date("d/m/Y", strtotime($item->fecha_salida)) }}</td>
                                    <td>$ {{ number_format($item->total, 2, ".", ",") }}</td>
                                    <td>
                                        <a href="{{URL::to('cms/dashboard/reservaciones/reservaciones_web/view/'.base64_encode($item->id))}}"  message-used="" class="btn btn-primary"><i class="icofont icofont-pencil"></i>Ver reservación</a>
                                        <a href="{{URL::to('cms/dashboard/catalogo/ofertas/edit/'.base64_encode($item->id))}}"  message-used="La oferta se encuentra asignada a uno o más Habitaciones/Paquetes, al eliminarlo ya no se encontrará disponible." class="btn btn-warning"><i class="icofont icofont-pencil"></i>Editar</a>
                                        <a href="{{URL::to('cms/dashboard/catalogo/ofertas/delete/'.base64_encode($item->id))}}"  message-used="La oferta se encuentra asignada a uno o más Habitaciones/Paquetes, al eliminarlo ya no se encontrará disponible." class="btn btn-danger btn-delete" data-name='{{$item->category_id}}'><i class="icofont icofont-trash"></i>Borrar</a>
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
@section('pageJS')
    {{ Html::script('back/js/dashboard/simpleTable.js')  }}
@stop
