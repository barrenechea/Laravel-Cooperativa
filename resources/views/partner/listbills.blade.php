@extends('layouts.app')

@section('htmlheader_title', 'Todos mis cobros')

@section('contentheader_title', 'Todos mis cobros')

@section('main-content')
<div class="row">
  <div class="box box-primary">
    <div class="box-body">
      <div class="col-xs-12 table-responsive">
        <table class="table tableresp table-bordered table-striped">
          <thead>
            <tr>
              <th>Fecha emisión</th>
              <th>Fecha vencimiento</th>
              <th>Sector</th>
              <th>Ubicación</th>
              <th>Cobro</th>
              <th>Monto</th>
              <th>Pagado</th>
              <th>Estado</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            @foreach($billdetails as $billdetail)
            <tr>
              <td>{{ $billdetail->created_at->format('d-m-Y') }}</td>
              <td>{{ $billdetail->overdue_date ? $billdetail->overdue_date->format('d-m-Y') : 'No posee' }}</td>
              <td>{{ $billdetail->location->sector->name }}</td>
              <td>{{ $billdetail->location->type->name }} {{ explode('.', $billdetail->location->code)[count(explode('.', $billdetail->location->code)) - 1] }}</td>
              <td>{{ $billdetail->bill->description }}</td>
              <td>${{ (number_format($billdetail->amount, 0, ',', '.')) }}</td>
              <td>${{ (number_format($billdetail->payments()->sum('amount'), 0, ',', '.')) }}</td>
              @if($billdetail->amount <= $billdetail->payments()->sum('amount'))
              <td><span class="label label-success">Pagado</span></td>
              @elseif(!isset($billdetail->overdue_date) || $billdetail->overdue_date->gte(Carbon\Carbon::today()))
              <td><span class="label label-warning">Pendiente</span></td>
              @else
              <td><span class="label label-danger">Atrasado</span></td>
              @endif
              <td><a href="{{ url('partner/payments/'. $billdetail->id ) }}" class="btn btn-block btn-primary btn-xs">Ver detalle</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="box-footer">
        <a href="{{ url('home') }}" class="btn btn-primary">Volver al inicio</a>
      </div>
    </div>
  </div>
</div>
@endsection
