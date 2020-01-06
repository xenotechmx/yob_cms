@extends('back.layout.account_client')

{{-- Page Title --}}
@section('pageTitle')
    Inicio de sesión
@stop

{{-- Main Content --}}
@section('content_account_client')

    <div class="login-register" style="background-image:url(assets/images/background/login-register.jpg);">
        <div class="login-box card">
            <div class="card-body">

                {{ Form::open(['route' => 'admin_login', 'class' => 'form-horizontal form-material', 'id' => 'loginform']) }}

                    {{ Form::hidden('type', "clients") }}

                    <h3 class="text-center m-b-20">Inicio de sesión</h3>

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                {!! $error !!}
                            </div>
                        @endforeach
                    @elseif( Session::has('loginError') )
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            {!! Session::get('loginMsg') !!}
                        </div>
                    @endif

                    <div class="form-group ">
                        <div class="col-xs-12">
                            {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Cuenta de correo', 'required' => "true"]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña', 'required' => "true"]) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="no-block align-items-center text-center">
                                <a href="javascript:void(0)" id="to-recover" class="text-muted"><i class="fas fa-lock m-r-5"></i> Recuperar contraseña</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <button class="btn btn-block btn-lg btn-info btn-rounded" type="submit">Ingresar</button>
                    </div>

                {{ Form::close()  }}


                {{ Form::open(['route' => 'password.reset', 'class' => 'form-horizontal', 'id' => 'recoverform']) }}

                    <input type="hidden" value="{{ csrf_token() }}" name="csrf">

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recuperar contraseña</h3>
                            <p class="text-muted">Ingresa tu cuenta de correo para restablecer tu contraseña:</p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" required="" placeholder="Cuenta de correo" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="no-block align-items-center text-center">
                                <a href="javascript:void(0)" id="to-recover-hide" class="text-muted">Cancelar</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Recuperar contraseña</button>
                        </div>
                    </div>

                {{ Form::close()  }}


            </div>
        </div>
    </div>


@stop