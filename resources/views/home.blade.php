@extends('layouts.app')

@section('htmlheader_title')
	Inicio
@endsection

@section('contentheader_title')
  Inicio
@endsection

@section('main-content')
	<div class="row">
      <div class="col-md-2 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>{{ $admins }}</h3>

              <p>Administrador{{$admins == 1 ? '' : 'es'}}</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-secret"></i>
            </div>
            <a href="{{ url('/list/admin') }}" class="small-box-footer">
              Ver listado <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
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
              <h3 class="box-title">Consolidado de Egresos Cooperativa</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="chart">
                    <canvas id="salesChart" width="900" height="150"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  <script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
  <script src="{{ asset('/plugins/chartjs/Chart.min.js') }}"></script>
	<script>
$(function () {
  'use strict';
  var salesChart = new Chart($("#salesChart").get(0).getContext("2d"));

  var salesChartData = {
    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio"],
    datasets: [
      {
        label: "Gastos",
        fillColor: "rgba(60,141,188,0.9)",
        strokeColor: "rgba(60,141,188,0.8)",
        pointColor: "#3b8bba",
        pointStrokeColor: "rgba(60,141,188,1)",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(60,141,188,1)",
        data: [28, 48, 40, 19, 86, 27]
      }
    ]
  };

  var salesChartOptions = {
    //Boolean - If we should show the scale at all
    showScale: true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: true,
    //String - Colour of the grid lines
    scaleGridLineColor: "rgba(0,0,0,.05)",
    //Number - Width of the grid lines
    scaleGridLineWidth: 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,
    //Boolean - Whether the line is curved between points
    bezierCurve: true,
    //Number - Tension of the bezier curve between points
    bezierCurveTension: 0.3,
    //Boolean - Whether to show a dot for each point
    pointDot: true,
    //Number - Radius of each point dot in pixels
    pointDotRadius: 2,
    //Number - Pixel width of point dot stroke
    pointDotStrokeWidth: 1,
    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius: 20,
    //Boolean - Whether to show a stroke for datasets
    datasetStroke: true,
    //Number - Pixel width of dataset stroke
    datasetStrokeWidth: 2,
    //Boolean - Whether to fill the dataset with a color
    datasetFill: true,
    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%=datasets[i].label%></li><%}%></ul>",
    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: false,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true,
  };

  //Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);
});
	</script>
@endsection