@extends('back.layout.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Editar Perfil
@stop

{{-- Module Name --}}
@section('contentTitle')
    Editar Perfil
@stop

{{-- Action Button --}}
@section('pageTopButton')
    <a href="{{ route('profile_index') }}" class="btn btn-info"><i class="icofont icofont-rewind"></i>Regresar</a>
@stop

{{-- Contenido --}}
@section('mainContent')
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['route'   => 'profile.update']) }}
            <input type="hidden" value="{{ $id }}" id="id" name="id" data-url="{{route('profile.data')}}" />

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nombre de Perfil:</label>
                        <input type="text" class="form-control" name="nombre" id="nombre">
                    </div>
                </div>
            </div>

            <div class="row">

                @foreach ($modules as $module)

                    @if(count($module['child']) > 0)

                        <div class="col-sm-6">
                            <div class="col-sm-12 text-center">
                                <h3>{{$module['name']}}</h3>
                            </div>
                            <div class="box border primary">
                                <div class="box-body">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th class="select-all pointer">{!! $module['name'] !!}</th>
                                            <th class="select-all pointer text-center" data-id="{!! $module['id'] !!}-READ">Vista</th>
                                            <th class="select-all pointer text-center" data-id="{!! $module['id'] !!}-CREATE">Alta</th>
                                            <th class="select-all pointer text-center" data-id="{!! $module['id'] !!}-DELETE">Baja</th>
                                            <th class="select-all pointer text-center" data-id="{!! $module['id'] !!}-UPDATE">Cambios</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($module['child'] as $children)
                                            @include('back.dashboard.system.profile.partials.innerTable', ['children' => $children, 'parentID' => $module['id']])
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-sm-6">
                            <div class="box border primary">
                                <div class="box-body">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th class="select-all pointer">{!! $module['name'] !!}</th>
                                            <th class="select-all pointer text-center" data-id="{!! $module['id'] !!}-READ">Vista</th>
                                            <th class="select-all pointer text-center" data-id="{!! $module['id'] !!}-CREATE">Alta</th>
                                            <th class="select-all pointer text-center" data-id="{!! $module['id'] !!}-DELETE">Baja</th>
                                            <th class="select-all pointer text-center" data-id="{!! $module['id'] !!}-UPDATE">Cambios</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @include('back.dashboard.system.profile.partials.innerTable', ['children' => $module, 'parentID' => $module['id']])
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    @endif

                @endforeach
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('pageJS')
    {!! Html::script('/back/js/dashboard/system/profile/view.js') !!}
    <script>
        getData(1);
    </script>
@stop
