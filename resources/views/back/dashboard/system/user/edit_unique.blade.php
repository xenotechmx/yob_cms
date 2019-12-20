@extends('back.layout.dashboard')

@section('contentTitle', 'Edición de perfil')

{{--@section('topButton')--}}
    {{--<a href="{{ route('user_index') }}" class="m-l-15"><button type="button" class="btn btn-info d-none d-lg-block"><i class="fas fa-chevron-left"></i> Regresar</button></a>--}}
{{--@stop--}}

@section('content_dashboard')

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-body">

                {{ Form::open(['route' => array('user_unique_update', base64_encode($user->id)), 'class' => 'form-horizontal']) }}

                    <div class="form-group text-center">
                        @if( $user->profile_image == "" )
                            <img src="{{ asset('assets/images/users/2.jpg') }}" class="img-circle m-b-20" width="250">
                        @else
                            <img src="{{ asset($user->profile_image) }}" class="img-circle m-b-20" width="250">
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Imagen de perfil</label>
                        <input type="file" class="form-control" name="profile_image">
                    </div>

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
                        {{ Form::text('perfil', $user->userProfile["name"], ['class' => 'form-control', 'readonly' => true]) }}
                    </div>

                    <div class="form-group">
                        <label>Contraseña</label>
                        {{ Form::password('password', ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        <label>Confirmar Contraseña</label>
                        {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="icofont icofont-save"></i> Actualizar perfil</button>

                {{ Form::close() }}

            </div>
        </div>
    </div>




@stop

@section('JS')
    {{ Html::script('system/js/form.js')  }}
@stop

