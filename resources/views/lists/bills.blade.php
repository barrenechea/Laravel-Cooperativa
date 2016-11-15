@extends('layouts.app')

@section('htmlheader_title', 'Listado de Cobros')

@section('contentheader_title', 'Listado de Cobros')

@section('main-content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Descripción</th>
              <th>Monto</th>
              <th>Cobro por atraso</th>
              @can('modify_bill')
              <th>Accion</th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @foreach($bills as $bill)
            <tr>
              <td>{{ $bill->description }}</td>
              <td>{{ $bill->is_uf ? ($bill->amount . ' UF') : '$'.(number_format($bill->amount, 0, ',', '.')) }}</td>
              <td>{{ $bill->overdue_amount ? ($bill->overdue_is_uf ? ($bill->overdue_amount . 'UF') : '$'.(number_format($bill->overdue_amount, 0, ',', '.'))) : 'No posee' }}</td>
              @can('modify_bill')
              <td><a href="{{ url('bill/update/'.$bill->id ) }}" class="btn btn-block btn-primary btn-xs">Modificar</a></td>
              @endcan
            </tr>
            @endforeach
          </table>
        </div>
        @can('add_bill')
        <div class="box-footer">
          <a href="{{ url('bill/create') }}" class="btn btn-primary pull-right">Agregar nuevo cobro</a>
        </div>
        @endcan
      </div>
    </div>
  </div>
  @endsection
