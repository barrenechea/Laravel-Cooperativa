@extends('layouts.app')

@section('htmlheader_title', 'Mensajes')

@section('contentheader_title', 'Todos los mensajes')

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
              <th>Mensaje</th>
            </tr>
          </thead>
          <tbody>
            @foreach($messages as $message)
            <tr>
              <td>{{ $message->user->name }}</td>
              <td>{{ $message->created_at->format('d-m-Y') }}</td>
              <td>{{ $message->message }}</td>
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