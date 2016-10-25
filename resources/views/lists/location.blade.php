@extends('layouts.app')

@section('htmlheader_title', 'Listado de Ubicaciones')

@section('contentheader_title', 'Listado de Ubicaciones')

@section('main-content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sector</th>
                  <th>Tipo</th>
                  <th>Código</th>
                  <th>Socio asociado</th>
                  <th>Acción</th>
                </tr>
                </thead>
                <tbody>
                @foreach($locations as $location)
                <tr>
                  <td>{{ $location->sector->name }}</td>
                  <td>{{ $location->type->name }}</td>
                  <td>{{ $location->code }}</td>
                  <td>{{ $location->partner ? $location->partner->user->name : 'No posee' }}</td>
                  <td><a href="#" class="btn btn-block btn-primary btn-xs">Ver detalle</a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
@endsection
