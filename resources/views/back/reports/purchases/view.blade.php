@extends('back.layout.dashboard')

@section('contentTitle', 'Facturas generadas de la compra')

@section('topButton')
    <a href="{{ route('purchasesreport.index') }}" class="m-l-15">
        <button type="button" class="btn btn-info d-none d-lg-block"><i class="fas fa-chevron-left"></i> Regresar</button>
    </a>
@stop


{{-- Main Content --}}
@section('content_dashboard')

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Datos de facturación</h4>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label><strong>Razón social:</strong> {{ $invoice_data->social_reason }}</label><br>
                                <label><strong>Nombre comercial:</strong> {{ $invoice_data->comercial_name }}</label><br>
                                <label><strong>RFC:</strong> {{ $invoice_data->rfc }}</label><br>
                                <label><strong>Domicilio fiscal:</strong> {{ $invoice_data->fiscal_address }}</label><br>
                                <label><strong>Correo para enviar facturas:</strong> {{ $invoice_data->email_send_invoice }}</label> <br>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('purchasesreport.generate_invoice', $packages_buyed_by_users->id) }}" class="btn-generate-invoice">
                                <button type="button" class="btn waves-effect waves-light btn-primary">Generar factura</button>
                            </a>
                        </div>
                    </div>

                    <h4 class="card-title">Facturas generadas de la compra</h4>

                    <div class="table-responsive">
                        <table id="table_principal" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" order-by="0" type-order="desc">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Codigo de respuesta</th>
                                <th>Descripción de respuesta</th>
                                <th>Fecha de solicitud</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $item->id  }}</td>
                                    <td>{{ $item->responseCode  }}</td>
                                    <td>{{ $item->responseDescription  }}</td>
                                    <td>{{ date("d/m/Y H:i", strtotime($item->requestDate))  }}</td>
                                    <td>

                                        @if($item->responseCode == 1000)
                                            <a href="{{ route('purchasesreport.download_pdf', $item->id) }}">
                                                <button type="button" class="btn waves-effect waves-light btn-primary">Descargar pdf</button>
                                            </a>
                                            <a href="{{ route('purchasesreport.download_xml', $item->id) }}">
                                                <button type="button" class="btn waves-effect waves-light btn-primary">Descargar xml</button>
                                            </a>
                                        @else
                                            <a href="{{ route('purchasesreport.download_wrong_xml', $item->id) }}">
                                                <button type="button" class="btn waves-effect waves-light btn-primary">Descargar cfdi mal formado</button>
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
    {{ Html::script('system/js/reports/purchases/invoice.js')  }}
@stop

