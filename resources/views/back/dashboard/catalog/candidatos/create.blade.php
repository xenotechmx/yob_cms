@extends('back.layout.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Alta de nuevo Cliente
@stop

{{-- Content Title --}}
@section('contentTitle')
    Alta de nuevo Cliente
@stop

{{-- Page Top Button --}}
@section('pageTopButton')
    <a href="{{ url('cms/dashboard/catalogo/clientes') }}" class="btn btn-info"><i class="icofont icofont-rewind"></i> Regresar</a>
@stop

{{-- Main Content --}}
@section('mainContent')
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-block">

                    {{ Form::open(['url' => url('cms/dashboard/catalogo/clientes/store') ]) }}


                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Nombre comercial de la empresa</label>
                            <div class="col-sm-12">
                                {{ Form::text('business_name', null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Dirección</label>
                            <div class="col-sm-12">
                                {{ Form::text('address', null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Nombre del usuario</label>
                            <div class="col-sm-12">
                                {{ Form::text('user_name', null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Correo electrónico</label>
                            <div class="col-sm-12">
                                {{ Form::email('email', null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Teléfono</label>
                            <div class="col-sm-12">
                                {{ Form::tel('phone', null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Contraseña</label>
                            <div class="col-sm-12">
                                <input type="password" name="password" class="form-control" value="" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Confirma Contraseña</label>
                            <div class="col-sm-12">
                                <input type="password" name="password_confirmation" class="form-control" value="" />
                            </div>
                        </div>



                        <div class="form-group row">
                            <div class="col-sm-2"></div>

                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary btn-save"><i class="icofont icofont-save"></i> Guardar</button>
                            </div>
                        </div>

                    {{ Form::close() }}

                </div>

            </div>
        </div>
    </div>
@stop

{{-- Page JS --}}
@section('pageJS')
    {{ Html::script('/back/js/dashboard/simpleForm.js')  }}
    {{ Html::script('/back/js/multi_dates_picker/jquery-ui.multidatespicker.js')  }}
@stop
