@extends('back.layout.dashboard')

@section('contentTitle', 'Edición de paquete')

@section('topButton')
    <a href="{{ route('paquetes.index') }}" class="m-l-15"><button type="button" class="btn btn-info d-none d-lg-block"><i class="fas fa-chevron-left"></i> Regresar</button></a>
@stop

@section('content_dashboard')

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-body">

                {{ Form::open(['route' => array('paquetes.update', base64_encode($data->id)), 'class' => 'form-horizontal']) }}

                <div class="form-group">
                    <label>Nombre</label>
                    {{ Form::text('name', $data->name, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    <label>Días de duración del plan</label>
                    {{ Form::number('duration_plan_in_days', $data->duration_plan_in_days, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    <label>Empleos permitidos para publicar</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="total_jobs_to_post" value="check" name="ilimited_total_jobs_to_post" <?php echo ($data->total_jobs_to_post == -1) ? "checked" : "" ?> >
                        <label class="custom-control-label" for="total_jobs_to_post">Ilimitados</label>
                    </div>
                    {{ Form::number('total_jobs_to_post', ($data->total_jobs_to_post == -1) ? "" : $data->total_jobs_to_post, ['class' => 'form-control', "style" => (($data->total_jobs_to_post == -1) ? "display:none;" : "") ]) }}
                </div>

                <div class="form-group">
                    <label>Identidades</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="total_profiles_to_view" value="check" name="ilimited_total_profiles_to_view" <?php echo ($data->total_profiles_to_view == -1) ? "checked" : "" ?> >
                        <label class="custom-control-label" for="total_profiles_to_view">Ilimitados</label>
                    </div>
                    {{ Form::number('total_profiles_to_view', ($data->total_profiles_to_view == -1) ? "" : $data->total_profiles_to_view, ['class' => 'form-control', "style" => (($data->total_profiles_to_view == -1) ? "display:none;" : "") ]) }}
                </div>

                <div class="form-group">
                    <label>Días de duración</label>
                    {{ Form::number('duration_in_days', ($data->duration_in_days == -1) ? "" : $data->duration_in_days, ['class' => 'form-control', "style" => (($data->duration_in_days == -1) ? "display:none;" : "")]) }}
                </div>

                <div class="form-group">
                    <label>Publicaciones como destacadas</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="jobs_destacados" value="check" name="ilimited_jobs_destacados" <?php echo ($data->destacable == -1) ? "checked" : "" ?>>
                        <label class="custom-control-label" for="jobs_destacados">Ilimitados</label>
                    </div>
                    {{ Form::number('jobs_destacados', ($data->destacable == -1) ? "" : $data->destacable, ['class' => 'form-control', "style" => (($data->destacable == -1) ? "display:none;" : "")]) }}
                </div>

                <div class="form-group">
                    <label>Precio</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">$</span>
                        </div>
                        <input type="number" name="price" class="form-control" aria-describedby="basic-addon1" value="{{ $data->price }}" step="any">
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
    {{ Html::script('system/package/edit.js')  }}
@stop
