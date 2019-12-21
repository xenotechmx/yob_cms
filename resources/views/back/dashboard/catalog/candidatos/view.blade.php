@extends('back.layout.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Candidato
@stop

{{-- Content Title --}}
@section('contentTitle')
    Candidato
@stop

{{-- Page Top Button --}}
@section('pageTopButton')
    {{--<a href="{{ url('cms/dashboard/catalogo/candidatos') }}" class="btn btn-info"><i class="icofont icofont-rewind"></i> Regresar</a>--}}
@stop

{{-- Main Content --}}
@section('mainContent')
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-block">

                    {{ Form::open(['url' => url('cms/dashboard/catalogo/clientes/store') ]) }}

                    <h4>Datos personales</h4>

                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label">Nombre completo</label>
                        <div class="col-sm-12">
                            {{ Form::text('business_name', $app_user->name , ['class' => 'form-control', 'readonly' => true]) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label">Correo electrónico</label>
                        <div class="col-sm-12">
                            {{ Form::text('business_name', $app_user->email, ['class' => 'form-control', 'readonly' => true]) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label">Teléfono</label>
                        <div class="col-sm-12">
                            {{ Form::text('business_name', $app_user->phone_number, ['class' => 'form-control', 'readonly' => true]) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label">Fecha de nacimiento</label>
                        <div class="col-sm-12">
                            {{ Form::text('business_name', $app_user->birthdate, ['class' => 'form-control', 'readonly' => true]) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label">Estado civil</label>
                        <div class="col-sm-12">
                            {{ Form::text('business_name', $app_user->civil_status, ['class' => 'form-control', 'readonly' => true]) }}
                        </div>
                    </div>

                    <br>
                    <h4>Domicilio</h4>


                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label">Estado</label>
                            <div class="col-sm-12">
                                {{ Form::text('business_name', $app_user->state_id, ['class' => 'form-control', 'readonly' => true]) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Municipio</label>
                            <div class="col-sm-12">
                                {{ Form::text('business_name', $app_user->municipaly_id, ['class' => 'form-control', 'readonly' => true]) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Colonia</label>
                            <div class="col-sm-12">
                                {{ Form::text('business_name', $app_user->colony_id, ['class' => 'form-control', 'readonly' => true]) }}
                            </div>
                        </div>

                        <br>
                        <h4>Información adicional</h4>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Dependientes economicos</label>
                            <div class="col-sm-12">
                                {{ Form::text('business_name', $app_user->economic_dependency, ['class' => 'form-control', 'readonly' => true]) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Licencía</label>
                            <div class="col-sm-12">
                                {{ Form::text('business_name', $app_user->driver_licence, ['class' => 'form-control', 'readonly' => true]) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Tipo de licencia</label>
                            <div class="col-sm-12">
                                {{ Form::select('business_name', array(
                                "tipo_a" => "Tipo A",
                                "tipo_b" => "Tipo B",
                                "tipo_c" => "Tipo C",
                                "tipo_d" => "Tipo D",
                                "tipo_e" => "Tipo E",
                                "tipo_f" => "Tipo F",
                                ),
                                $app_user->driver_licence_type, ['class' => 'form-control', 'disabled' => true]) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Nacionalidad</label>
                            <div class="col-sm-12">
                                {{ Form::text('business_name', $app_user->nationality, ['class' => 'form-control', 'readonly' => true]) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">CURP</label>
                            <div class="col-sm-12">
                                {{ Form::text('business_name', $app_user->curp, ['class' => 'form-control', 'readonly' => true]) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">RFC</label>
                            <div class="col-sm-12">
                                {{ Form::text('business_name', $app_user->rfc, ['class' => 'form-control', 'readonly' => true]) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Sueldo deseado</label>
                            <div class="col-sm-12">
                                {{ Form::select('business_name', ["5_10" => "$5,000 - $10,000", "10_15" => "$10,000 - $15,000", "15_20" => "$15,000 - $20,000", "20_25" => "$20,000 - $25,000", "25" => "$25,000 o más"], $app_user->salary , ['class' => 'form-control', 'disabled' => true]) }}
                            </div>
                        </div>

                        <br>
                        <h4>Nivel de estudios</h4>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Nivel de estudios</label>
                            <div class="col-sm-12">
                                @if(  $app_user->studies() != null )
                                    {{ Form::select('business_name', $study_levels, $app_user->studies()["study_level"], ['class' => 'form-control', 'disabled' => true]) }}
                                @else
                                    {{ Form::select('business_name', $study_levels, "", ['class' => 'form-control', 'disabled' => true]) }}
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Especifica más de tu nivel de estudio</label>
                            <div class="col-sm-12">
                                @if( $app_user->studies() != null )
                                    {{ Form::text('business_name', $app_user->studies()["study_description"], ['class' => 'form-control', 'readonly' => true]) }}
                                @else
                                    {{ Form::text('business_name', "", ['class' => 'form-control', 'readonly' => true]) }}
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Certificaciones</label>
                            <div class="col-sm-12">
                                @if( $app_user->studies() != null )
                                    {{ Form::text('business_name', $app_user->studies()["certification"], ['class' => 'form-control', 'readonly' => true]) }}
                                @else
                                    {{ Form::text('business_name', "", ['class' => 'form-control', 'readonly' => true]) }}
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Área de experiencia</label>
                            <div class="col-sm-12">
                                @if($app_user->studies() != null)
                                    {{ Form::text('business_name', $app_user->studies()["experience_area"], ['class' => 'form-control', 'readonly' => true]) }}
                                @else
                                    {{ Form::text('business_name', "", ['class' => 'form-control', 'readonly' => true]) }}
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Idiomas</label>
                            <div class="col-sm-12">
                                <ul>
                                @foreach($app_user->languages_object() as $language )
                                    <li>&bullet; {{ $language->get_language["language_name"] }}</li>
                                @endforeach
                                </ul>
                            </div>
                        </div>

                        <br>
                        <h4>Experiencia laboral</h4>

                        <div class="row">

                            @foreach($app_user->get_jobs as $item)
                                <div class="col-md-4">
                                    <div class="col-md-12 empleo_card">
                                        <h6 class="m-0"><strong>{{ $item->business_name }}</strong></h6>
                                        <p class="m-0">{{ $item->position }}</p>
                                        <p class="m-0">
                                            @if($item->work_time == "1")
                                                Menos de 1 año
                                            @elseif($item->work_time == "1_2")
                                                Entre 1 y 2 años
                                            @elseif($item->work_time == "2_3")
                                                Entre 2 y 3 años
                                            @else
                                                Más de 3 años
                                            @endif
                                        </p>
                                        @if($item->current_work == 1)
                                            <p class="m-0">Empleo actual</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

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
