@extends('back.layout.dashboard')

@section('contentTitle', 'Reporte de empleos')

@section('topButton')
    @if( $permitions["create"] )
        {{--<a href="{{ route('purchasesreport.create') }}" class="m-l-15"><button type="button" class="btn btn-info d-none d-lg-block"><i class="fa fa-plus-circle"></i> Nuevo paquete</button></a>--}}
    @endif
@stop


{{-- Main Content --}}
@section('content_dashboard')

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Listado de empleos dados de alta</h4>


                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Empleos publicados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Empleos pendientes de publicar</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                            <div class="table-responsive">
                                <table id="table_principal" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Titulo de empleo</th>
                                        <th>Categoria</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        {{--<th>Fecha de publicación</th>--}}
                                        <th>Fecha de baja</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $item)
                                        <tr>
                                            <td>{{ $item->id  }}</td>
                                            <td>{{ str_limit($item->job_title, 30)  }}</td>
                                            <td>{{ $item->categories["category"]  }}</td>
                                            <td>{{ str_limit($item->description, 30)  }}</td>
                                            <td>{{ $item->state  }}</td>
                                            {{--<td>{{ date("d/m/Y H:i", strtotime($item->updated_at))  }}</td>--}}
                                            <td>{{ date("d/m/Y H:i", strtotime($item->disbaled_at))  }}</td>
                                            <td>
                                                <a href="{{ route('jobsreport.view', base64_encode($item->id)) }}" class="ver_detalle">
                                                    <button type="button" class="btn waves-effect waves-light btn-primary"><i class="fas fa-eye"></i> Ver</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                            <div class="table-responsive">
                                <table id="table_principal" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Titulo de empleo</th>
                                        <th>Categoria</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Fecha de publicación/alta</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data_pending as $item)
                                        <tr>
                                            <td>{{ $item->id  }}</td>
                                            <td>{{ str_limit($item->job_title, 30)  }}</td>
                                            <td>{{ $item->categories["category"]  }}</td>
                                            <td>{{ str_limit($item->description, 30)  }}</td>
                                            <td>{{ $item->state  }}</td>
                                            <td>{{ date("d/m/Y H:i", strtotime($item->updated_at))  }}</td>
                                            <td>
                                                <a href="{{ route('jobsreport.publish_job', base64_encode($item->id)) }}" class="btn-publish">
                                                    <button type="button" class="btn waves-effect waves-light btn-success">Publicar empleo</button>
                                                </a>
                                                <a href="{{ route('jobsreport.unpublish_job', base64_encode($item->id)) }}" class="form_unpublish">
                                                    <button type="button" class="btn waves-effect waves-light btn-danger">Rechazar empleo</button>
                                                </a>
                                                <a href="{{ route('jobsreport.view', base64_encode($item->id)) }}" class="ver_detalle">
                                                    <button type="button" class="btn waves-effect waves-light btn-primary"><i class="fas fa-eye"></i> Ver</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>

@stop

{{-- Page JS --}}
@section('JS')
    <script src="{{ asset('assets/node_modules/Chart.js/Chart.min.js') }}"></script>
    {{ Html::script('system/js/table.js')  }}
    {{ Html::script('system/js/reports/jobs/index.js')  }}
@stop

