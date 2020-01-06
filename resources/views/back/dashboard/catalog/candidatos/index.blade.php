@extends('back.layout.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Candidatos
@stop

{{-- Content Title --}}
@section('contentTitle')
    Catálogo de Candidatos Registrados
@stop

{{-- Page Top Button --}}
@section('pageTopButton')
    {{--<a href="{{ url('cms/dashboard/catalogo/candidatos/create') }}" class="btn btn-info"><i class="icofont icofont-plus-circle"></i> Nueva Oferta</a>--}}
@stop

{{-- Main Content --}}
@section('mainContent')
    <div class="row">
        <div class="col-md-12">

            <h5>Filtro de Cantidatos</h5>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-12 col-form-label">Edad</label>
                        <div class="col-sm-5">
                            {{ Form::number('edad_de', "", ['class' => 'form-control']) }}
                        </div>
                        <div class="col-sm-1 text-center">a</div>
                        <div class="col-sm-5">
                            {{ Form::number('edad_a', "", ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-12 col-form-label">Puesto</label>
                        <div class="col-sm-12">
                            {{ Form::select('puesto', $job_catalogs, "", ['class' => '', 'placeholder' => 'Todos']) }}
                        </div>
                    </div>
                </div>
                {{--<div class="col-md-4">--}}
                    {{--<div class="form-group row m-0">--}}
                        {{--<label class="col-sm-12 col-form-label">Municipio</label>--}}
                        {{--<div class="col-sm-12">--}}
                            {{--{{ Form::select('municipaly_id', $municipios, "", ['class' => '', 'placeholder' => "Todos"]) }}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="col-md-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-12 col-form-label">Estado civil</label>
                        <div class="col-sm-12">
                            {{ Form::select('civil_status', ["union_libre" => "Unión libre", "divorciado" => "Divorciado", "soltero" => "Soltero", "casado" => "Casado", "otro" => "Otro"], "", ['class' => 'form-control', "placeholder" => "Todos"]) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-12 col-form-label">Ingreso deseado</label>
                        <div class="col-sm-12">
                            {{ Form::select('salary', [ "5_10" => "$5,000 - $10,000 libre", "10_15" => "$10,000 - $15,000", "15_20" => "$15,000 - $20,000", "20_25" => "$20,000 - $25,000", "25" => "$25,000 o más"], "", ['class' => 'form-control', "placeholder" => "Todos"]) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-12 col-form-label">Tipo de licencia</label>
                        <div class="col-sm-12">
                            {{ Form::select('driver_licence_type', [
                            "na"     => "Todos",
                            ""     => "Vencida",
                            "tipo_a" => "Con licencia Tipo A",
                            "tipo_b" => "Con licencia Tipo B",
                            "tipo_c" => "Con licencia Tipo C",
                            "tipo_d" => "Con licencia Tipo D",
                            "tipo_e" => "Con licencia Tipo E",
                            "tipo_f" => "Con licencia Tipo F"
                            ],
                            "na", ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-12 col-form-label">Estudios</label>
                        <div class="col-sm-12">
                            {{ Form::select('study_level', [
                            "Primaria"     => "Primaria",
                            "Primaria Trunca" => "Primaria Trunca",
                            "Secundaria" => "Secundaria",
                            "Secundaria trunca" => "Secundaria trunca",
                            "Preparatoria" => "Preparatoria",
                            "Preparatoria Trunca" => "Preparatoria Trunca",
                            "Técnica" => "Técnica",
                            "Técnica trunca" => "Técnica trunca",
                            "Licenciatura" => "Licenciatura",
                            "Licenciatura trunca" => "Licenciatura trunca",
                            "Maestría" => "Maestría",
                            "Maestría Truca" => "Maestría Truca",
                            "Otro" => "Otro"
                            ],
                            "", ['class' => 'form-control', "placeholder" => "Todos"]) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-12 col-form-label">Idiomas</label>
                        <div class="col-sm-12">
                            {{ Form::select('language_id', $idiomas, "", ['class' => 'form-control', "placeholder" => "Todos"]) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-12 col-form-label">Estatus</label>
                        <div class="col-sm-12">
                            {{ Form::select('status', ["" => "Todos", "activo" => "Activo", "descartado" => "Descartado", "colocado" => "Colocado"], "activo", ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-12 col-form-label">Estado</label>
                        <div class="col-sm-12">
                            {{ Form::select('state_id', $state, "", ['class' => 'form-control', "placeholder" => "Todos"]) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-12 col-form-label">Municipio</label>
                        <div class="col-sm-12 municipio_dinamic">
                            {{ Form::select('municipaly_id', ["" => "Todos"], "", ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-right">
                    <br>
                    <a href="{{ url('cms/dashboard/catalogo/candidatos/create') }}" class="btn btn-success filter_candidatos"><i class="icofont icofont-plus-circle"></i> Filtrar</a>
                    <br>
                    <br>
                </div>
            </div>

            <div class="card">

                <div class="card-block">
                    <div class="dt-responsive table-responsive" id="table_candidatos">

                        {{--<table id="simpletable" class="table table-striped table-bordered nowrap">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th>No.</th>--}}
                                {{--<th>Nombre</th>--}}
                                {{--<th>Email</th>--}}
                                {{--<th>Teléfono</th>--}}
                                {{--<th>Acciones</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}

                            {{--<tbody>--}}
                            {{--@foreach($data as $item)--}}
                                {{--<tr>--}}
                                    {{--<td>{{$item->id}}</td>--}}
                                    {{--<td>{{$item->name}}</td>--}}
                                    {{--<td>{{$item->email}}</td>--}}
                                    {{--<td>{{$item->phone_number}}</td>--}}
                                    {{--<td>--}}
                                        {{--<a href="{{URL::to('cms/dashboard/catalogo/candidatos/view/'.base64_encode($item->id))}}" class="btn btn-primary"><i class="icofont icofont-eye"></i>Ver</a>--}}
                                        {{--<a href="{{URL::to('cms/dashboard/catalogo/clientes/edit/'.base64_encode($item->id))}}" class="btn btn-warning"><i class="icofont icofont-pencil"></i>Editar</a>--}}
                                        {{--<a href="{{URL::to('cms/dashboard/catalogo/clientes/delete/'.base64_encode($item->id))}}" class="btn btn-danger btn-delete"><i class="icofont icofont-trash"></i>Borrar</a>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                            {{--</tbody>--}}
                        {{--</table>--}}


                    </div>
                </div>
            </div>
        </div>
    </div>
@stop



@section('pageCSS')
    {{ Html::style('js/select2/dist/css/select2.css')  }}
@stop
@section('pageJS')
    {{ Html::script('back/js/dashboard/simpleTable.js')  }}
    {{ Html::script('assets/front/cantidatos/index.js')  }}
    {{ Html::script('js/select2/dist/js/select2.js')  }}
@stop
