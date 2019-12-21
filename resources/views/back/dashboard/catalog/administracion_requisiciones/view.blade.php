@extends('back.layout.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Administración de Requisiciónes
@stop

{{-- Content Title --}}
@section('contentTitle')
    Administración de Requisiciónes
@stop

{{-- Page Top Button --}}
@section('pageTopButton')
    <a href="{{ url('cms/dashboard/catalogo/administracion_requisiciones') }}" class="btn btn-info"><i class="icofont icofont-rewind"></i> Regresar</a>
@stop

{{-- Main Content --}}
@section('mainContent')
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-block">

                    {{ Form::open(['url' => url('cms/dashboard/catalogo/administracion_requisiciones/update/'.$requisicion->id) ]) }}

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Estatus</label>
                            <div class="col-sm-12">
                                {{ Form::select('status', $status, $requisicion->status, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Puesto</label>
                            <div class="col-sm-12">
                                {{ Form::select('job', $job_catalog, $requisicion->job, ['class' => 'form-control', 'disabled' => "true"]) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Estado</label>
                            <div class="col-sm-12">
                                {{ Form::select('state', $states_catalog, $requisicion->state, ['class' => 'form-control', 'disabled' => "true"]) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Municipio</label>
                            <div class="col-sm-12">
                                {{ Form::select('municipaly', $municipaly_catalog, $requisicion->municipaly, ['class' => 'form-control', 'disabled' => "true"]) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Título de empleo</label>
                            <div class="col-sm-12">
                                {{ Form::text('title', $requisicion->title, ['class' => 'form-control', 'disabled' => "true"]) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Descripción</label>
                            <div class="col-sm-12">
                                {{ Form::textarea('description', $requisicion->description, ['class' => 'form-control', 'disabled' => "true"]) }}
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
    {{--<script>--}}
        {{--$(document).ready(function () {--}}

            {{--$(this).on("change", "select[name='state']", function () {--}}

                {{--var state = $(this).val();--}}

                {{--var data = {};--}}
                {{--data.estado = state;--}}
                {{--$.ajax({--}}
                    {{--url: "get_municipio_by_estado",--}}
                    {{--type: "GET",--}}
                    {{--data: data,--}}
                    {{--dataType: "JSON",--}}
                    {{--error: function (e) {--}}
                        {{--console.log(e);--}}
                    {{--},--}}
                    {{--success: function (result) {--}}
                        {{--console.log(result);--}}
                        {{--$("select[name='municipaly']").html(result);--}}
                    {{--}--}}
                {{--});--}}

            {{--});--}}

        {{--});--}}
    {{--</script>--}}
@stop
