@extends('layouts.app')

@section('htmlheader_title', 'Información del cobro')

@section('contentheader_title', 'Información del cobro')

@section('main-content')
<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box-header text-center">
              <h3 class="box-title">Información del cobro - {{ $billdetail->bill->description }}{{ $billdetail->vfpcode !== $billdetail->bill->vfpcode ? ' [Multa por atraso]' : '' }}</h3>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4 col-xs-4">
            <div class="description-block border-right">
              <span class="description-text">FECHA DE EMISIÓN</span>
              <h5 class="description-header">{{ $billdetail->created_at->format('d-m-Y') }}</h5>
            </div>
          </div>
          <div class="col-sm-4 col-xs-4">
            <div class="description-block border-right">
              <span class="description-text">FECHA DE VENCIMIENTO</span>
              @if(isset($billdetail->overdue_date))
              <h5 class="description-header">{{ $billdetail->overdue_date->format('d-m-Y') }}</h5>
              @else
              <h5 class="description-header">NO POSEE</h5>
              @endif
            </div>
          </div>
          <div class="col-sm-4 col-xs-4">
            <div class="description-block border-right">
              <span class="description-text">MONTO A PAGAR</span>
              <h5 class="description-header">${{ (number_format($billdetail->amount, 0, ',', '.')) }}</h5>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box-header text-center">
            <h3 class="box-title">Pagos realizados</h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Fecha pago</th>
                <th>Monto pago</th>
                <th>N° Documento</th>
                <th>Generado por</th>
              </tr>
            </thead>
            <tbody>
              @if($billdetail->payments()->count())
              @foreach($billdetail->payments as $payment)
              <tr>
                <td>{{ $payment->created_at->format('d-m-Y H:i:s') }}</td>
                <td>${{ (number_format($payment->amount, 0, ',', '.')) }}</td>
                <td>{{ $payment->document_id }}</td>
                <td>{{ $payment->user->name ?? 'Sistema Contable Cooperativa' }}</td>
              </tr>
              @endforeach
              @else
              <td colspan="4"><p class="text-center">No posee pagos registrados en el sistema</p></td>
              @endif
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer no-print">
        <a href="{{ url('home') }}" class="btn btn-primary">Volver al inicio</a>
        <button onclick="printpage()" class="btn btn-default pull-right"><i class="fa fa-print"></i> Imprimir</button>
      </div>
    </div>
  </div>
</div>
<script>
  function printpage() {
    window.print();
  }
</script>
@endsection