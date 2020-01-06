@extends('back.layout.dashboard')

@section('contentTitle', 'Edición de usuario')

@section('topButton')
    <a href="{{ route('user_index') }}" class="m-l-15"><button type="button" class="btn btn-info d-none d-lg-block"><i class="fas fa-chevron-left"></i> Regresar</button></a>
@stop

@section('content_dashboard')

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-body">

                {{ Form::open(['route' => array('user_update', base64_encode($user->id)), 'class' => 'form-horizontal']) }}

                    <div class="form-group">
                        <label>Nombre</label>
                        {{ Form::text('nombre', ucwords($user->name), ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        {{ Form::email('email', $user->email, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        <label>Perfil de Usuario</label>
                        <select class="form-control" name="perfil">
                            <option value="">Seleccione un perfil de usuario</option>
                            @foreach($profiles as $profile)
                                @if($user->user_profile_id == $profile->id)
                                    <option value="{{ $profile->id }}" selected> {{ $profile->name }}</option>
                                @else
                                    <option value="{{ $profile->id }}"> {{ $profile->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Contraseña</label>
                        {{ Form::password('password', ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        <label>Confirmar Contraseña</label>
                        {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="icofont icofont-save"></i> Guardar</button>

                {{ Form::close() }}

            </div>
        </div>
    </div>




@stop

@section('JS')
    {{ Html::script('system/js/form.js')  }}
@stop

