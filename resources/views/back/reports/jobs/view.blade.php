<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-body text-left">

                <h3>Datos generales</h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Empresa</strong></label>
                            <p>{{ $job->employer["business_name"] }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Titulo de la vacante</strong></label>
                            <p>{{ $job->job_title }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Categoría</strong></label>
                            <p>{{ $job->categories["category"] }}</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><strong>Descripción</strong></label>
                            <p>{{ $job->description }}</p>
                        </div>
                    </div>
                </div>


                <h3>Requisitos</h3>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Edad</strong></label>
                            <p>{{ $job->minimun_age  }}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Genero</strong></label>
                            <p>{{ $job->sex }}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Escolaridad</strong></label>
                            <p>{{ $job->school_grade["school_grade"] }}</p>
                        </div>
                    </div>
                </div>


                <div class="row">
                    {{--<div class="col-md-4">--}}
                    {{--<div class="form-group">--}}
                    {{--<label><strong>Experiencia</strong></label>--}}
                    {{--<p>{{ $job->experience }}</p>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Idiomas</strong></label>
                            <p>{{ $job->lan }}</p>
                        </div>
                    </div>
                    {{--<div class="col-md-4">--}}
                    {{--<div class="form-group">--}}
                    {{--<label><strong>Prestaciones</strong></label>--}}
                    {{--<p>{{ $job->benefist }}</p>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-12">--}}
                    {{--<div class="form-group">--}}
                    {{--<label><strong>Funciones</strong></label>--}}
                    {{--<p>{{ $job->functions }}</p>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                </div>


                <br>
                <h3>Lugar del empleo</h3>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Calle</strong></label>
                            <p>{{ $job->street }}</p>
                        </div>
                    </div>
                    {{--<div class="col-md-4">--}}
                    {{--<div class="form-group">--}}
                    {{--<label><strong>Número</strong></label>--}}
                    {{--<p>{{ $job->number }}</p>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-4">--}}
                    {{--<div class="form-group">--}}
                    {{--<label><strong>Código Postal</strong></label>--}}
                    {{--<p>{{ $job->postal_code }}</p>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Estado</strong></label>
                            <p>{{ $job->state }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Municipio</strong></label>
                            <p>{{ $job->municipaly }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Colonia</strong></label>
                            <p>{{ $job->colony }}</p>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Indicaciones como llegar</strong></label>
                            <p>{{ $job->how_to_go }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>¿Vacante destacada?</strong></label>
                            <p>{{ ($job->highlight_job ? "Si" : "No") }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>¿Vacante privada?</strong></label>
                            <p>{{ ($job->is_private? "Si" : "No") }}</p>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>

</div>


