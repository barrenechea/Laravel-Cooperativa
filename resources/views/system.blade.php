@extends('layouts.app')

@section('htmlheader_title', 'Información del servidor')

@section('contentheader_title')
Ubuntu Server 16.04.1 LTS - Kernel  {{ str_replace('-generic', '', php_uname('r')) }}
@endsection

@section('main-content')
@if($pct >= 90)
<div class="row">
  <div class="col-md-12">
    <div class="alert alert-danger">
      <h4><i class="icon fa fa-info"></i> Mensaje del servidor</h4>
      El espacio de almacenamiento en el servidor está llegando a su límite. Se recomienda realizar una mantención lo antes posible.
    </div>
  </div>
</div>
@endif
<div class="row">
  <div class="col-sm-offset-3 col-md-offset-3 col-md-6 col-sm-6 col-xs-12">
    <!-- small box -->
    <div class="info-box bg-{{ $pct < 75 ? 'green' : ($pct < 90 ? 'yellow' : 'red') }}">
      <span class="info-box-icon"><i class="fa fa-hdd-o"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Disco SSD</span>
        <span class="info-box-number">{{ $used }} GB / {{ $total }} GB</span>

        <div class="progress">
          <div class="progress-bar" style="width: {{ $pct }}%"></div>
        </div>
        <span class="progress-description">
          {{$pct}}% ocupado
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </div>
  <div class="col-sm-offset-3 col-md-offset-3 col-md-6 col-sm-6 col-xs-12">
    <!-- small box -->
    <div class="info-box bg-blue">
      <span class="info-box-icon"><i class="fa fa-database"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Motor de base de datos</span>
        <span class="info-box-number">{{ DB::connection()->getPdo()->query('select version()')->fetchColumn() }}</span>

        <div class="progress">
          <div class="progress-bar" style="width: 0"></div>
        </div>
        <span class="progress-description">
          Versión del motor corriendo actualmente
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </div>
  <div class="col-sm-offset-3 col-md-offset-3 col-md-6 col-sm-6 col-xs-12">
    <!-- small box -->
    <div class="info-box bg-purple">
      <span class="info-box-icon"><i class="fa fa-globe"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Servidor web</span>
        <span class="info-box-number">Todo</span>

        <div class="progress">
          <div class="progress-bar" style="width: 0"></div>
        </div>
        <span class="progress-description">
          Versión del servidor web corriendo actualmente
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-offset-3 col-md-offset-3 col-md-6 col-sm-6 col-xs-12">
    <div style="padding: 10px 10px; text-align: center;">
      <div class="text-muted">
        <p>Plataforma desarrollada en:</p>
        <img src="{{ asset('/img/laravel_logo.png') }}" alt="Laravel Logo" />
      </div>
    </div>
  </div>
</div>
@endsection