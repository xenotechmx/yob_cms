@extends('back.layout.dashboard')

@section('contentTitle', 'Reporte de compras')

@section('topButton')
    @if( $permitions["create"] )
        {{--<a href="{{ route('purchasesreport.create') }}" class="m-l-15"><button type="button" class="btn btn-info d-none d-lg-block"><i class="fa fa-plus-circle"></i> Nuevo paquete</button></a>--}}
    @endif
@stop


{{-- Main Content --}}
@section('content_dashboard')

    <div class="row">

        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Estatus de compras</h4>
                    <div>
                        <canvas id="chart1" height="120"></canvas>
                    </div>
                </div>

                <div id="graph_vs" style="display: none;">
                    {{ json_encode($approved_vs_pending) }}
                </div>

            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Cantidad de paquetes comprados</h4>
                    <div>
                        <canvas id="chart2" height="120"></canvas>
                    </div>
                </div>

                <div id="graph_data" style="display: none;">
                    {{ json_encode($data_graph) }}
                </div>

            </div>
        </div>


        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Listado de paquetes comprados</h4>

                    <div class="table-responsive">
                        <table id="table_principal" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" order-by="1" type-order="asc">
                            <thead>
                            <tr>
                                <th>Código de referencia</th>
                                <th>Estatus de pago</th>
                                <th>Tipo de pago</th>
                                <th>Paquete adquirido</th>
                                <th>Empresa</th>
                                <th>Fecha de compra</th>
                                <th>Estatus de factura</th>
                                <th>Estatus de plan</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $item->reference_code  }}</td>
                                    <td>{!! $item->status_translate !!}</td>
                                    <td>{{ $item->type_translate  }}</td>
                                    <td>{{ $item->package_name  }}</td>
                                    <td>{{ $item->get_user["business_name"]  }}</td>
                                    <td>{{ $item->created_at_translate  }}</td>
                                    <td>
                                        @if($item->status == "APPROVED")
                                            @if($item->is_require_invoice == 1)
                                                @if($item->is_invoice_generated == 1 )
                                                    {!! ($item->already_invoice_generated()) ? 'Factura generada' : '<font style="color: #f74444; font-weight: bold;">Hubo un problema al generar la factura, favor de revisar</font>'  !!}
                                                @else
                                                    <font style="color: #f74444; font-weight: bold;">No se ha generado la factura, favor de revisar</font>
                                                @endif
                                            @else
                                                No se requiere factura
                                            @endif
                                        @else
                                            @if($item->is_require_invoice)
                                                El pago no se ha procesado para generar factura
                                            @else
                                                No se requiere factura
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->deleted_at == null)
                                            @if($item->status == "APPROVED")
                                                <p style="text-decoration:none;">Vigente</p>
                                            @endif
                                        @else
                                            <p style="text-decoration:line-through;">Vencido</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->is_require_invoice == 1)
                                            <a href="{{ route('purchasesreport.view', [$item->id]) }}">
                                                <button type="button" class="btn btn-info d-none d-lg-block"><i class="fas fa-file-alt"></i> Ver factura</button>
                                            </a>
                                        @endif
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

@stop

{{-- Page JS --}}
@section('JS')
    <script src="{{ asset('assets/node_modules/Chart.js/Chart.min.js') }}"></script>
    {{ Html::script('system/js/table.js')  }}
    {{ Html::script('system/js/reports/purchases/index.js')  }}
@stop

