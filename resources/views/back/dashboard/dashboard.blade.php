@extends('back.layout.dashboard')

@section('CSS')
    <!-- chartist CSS -->
    <link href="{{ asset('assets/node_modules/morrisjs/morris.css') }}" rel="stylesheet">
@endsection

{{-- Page Title --}}
@section('pageTitle')
    Dashboard
@stop

{{-- Content Title --}}
@section('contentTitle')
    Dashboard
@stop

@section('content_dashboard')

    <!-- Info box -->
    <!-- ============================================================== -->
    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-4 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-success"><i class="ti-bookmark-alt"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0">{{ $total_jobs_published }}</h3>
                            <h5 class="text-muted m-b-0">Empleos registrados</h5></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-4 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-info"><i class="ti-user"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0">{{ $total_app_users }}</h3>
                            <h5 class="text-muted m-b-0">Usuarios registrados</h5></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-4 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-danger"><i class="ti-user"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0">{{ $total_busines_users }}</h3>
                            <h5 class="text-muted m-b-0">Empleadores registrados</h5></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
    <!-- Row -->
    <!-- ============================================================== -->
    <!-- End Info box -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Over Visitor, Our income , slaes different and  sales prediction -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="category_employes" style="display: none;">{!! json_encode($categories_job_count) !!}</div>
                    <h5 class="card-title ">Categorías de empleo con demanda</h5>
                    <div id="morris-donut-chart" class="ecomm-donute" style="height: 317px;"></div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="jobs_apply_by_month" style="display: none;">{!! json_encode($jobs_apply_by_month) !!}</div>
                    <h5 class="card-title">Vacantes postuladas por mes</h5>
                    <div id="morris-area-chart2" style="height: 370px;"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- New Customers List and New Products List -->
    <!-- ============================================================== -->
    <!-- /row -->
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title m-b-0">Ultimos usuarios registrados</h5>
                    <p class="text-muted">Usuarios registrados desde la APP</p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Edad</th>
                                <th>Correo electrónico</th>
                                <th>Fecha de registro</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($last_users as $last_user)
                                <tr>
                                    <td>{{ $last_user->name }} {{ $last_user->father_last_name }} {{ $last_user->mother_last_name }}</td>
                                    <td>{{ $last_user->age }}</td>
                                    <td>{{ $last_user->email }}</td>
                                    <td>{{ date("d/m/Y H:i", strtotime($last_user->created_at)) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title m-b-0">Ultimos empleadores registrados</h5>
                    <p class="text-muted">Empleadores registrados desde la APP</p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Empresa</th>
                                <th>Correo electrónico</th>
                                <th>Fecha de registro</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($last_employers_users as $last_employer)
                                <tr>
                                    <td>{{ $last_employer->business_name }}</td>
                                    <td>{{ $last_employer->email }}</td>
                                    <td>{{ date("d/m/Y H:i", strtotime($last_employer->created_at)) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <!-- ============================================================== -->
    <!-- End Page Content -->

@endsection

@section('JS')
    <script src="{{ asset('assets/node_modules/morrisjs/morris.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ url('template/dist/js/dashboard1.js') }}"></script>
@endsection
