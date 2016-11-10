@extends('layouts.app')

@section('htmlheader_title', 'Inicio')

@section('contentheader_title')
Bienvenido(a), {{ Auth::user()->name }}!
@endsection

@section('main-content')
<div class="row">
  <div class="col-md-2 col-sm-6 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3>{{ $sectors }}</h3>

        <p>Sectores</p>
      </div>
      <div class="icon">
        <i class="fa fa-building"></i>
      </div>
      <a href="{{ url('/list/sector') }}" class="small-box-footer">
        Ver listado <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-md-2 col-sm-6 col-xs-12">
    <div class="small-box bg-red">
      <div class="inner">
        <h3>{{ $types }}</h3>

        <p>Tipos</p>
      </div>
      <div class="icon">
        <i class="fa fa-filter"></i>
      </div>
      <a href="{{ url('/list/type') }}" class="small-box-footer">
        Ver listado <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-md-2 col-sm-6 col-xs-12">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>{{ $locations }}</h3>
        <p>Ubicaciones</p>
      </div>
      <div class="icon">
        <i class="fa fa-shopping-bag"></i>
      </div>
      <a href="{{ url('/list/location') }}" class="small-box-footer">
        Ver listado <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-md-2 col-sm-6 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{ $groups }}</h3>

        <p>Grupos</p>
      </div>
      <div class="icon">
        <i class="fa fa-users"></i>
      </div>
      <a href="{{ url('/list/group') }}" class="small-box-footer">
        Ver listado <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-md-2 col-sm-6 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-light-blue">
      <div class="inner">
        <h3>{{ $partners }}</h3>

        <p>Socio{{$partners == 1 ? '' : 's'}}</p>
      </div>
      <div class="icon">
        <i class="fa fa-user"></i>
      </div>
      <a href="{{ url('/list/partner') }}" class="small-box-footer">
        Ver listado <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-md-2 col-sm-6 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-purple">
      <div class="inner">
        <h3>{{ $bills }}</h3>

        <p>Cobro{{$bills == 1 ? '' : 's'}}</p>
      </div>
      <div class="icon">
        <i class="fa fa-money"></i>
      </div>
      <a href="{{ url('/list/bills') }}" class="small-box-footer">
        Ver listado <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
</div>
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