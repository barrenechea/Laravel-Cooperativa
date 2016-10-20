@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection

@section('contentheader_title')
  Bienvenido(a), {{Auth::user()->name}}!
@endsection

@section('main-content')
	@if(Auth::user()->is_admin)
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
		        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
	            <div class="info-box-content">
	            	<span class="info-box-text">Test</span>
	            	<span class="info-box-number">0</span>
	            </div><!-- /.info-box-content -->
	        </div><!-- /.info-box -->
	    </div><!-- /.col -->
	    <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
		        <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>
	            <div class="info-box-content">
	            	<span class="info-box-text">Test</span>
	            	<span class="info-box-number">0</span>
	            </div><!-- /.info-box-content -->
	        </div><!-- /.info-box -->
	    </div><!-- /.col -->
	    <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
		        <span class="info-box-icon bg-blue"><i class="ion ion-ios-people-outline"></i></span>
	            <div class="info-box-content">
	            	<span class="info-box-text">Test</span>
	            	<span class="info-box-number">0</span>
	            </div><!-- /.info-box-content -->
	        </div><!-- /.info-box -->
	    </div><!-- /.col -->
	    <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
		        <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
	            <div class="info-box-content">
	            	<span class="info-box-text">Test</span>
	            	<span class="info-box-number">0</span>
	            </div><!-- /.info-box-content -->
	        </div><!-- /.info-box -->
	    </div><!-- /.col -->
	</div><!-- /.row -->
	@endif
	<div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Testing canvas graph</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="salesChart" width="1200" height="150"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>
				<div class="panel-body">
					{{ trans('adminlte_lang::message.logged') }}
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
