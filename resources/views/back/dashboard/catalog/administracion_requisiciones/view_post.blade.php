@extends('back.layout.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Administración de Requisiciónes
@stop

{{-- Content Title --}}
@section('contentTitle')
    Requisición: {{ $job->title }}
@stop

{{-- Page Top Button --}}
@section('pageTopButton')
    <a href="{{ url('cms/dashboard/catalogo/administracion_requisiciones') }}" class="btn btn-info"><i class="icofont icofont-rewind"></i> Regresar</a>
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
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($users as $item)
                                <tr>
                                    <td>{{$item->get_user["id"]}}</td>
                                    <td>{{$item->get_user["name"]}}</td>
                                    <td>{{$item->get_user["email"]}}</td>
                                    <td>{{$item->get_user["phone_number"]}}</td>
                                    <td>
                                        <a href="{{URL::to('cms/dashboard/catalogo/administracion_requisiciones/view_user/'.base64_encode($item->get_user["id"]))}}" class="btn btn-primary"><i class="icofont icofont-eye"></i>Ver</a>
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
    {{--<script>--}}
        {{--$(document).ready(function () {--}}

            {{--$(this).on("change", "select[name='state']", function () {--}}

                {{--var state = $(this).val();--}}

                {{--var data = {};--}}
                {{--data.estado = state;--}}
                {{--$.ajax({--}}
                    {{--url: "get_municipio_by_estado",--}}
                    {{--type: "GET",--}}
                    {{--data: data,--}}
                    {{--dataType: "JSON",--}}
                    {{--error: function (e) {--}}
                        {{--console.log(e);--}}
                    {{--},--}}
                    {{--success: function (result) {--}}
                        {{--console.log(result);--}}
                        {{--$("select[name='municipaly']").html(result);--}}
                    {{--}--}}
                {{--});--}}

            {{--});--}}

        {{--});--}}
    {{--</script>--}}
@stop
