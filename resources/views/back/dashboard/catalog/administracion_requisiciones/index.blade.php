@extends('back.layout.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Administración de Requisiciones
@stop

{{-- Content Title --}}
@section('contentTitle')
    Administración de Requisiciones
@stop

{{-- Page Top Button --}}
@section('pageTopButton')
    {{--<a href="{{ url('cms/dashboard/catalogo/requisiciones/create') }}" class="btn btn-info"><i class="icofont icofont-plus-circle"></i> Nueva Requisición</a>--}}
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
                                <th>ID</th>
                                <th>Puesto</th>
                                <th>Cliente</th>
                                <th>Estado</th>
                                <th>Municipio</th>
                                <th>Título de empleo</th>
                                <th>Descripción</th>
                                <th>Estatus</th>
                                <th>Fecha de alta</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{$item->job}}</td>
                                    <td>{{$item->client["business_name"]}}</td>
                                    <td>{{$item->state}}</td>
                                    <td>{{$item->municipaly}}</td>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>{{$item->get_status()}}</td>
                                    <td>{{ date("d-m-Y", strtotime($item->created_at)) }}</td>
                                    <td>
                                        <a href="{{URL::to('cms/dashboard/catalogo/administracion_requisiciones/view/'.base64_encode($item->id))}}" class="btn btn-primary"><i class="icofont icofont-eye"></i>Ver</a>
                                        @if( $item->get_total_postulaciones() > 0 )
                                            <br><a href="{{URL::to('cms/dashboard/catalogo/administracion_requisiciones/view_post/'.base64_encode($item->id))}}" class="btn btn-success">Ver postulaciones ({{ $item->get_total_postulaciones() }})</a>
                                        @endif
                                        {{--<a href="{{URL::to('cms/dashboard/catalogo/requisiciones/edit/'.base64_encode($item->id))}}" class="btn btn-warning"><i class="icofont icofont-pencil"></i>Editar</a>--}}
                                        {{--<a href="{{URL::to('cms/dashboard/catalogo/requisiciones/delete/'.base64_encode($item->id))}}" class="btn btn-danger btn-delete"><i class="icofont icofont-trash"></i>Borrar</a>--}}
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
