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

              <p>Socio{{$partners == 1 ? '' : 'es'}}</p>
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
              <h3 class="box-title">Testing canvas graph</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="chart">
                    <canvas id="salesChart" width="1200" height="150"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
	<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="plugins/chartjs/Chart.min.js"></script>
	<script>
		$(function () {
        var config = {
            type: 'line',
            data: {
                labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio"],
                datasets: [{
		          label: "Egresos Cooperativa",
		          data: [28, 48, 40, 19, 86, 27, 90],
                  borderColor: "rgba(60,141,188,0.8)",
		          backgroundColor: "rgba(60,141,188,0.9)",
        		}]
            },
            options: {
                responsive: false,
                scales: {
                    xAxes: [{
                        display: true,
                        ticks: {
                            userCallback: function(dataLabel, index) {
                                return index % 2 === 0 ? dataLabel : '';
                            }
                        }
                    }],
                    yAxes: [{
                        display: true,
                        beginAtZero: false
                    }]
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById("salesChart").getContext("2d");
            window.myLine = new Chart(ctx, config);
        };
  });
	</script>
@endsection