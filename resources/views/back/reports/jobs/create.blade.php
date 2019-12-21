@extends('back.layout.dashboard')

@section('contentTitle', 'Alta de nuevo paquete')

@section('topButton')
    <a href="{{ route('paquetes.index') }}" class="m-l-15"><button type="button" class="btn btn-info d-none d-lg-block"><i class="fas fa-chevron-left"></i> Regresar</button></a>
@stop

@section('content_dashboard')

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-body">

                {{ Form::open(['route' => ('paquetes.store'), 'class' => 'form-horizontal']) }}

                    <div class="form-group">
                        <label>Nombre</label>
                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        <label>Días de duración del plan</label>
                        {{ Form::number('duration_plan_in_days', null, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        <label>Empleos permitidos para publicar</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="total_jobs_to_post" value="check" name="ilimited_total_jobs_to_post">
                            <label class="custom-control-label" for="total_jobs_to_post">Ilimitados</label>
                        </div>
                        {{ Form::number('total_jobs_to_post', null, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        <label>Identidades</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="total_profiles_to_view" value="check" name="ilimited_total_profiles_to_view">
                            <label class="custom-control-label" for="total_profiles_to_view">Ilimitados</label>
                        </div>
                        {{ Form::number('total_profiles_to_view', null, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        <label>Días de duración de la vacante</label>
                        {{ Form::number('duration_in_days', null, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        <label>Publicaciones como destacadas</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="jobs_destacados" value="check" name="ilimited_jobs_destacados">
                            <label class="custom-control-label" for="jobs_destacados">Ilimitados</label>
                        </div>
                        {{ Form::number('jobs_destacados', null, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        <label>Precio</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">$</span>
                            </div>
                            <input type="number" name="price" class="form-control" aria-label="Username" aria-describedby="basic-addon1" step="any">
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary">Guardar</button>

                {{ Form::close() }}

            </div>
        </div>
    </div>

@stop

@section('JS')
    {{ Html::script('system/js/form.js')  }}
    {{ Html::script('system/package/create.js')  }}
@stop
