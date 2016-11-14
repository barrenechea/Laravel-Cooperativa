@extends('layouts.app')

@section('htmlheader_title', 'Reporte de morosos')

@section('contentheader_title', 'Reporte de morosos')

@section('main-content')
<div class="row">
  <div class="col-md-12">
   <div class="box">
    <form role="form" class="form-horizontal" action="{{ url('/report/overdue') }}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="box-body">
        <div class="form-group">
          <label for="report_type" class="col-sm-2 control-label">Tipo de reporte</label>
          <div class="col-sm-10">
            <div class="radio">
              <label>
                <input type="radio" id="report_type" name="report_type" value="1" required>
                Reporte de socios con pérdida de derechos
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" id="report_type" name="report_type" value="2">
                Reporte de socios en proceso de exclusión
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="return_mode" class="col-sm-2 control-label">Despliegue</label>
          <div class="col-sm-10">
            <div class="radio">
              <label>
                <input type="radio" id="return_mode" name="return_mode" value="1" required>
                Desplegar reporte en pantalla
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" id="return_mode" name="return_mode" value="2">
                Descargar reporte en planilla Excel
              </label>
            </div>
          </div>
        </div>
      </div>
      <ul>
      <li><p class="help-block">Los reportes de socios con pérdida de derechos contemplan atrasos en sus pagos entre {{ $logic->firstoverdue+1 }} y {{ $logic->secondoverdue }} días.</p></li>
      <li><p class="help-block">Los reportes de socios en proceso de exclusión contemplan atrasos en sus pagos entre {{ $logic->secondoverdue+1 }} o más días.</p></li>
      </ul>
      <div class="box-footer">
        @can('modify_overdue')
        <input type="button" value="Modificar días de clasificación" data-toggle="modal" data-target="#modal" class="btn btn-primary">
        @endcan
        <button type="submit" class="btn btn-primary pull-right">Obtener reporte</button>
      </div>
    </form>
  </div>
</div>
</div>
@can('modify_overdue')
<div class="modal fade modal-primary" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form role="form" class="form-horizontal" action="{{ url('/system/overduedates') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Días de clasificación</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Pérdida de derechos</label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="number" class="form-control" id="firstoverdue" name="firstoverdue" placeholder="Ingrese cantidad de días para la pérdida de derechos" value="{{ $logic->firstoverdue }}" required>
                    <span class="input-group-addon">días</span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="code" class="col-sm-4 control-label">Proceso de exclusión</label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="number" class="form-control" id="secondoverdue" name="secondoverdue" placeholder="Ingrese cantidad de días para el proceso de exclusión" value="{{ $logic->secondoverdue }}" required>
                    <span class="input-group-addon">días</span>
                  </div>
                </div>
              </div>
              <ul>
                <li>Los días ingresados se cuentan desde la fecha de emisión de un cobro.</li>
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
