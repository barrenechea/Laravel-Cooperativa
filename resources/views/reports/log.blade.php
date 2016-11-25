@extends('layouts.app')

@section('htmlheader_title', 'Registro de actividad')

@section('contentheader_title', 'Registro de actividad')

@section('main-content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body table-responsive">
        <table class="table tableresp table-bordered table-striped">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Administrador</th>
              <th>Actividad</th>
            </tr>
          </thead>
          <tbody>
            @foreach($logs as $log)
            <tr>
              <td>{{ $log->created_at->format('d-m-Y H:i') }}hrs.</td>
              <td>{{ $log->user->name }}</td>
              <td>{{ $log->message }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="box-footer">
        <a href="{{ url('/report/logexport') }}" class="btn btn-primary pull-right">Exportar todo a Excel</a>
      </div>
    </div>
  </div>
</div>
@endsection
