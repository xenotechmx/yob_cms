@extends('back.layout.account')

{{-- Page Title --}}
@section('pageTitle')
    Recuperación de Contraseña
@stop

{{-- Main Content --}}
@section('mainContent')
    {{ Form::open(['url' => 'admin/account/password-recovery', 'class' => 'md-float-material']) }}
    <div class="auth-box">
        <div class="row m-b-20">
            <div class="col-md-12">
                <h3 class="text-left txt-primary">Recuperacion de contraseña</h3>
            </div>
        </div>
        <hr />

        @if(count($errors) > 0 || Session::has('loginError'))
            <div class="alert alert-danger icons-alert">
                <h6 class="text-left">Error</h6>
                <p class="text-left">El correo electrónico no existe</p>
            </div>
        @endif

        <div class="input-group">
            {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Tu cuenta de correo']) }}
            <span class="md-line"></span>
        </div>

        <div class="row m-t-30">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Enviar correo</button>
            </div>
        </div>

        <div class="row m-t-30">
            <div class="col-md-12">
                <a class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" href="{{url('admin')}}">Regresar</a>
            </div>
        </div>

        <hr />
        <div class="row">
            <div class="col-md-10">
                <p class="text-inverse text-left m-b-0">Desarrollador por</p>
                <p class="text-inverse text-left"><b>Metodika TI</b></p>
            </div>
        </div>
    </div>
    {{ Form::close()  }}
@stop

@section('pageJS')
    {!! Html::script('back/js/account/password-recovery.js') !!}
@stop
