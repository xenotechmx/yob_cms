@extends('back.layout.dashboard')

@section('contentTitle', 'Edición de perfil')

@section('topButton')
    <a href="{{ route('profile_index') }}" class="m-l-15"><button type="button" class="btn btn-info d-none d-lg-block"><i class="fas fa-chevron-left"></i> Regresar</button></a>
@stop

@section('content_dashboard')
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['route'   => 'profile.update' , 'id' => 'form_profile'])}}
            <input type="hidden" value="{{ $id }}" id="id" name="id" data-url="{{route('profile.data')}}"/>

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
                                                <input type="checkbox" class="view" <?php echo (($user_profile->checkPermitionByModule($module['id'], "view") == 1) ? "checked" : ""); ?> />
                                                <input type="hidden" name="parent[{!! $module['id'] !!}]" value="<?php echo $user_profile->checkPermitionByModule($module['id'], "view"); ?>" />
                                            </td>

                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                        </tr>

                                        @foreach ($module['child'] as $children)
                                            @include('back.dashboard.system.profile.partials.innerTableEdit', ['children' => $children, 'parentID' => $module['id']])
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    @else

                        <div class="col-sm-6">
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
                                                    <input type="checkbox" class="view" <?php echo (($user_profile->checkPermitionByModule($module['id'], "view") == 1) ? "checked" : ""); ?> />
                                                    <input type="hidden" name="parent[{!! $module['id'] !!}]" value="<?php echo $user_profile->checkPermitionByModule($module['id'], "view"); ?>" />
                                                </td>

                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                            </tr>

                                            @include('back.dashboard.system.profile.partials.innerTableEdit', ['children' => $module, 'parentID' => $module['id']])
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    @endif

                @endforeach
            </div>


            <div class="form-group text-right">
                <button class="btn btn-primary" type="submit">Guardar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('JS')
    {{ Html::script('system/js/form_profile.js')  }}
    <script>
        getData();
    </script>
@stop
