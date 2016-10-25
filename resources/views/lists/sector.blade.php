@extends('layouts.app')

@section('htmlheader_title', 'Listado de Sectores')

@section('contentheader_title', 'Listado de Sectores')

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
                @foreach($sectors as $sector)
                <tr>
                  <td>{{ $sector->name }}</td>
                  <td>{{ $sector->locations()->count() }}</td>
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