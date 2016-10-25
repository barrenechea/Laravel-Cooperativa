@extends('layouts.app')

@section('htmlheader_title')
	Inicio
@endsection

@section('contentheader_title')
  Inicio
@endsection

@section('main-content')
	@if($msg)
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
            <div class="box-header with-border">
              <div class="user-block">
                <span class="username">{{ $msg->user->name }}</span>
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
		<div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
		        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
	            <div class="info-box-content">
	            	<span class="info-box-text">Test</span>
	            	<span class="info-box-number">0</span>
	            </div>
	        </div>
	    </div>
	    <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
		        <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>
	            <div class="info-box-content">
	            	<span class="info-box-text">Test</span>
	            	<span class="info-box-number">0</span>
	            </div>
	        </div>
	    </div>
	    <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
		        <span class="info-box-icon bg-blue"><i class="ion ion-ios-people-outline"></i></span>
	            <div class="info-box-content">
	            	<span class="info-box-text">Test</span>
	            	<span class="info-box-number">0</span>
	            </div>
	        </div>
	    </div>
	    <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
		        <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
	            <div class="info-box-content">
	            	<span class="info-box-text">Test</span>
	            	<span class="info-box-number">0</span>
	            </div>
	        </div>
	    </div>
	</div>
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
