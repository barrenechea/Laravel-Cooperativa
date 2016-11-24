@extends('layouts.app')

@section('htmlheader_title', 'Reporte de morosos')

@section('contentheader_title', 'Reporte de morosos')

@section('main-content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Socio</th>
              <th>Ubicación</th>
              <th>Cobro</th>
              <th>Fecha emisión</th>
              <th>Días transcurridos</th>
              <th>Monto a pagar</th>
              <th>Monto pagado</th>
              <th>Teléfono</th>
              <th>Dirección</th>
            </tr>
          </thead>
          <tbody>
            @foreach($billdetails as $billdetail)
            <tr>
              <td>{{ $billdetail->partner->user->name }}</td>
              <td>{{ $billdetail->location->code }}</td>
              <td>{{ $billdetail->bill->description }}</td>
              <td>{{ $billdetail->created_at->format('d-m-Y') }}</td>
              <td>{{ $billdetail->created_at->startOfDay()->diffInDays(Carbon\Carbon::today()) }}</td>
              <td>${{ (number_format($billdetail->amount, 0, ',', '.')) }}</td>
              <td>${{ (number_format($billdetail->payments()->sum('amount'), 0, ',', '.')) }}</td>
              <td>{{ $billdetail->partner->phone === ' ' ? 'No llenado' : $billdetail->partner->phone }}</td>
              <td>{{ $billdetail->partner->address === ' ' ? 'No llenado' : $billdetail->partner->address }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection