@extends('back.layout.dashboard')

@section('contentTitle', 'Alta de nuevo perfil')

@section('topButton')
    <a href="{{ route('profile_index') }}" class="m-l-15"><button type="button" class="btn btn-info d-none d-lg-block"><i class="fas fa-chevron-left"></i> Regresar</button></a>
@stop

@section('content_dashboard')

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-body">

                {!! Form::open(['route' => 'profile.store', 'id' => 'form_profile', 'class' => 'form-horizontal']) !!}

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Nombre de Perfil:</label>
                                <input type="text" class="form-control" name="nombre">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        @foreach ($modules as $module)
                            @if(count($module['child']) > 0)
                                <div class="col-sm-6">
                                    <br>
                                    <div class="col-sm-12 text-center">
                                        <h3>{{$module['name']}}</h3>
                                    </div>
                                    <div class="box border primary">
                                        <div class="box-body">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead>
                                                <tr>
                                                    <th class="select-all pointer"></th>
                                                    <th class="select-all pointer text-center" data-id="{!! $module['id'] !!}-READ">Vista</th>
                                                    <th class="select-all pointer text-center" data-id="{!! $module['id'] !!}-CREATE">Alta</th>
                                                    <th class="select-all pointer text-center" data-id="{!! $module['id'] !!}-DELETE">Baja</th>
                                                    <th class="select-all pointer text-center" data-id="{!! $module['id'] !!}-UPDATE">Cambios</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td class="select-row"><strong>{!! $module['name'] !!}</strong></td>
                                                    <td class="text-center">
                                                        <input type="checkbox" class="view"/>
                                                        <input type="hidden" name="parent[{!! $module['id'] !!}]" value="0" />
                                                    </td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                </tr>
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
                                    <br>
                                    <div class="col-sm-12 text-center">
                                        <h3>{{$module['name']}}</h3>
                                    </div>
                                    <div class="box border primary">
                                        <div class="box-body">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead>
                                                <tr>
                                                    <th class="select-all pointer"></th>
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


                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary"><i class="icofont icofont-save"></i> Guardar</button>
                    </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>

@stop

@section('JS')
    {{ Html::script('system/js/form_profile.js')  }}
@stop
