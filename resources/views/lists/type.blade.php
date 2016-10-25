@extends('layouts.app')

@section('htmlheader_title', 'Listado de Tipos')

@section('contentheader_title', 'Listado de Tipos')

@section('main-content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Ubicaciones asociadas</th>
                  <th>Accion</th>
                </tr>
                </thead>
                <tbody>
                @foreach($types as $type)
                <tr>
                  <td>{{ $type->name }}</td>
                  <td>{{ $type->locations()->count() }}</td>
                  <td>{{ $type->id }}</td>
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