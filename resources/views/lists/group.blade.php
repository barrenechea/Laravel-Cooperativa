@extends('layouts.app')

@section('htmlheader_title', 'Listado de Grupos')

@section('contentheader_title', 'Listado de Grupos')

@section('main-content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Descripción</th>
                  <th>Ubicaciones asociadas</th>
                  <th>Accion</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                <tr>
                  <td>{{ $group->description }}</td>
                  <td>{{ $group->locations()->count() }}</td>
                  <td>{{ $group->id }}</td>
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
