@extends('layouts.app')

@section('htmlheader_title', 'Información del servidor')

@section('contentheader_title', 'Información del servidor')

@section('main-content')
@if($data['pct'] >= 90)
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
  <div class="col-md-offset-3 col-md-6">
    <div class="box box-widget widget-user-2">
      <div class="widget-user-header bg-blue">
        <div class="widget-user-image">
          <img class="img-circle" src="{{ asset('/img/avatar.png') }}" alt="User Avatar">
        </div>
        <h3 class="widget-user-username">Cooperativa de Servicios Alameda Maipú</h3>
        <h5 class="widget-user-desc">Reporte de servidor</h5>
      </div>
      <div class="box-footer no-padding">
        <ul class="nav nav-stacked">
          <li><a href="#">Sistema Operativo <span class="pull-right badge bg-blue">Ubuntu Server 16.04.1 LTS - Kernel  {{ str_replace('-generic', '', php_uname('r')) }}</span></a></li>
          <li><a href="#">Servidor web <span class="pull-right badge bg-blue">{{ $webengine }}</span></a></li>
          <li><a href="#">Motor base de datos <span class="pull-right badge bg-blue">{{ $dbengine }}</span></a></li>
          <li><a href="#">Almacenamiento - Total <span class="pull-right badge bg-blue">{{ $data['total'] }} GB</span></a></li>
          <li><a href="#">Almacenamiento - En uso <span class="pull-right badge bg-blue">{{ $data['used'] }} GB</span></a></li>
          <li><a href="#">Almacenamiento - Porcentaje disponible <span class="pull-right badge bg-{{ $data['pct'] < 75 ? 'green' : ($data['pct'] < 90 ? 'yellow' : 'red') }}">{{ $data['pct'] }}%</span></a></li>
          @can('mail_ssd_warning')
          <li><input type="button" value="Administrar alertas de almacenamiento" data-toggle="modal" data-target="#modal" class="btn btn-block bg-blue btn-flat"></li>
          @endcan
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-offset-3 col-md-offset-3 col-md-6 col-sm-6 col-xs-12">
    <div style="padding: 10px 10px; text-align: center;">
      <div class="text-muted">
        <p>Plataforma desarrollada en:</p>
        <img src="{{ asset('/img/laravel_logo.png') }}" alt="Laravel Logo" style="max-width: 200px; max-height: 100%;" />
      </div>
    </div>
  </div>
</div>
@can('mail_ssd_warning')
<div class="modal fade modal-primary" id="modal" role="dialog" aria-labelledby="myModalLabel">
  <form role="form" class="form-horizontal" action="{{ url('/systemstatus') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Alertas de almacenamiento</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Administradores</label>
                <div class="col-sm-9">
                  <select class="form-control select2" style="width: 100%;" id="admins[]" name="admins[]" multiple="multiple" required>
                    @foreach($admins as $admin)
                    <option value="{{ $admin->id }}" {{ $mailing->where('user_id', $admin->id)->count() ? 'selected' : '' }}>{{ $admin->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <ul>
              <li>Los administradores seleccionados recibirán alertas por correo electrónico cuando la capacidad de almacenamiento del servidor se encuente en estado crítico.</li>
              </ul>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-outline">Actualizar</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <script type="text/javascript">
    (function ($) {
      "use strict";
      function centerModal() {
        $(this).css('display', 'block');
        var $dialog  = $(this).find(".modal-dialog"),
        offset       = ($(window).height() - $dialog.height()) / 2,
        bottomMargin = parseInt($dialog.css('marginBottom'), 10);
        if(offset < bottomMargin) offset = bottomMargin;
        $dialog.css("margin-top", offset);
      }
      $(document).on('show.bs.modal', '.modal', centerModal);
      $(window).on("resize", function () {
        $('.modal:visible').each(centerModal);
      });
    }(jQuery));
  </script>
  @endcan
  @endsection