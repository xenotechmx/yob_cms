@extends('back.layout.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Reservación
@stop

{{-- Content Title --}}
@section('contentTitle')
    Reservación
@stop

{{-- Page Top Button --}}
@section('pageTopButton')
    <a href="{{ url('cms/dashboard/reservaciones/reservaciones_web') }}" class="btn btn-info"><i class="icofont icofont-rewind"></i> Regresar</a>
@stop

{{-- Main Content --}}
@section('mainContent')





    <div class="row">
        <div class="col-md-12">
            <div class="card">

                {{ Form::open(['url' => url('cms/dashboard/reservaciones/reservaciones_web/store_reservation/'.$reservation->id) ]) }}

                    <div class="row tabs_custom">
                        <div class="col-md-2 options">
                            <a class="active">Cliente</a>
                            <a>Datos de reservación</a>
                            <a>Habitación reservada</a>
                        </div>
                        <div class="col-md-10 content_options">
                            <div class="content_tab active">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Nombre</label>
                                    <div class="col-sm-12">
                                        {{ Form::text('nombre', $reservation->client["nombre_completo"], ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Email</label>
                                    <div class="col-sm-12">
                                        {{ Form::text('email', $reservation->client["email"], ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Teléfono</label>
                                    <div class="col-sm-12">
                                        {{ Form::text('telefono', $reservation->client["telefono"], ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Celular</label>
                                    <div class="col-sm-12">
                                        {{ Form::text('celular', $reservation->client["celular"], ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="content_tab">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">SKU</label>
                                    <div class="col-sm-12">
                                        {{ Form::text('sku', $reservation->SKU, ['class' => 'form-control disabled', 'disabled' => 'true']) }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Estatus de pago</label>
                                    <div class="col-sm-12">
                                        {{ Form::select('estatus_pago', array("pending_payment" => "Pendiente de pago", "paid" => "Pagado") ,$reservation->payment_status, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Tipo de pago</label>
                                    <div class="col-sm-12">
                                        {{ Form::text('tipo_pago', $reservation->tipo_pago, ['class' => 'form-control disabled', 'disabled' => 'true']) }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">SPEI CODE</label>
                                    <div class="col-sm-12">
                                        {{ Form::text('spei_code', $reservation->spei_code, ['class' => 'form-control disabled', 'disabled' => 'true']) }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Fecha de entrada y salida</label>
                                    <div class="col-sm-3">
                                        {{ Form::text('fecha_entrada', $reservation->fecha_entrada, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="col-sm-3">
                                        {{ Form::text('fecha_salida', $reservation->fecha_salida, ['class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <label class="col-sm-12 col-form-label">Numero de personas</label>
                                            <div class="col-sm-12">
                                                {{ Form::text('numero_personas', $reservation->numero_personas, ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <label class="col-sm-12 col-form-label">Total de noches</label>
                                            <div class="col-sm-12">
                                                {{ Form::text('total_noches', $reservation->total_noches, ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Costo por persona</label>
                                    <div class="col-sm-12">
                                        {{ Form::text('costo_persona', $reservation->costo_por_persona, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Subtotal</label>
                                    <div class="col-sm-12">
                                        {{ Form::text('subtotal', $reservation->subtotal, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">IVA</label>
                                    <div class="col-sm-12">
                                        {{ Form::text('iva', $reservation->iva, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">TOTAL</label>
                                    <div class="col-sm-12">
                                        {{ Form::text('total', $reservation->total, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="content_tab">

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Nombre</label>
                                    <div class="col-sm-12">
                                        {{ Form::text('nombre_habitacion', $reservation->room["name"], ['class' => 'form-control disabled', 'disabled' => 'true']) }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Tipo</label>
                                    <div class="col-sm-12">
                                        {{ Form::text('tipo_habitacion', $reservation->room["type"], ['class' => 'form-control disabled', 'disabled' => 'true']) }}
                                    </div>
                                </div>

                                @if( $reservation->room["checkin"] != "" )
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <div class="row">
                                                <label class="col-sm-12 col-form-label">Check-in</label>
                                                <div class="col-sm-12">
                                                    {{ Form::text('check_in', $reservation->room["checkin"], ['class' => 'form-control disabled', 'disabled' => 'true']) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="row">
                                                <label class="col-sm-12 col-form-label">Check-out</label>
                                                <div class="col-sm-12">
                                                    {{ Form::text('check_out', $reservation->room["checkout"], ['class' => 'form-control disabled', 'disabled' => 'true']) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
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











@stop

{{-- Page JS --}}
@section('pageJS')
    {{ Html::script('/back/js/dashboard/simpleForm.js')  }}
    {{ Html::script('/back/js/multi_dates_picker/jquery-ui.multidatespicker.js')  }}
    {{ Html::script('/back/js/dashboard/catalog/offers/create.js')  }}
@stop
