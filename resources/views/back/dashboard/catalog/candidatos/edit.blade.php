@extends('back.layout.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Edición de paquete
@stop

{{-- Content Title --}}
@section('contentTitle')
    Edición de paquete
@stop

{{-- Page Top Button --}}
@section('pageTopButton')
    <a href="{{ url('cms/dashboard/catalogo/ofertas') }}" class="btn btn-info"><i class="icofont icofont-rewind"></i> Regresar</a>
@stop

{{-- Main Content --}}
@section('mainContent')
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-block">

                    {{ Form::open(['url' => url('cms/dashboard/catalogo/clientes/update/'.$id) ]) }}

                        {{ Form::hidden('id', $data->id, ['class' => 'form-control']) }}

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Nombre comercial de la empresa</label>
                            <div class="col-sm-12">
                                {{ Form::text('business_name', $data->business_name, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Dirección</label>
                            <div class="col-sm-12">
                                {{ Form::text('address', $data->address, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Nombre del usuario</label>
                            <div class="col-sm-12">
                                {{ Form::text('user_name', $data->user_name, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Correo electrónico</label>
                            <div class="col-sm-12">
                                {{ Form::email('email', $data->email, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Teléfono</label>
                            <div class="col-sm-12">
                                {{ Form::tel('phone', $data->phone, ['class' => 'form-control']) }}
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
                                <button type="reset" class="btn btn-danger"><i class="icofont icofont-refresh"></i> Limpiar</button>
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
    {{ Html::script('/back/js/dashboard/catalog/offers/edit.js')  }}
@stop
