@extends('back.layout.dashboard')

@section('contentTitle', 'Perfiles de usuario')

@section('topButton')
    @if( $permitions["create"] )
        <a href="{{ route('profile_create') }}" class="m-l-15"><button type="button" class="btn btn-info d-none d-lg-block"><i class="fa fa-plus-circle"></i> Nuevo perfil</button></a>
    @endif
@stop


@section('content_dashboard')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="table_principal" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $item->id  }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @if( $permitions["edit"] )
                                            <a href="{{route('profile.edit', base64_encode($item->id) )}}"><button type="button" class="btn waves-effect waves-light btn-success"><i class="fas fa-edit"></i> Editar</button></a>
                                        @endif
                                        @if( $permitions["delete"] )
                                            <a href="{{ route('profile.delete', base64_encode($item->id)) }}" class="btn-delete"><button type="button" class="btn waves-effect waves-light btn-danger"><i class="fas fa-minus-circle"></i> Eliminar</button></a>
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


@section('JS')
    {{ Html::script('system/js/table.js')  }}
@stop
