@extends('back.layout.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Edición de Requisición
@stop

{{-- Content Title --}}
@section('contentTitle')
    Edición de Requisición
@stop

{{-- Page Top Button --}}
@section('pageTopButton')
    <a href="{{ url('cms/dashboard/catalogo/requisiciones') }}" class="btn btn-info"><i class="icofont icofont-rewind"></i> Regresar</a>
@stop

{{-- Main Content --}}
@section('mainContent')
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-block">

                    {{ Form::open(['url' => url('cms/dashboard/catalogo/requisiciones/update/'.$id) ]) }}

                        {{ Form::hidden('id', $data->id, ['class' => 'form-control']) }}

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Puesto</label>
                            <div class="col-sm-12">
                                {{ Form::select('job', $job_catalog, $data->job, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Estado</label>
                            <div class="col-sm-12">
                                {{ Form::select('state', $states_catalog, $data->state, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Municipio</label>
                            <div class="col-sm-12">
                                {{ Form::select('municipaly', $municipaly_catalog, $data->municipaly, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Título de empleo</label>
                            <div class="col-sm-12">
                                {{ Form::text('title', $data->title, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Descripción</label>
                            <div class="col-sm-12">
                                {{ Form::textarea('description', $data->description, ['class' => 'form-control']) }}
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
    <script>
        $(document).ready(function () {

            $(this).on("change", "select[name='state']", function () {

                var state = $(this).val();

                var data = {};
                data.estado = state;
                $.ajax({
                    url: "../get_municipio_by_estado",
                    type: "GET",
                    data: data,
                    dataType: "JSON",
                    error: function (e) {
                        console.log(e);
                    },
                    success: function (result) {
                        console.log(result);
                        $("select[name='municipaly']").html(result);
                    }
                });

            });

        });
    </script>
@stop
