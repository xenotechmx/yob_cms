@extends('back.layout.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Clientes
@stop

{{-- Content Title --}}
@section('contentTitle')
    Catálogo de Clientes
@stop

{{-- Page Top Button --}}
@section('pageTopButton')
    <a href="{{ url('cms/dashboard/catalogo/clientes/create') }}" class="btn btn-info"><i class="icofont icofont-plus-circle"></i> Nuevo Cliente</a>
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
                                <th>No.</th>
                                <th>Nombre comercial de la empresa</th>
                                <th>Dirección</th>
                                <th>Nombre del usuario</th>
                                <th>Correo electrónico</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$item->business_name}}</td>
                                    <td>{{$item->address}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->phone}}</td>
                                    <td>
                                        <a href="{{URL::to('cms/dashboard/catalogo/clientes/edit/'.base64_encode($item->id))}}" class="btn btn-warning"><i class="icofont icofont-pencil"></i>Editar</a>
                                        <a href="{{URL::to('cms/dashboard/catalogo/clientes/delete/'.base64_encode($item->id))}}" class="btn btn-danger btn-delete" data-name='{{$item->category_id}}'><i class="icofont icofont-trash"></i>Borrar</a>
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
