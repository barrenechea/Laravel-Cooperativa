@extends('layouts.app')

@section('htmlheader_title', 'Inicio')

@section('contentheader_title')
Bienvenido(a), {{ Auth::user()->name }}!
@endsection

@section('main-content')
@if($msg)
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <div class="user-block">
          <span class="username">Mensaje de {{ $msg->user->name }}</span>
          <span class="description">{{ $msg->created_at->diffForHumans() }}</span>
        </div>
      </div>
      <div class="box-body">
        <p>{{ $msg->message }}</p>
      </div>
    </div>
  </div>
</div>
@endif
@if($lastbills->count() > 0)
<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
      <h3 class="box-title">Mis últimos cinco cobros</h3>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-condensed table-striped no-margin">
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
              @foreach($lastbills as $billdetail)
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
                <td><a href="{{ url('partner/payments/'. $billdetail->id ) }}" class="btn btn-block btn-primary btn-xs" {{ $billdetail->payments()->count() ? '' : '' }}>Ver detalle</a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer clearfix">
        <a href="{{ url('partner/mybills') }}" class="btn btn-sm btn-default btn-flat pull-right">Ver todos mis cobros</a>
      </div>
    </div>
  </div>
</div>
@endif
<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
      <h3 class="box-title">Mis ubicaciones</h3>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-condensed table-striped no-margin">
            <thead>
              <tr>
                <th>Sector</th>
                <th>Tipo</th>
                <th>Código</th>
              </tr>
            </thead>
            <tbody>
              @foreach(Auth::user()->partner->locations as $location)
              <tr>
                <td>{{ $location->sector->name }}</td>
                <td>{{ $location->type->name }}</td>
                <td>{{ $location->code }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Flujo monetario Cooperativa - Últimos 6 meses</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div id="highchartscontainer" style="height:250px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('/plugins/highcharts/highcharts.js') }}"></script>
<script>
  $(function () {
    Highcharts.setOptions({
      lang: {
        thousandsSep: '.'
      }
    });

    $('#highchartscontainer').highcharts({
      chart: {
        type: 'column',
      },
      title: {
        text: ''
      },
      xAxis: {
        categories: [
        @foreach ($months as $month)
        '{{ $month['name'] }}',
        @endforeach
        ],
      },
      yAxis: {
        title: {
          text: 'Dinero'
        },
        labels: {
          formatter: function () {
            return '$' + this.axis.defaultLabelFormatter.call(this);
          }            
        }
      },
      tooltip: {
        shared: true,
        valuePrefix: ' $'
      },
      credits: {
        enabled: false
      },
      plotOptions: {
        areaspline: {
          fillOpacity: 0.5
        }
      },
      series: [{
        name: 'Ingresos',
        data: [
        @foreach ($months as $month)
        {{ $month['income'] }},
        @endforeach
        ]
      }, {
        name: 'Egresos',
        data: [
        @foreach ($months as $month)
        {{ $month['outcome'] }},
        @endforeach
        ]
      }]
    });
  });
</script>
@endsection