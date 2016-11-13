@extends('layouts.app')

@section('htmlheader_title', 'Archivos')

@section('contentheader_title', 'Todos los archivos')

@section('main-content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Autor</th>
              <th>Fecha</th>
              <th>Descripción</th>
              <th>Accion</th>
            </tr>
          </thead>
          <tbody>
            @foreach($messages as $message)
            <tr>
              <td>{{ $message->user->name }}</td>
              <td>{{ $message->created_at->format('d-m-Y') }}</td>
              <td>{{ $message->message }}</td>
              <form role="form" action="{{ url('/fileentry/get/'.$message->fileentry->id) }}" method="get">
                <td><button type="submit" class="btn btn-block btn-primary btn-xs">Descargar</button></td>
              </form>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
@endsection
