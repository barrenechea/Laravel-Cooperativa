@extends('layouts.app')

@section('htmlheader_title', 'Listado de Cobros')

@section('contentheader_title', 'Listado de Cobros')

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
              <th>Monto</th>
              <th>Cobro por atraso</th>
              <th>Accion</th>
            </tr>
          </thead>
          <tbody>
            @foreach($bills as $bill)
            <tr>
              <td>{{ $bill->description }}</td>
              <td>{{ $bill->is_uf ? ($bill->amount . ' UF') : '$'.(number_format($bill->amount, 0, ',', '.')) }}</td>
              <td>{{ $bill->overdue_amount ? ($bill->overdue_is_uf ? ($bill->overdue_amount . 'UF') : '$'.(number_format($bill->overdue_amount, 0, ',', '.'))) : 'No posee' }}</td>
              <td><a href="#" class="btn btn-block btn-primary btn-xs">Modificar</a></td>
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
