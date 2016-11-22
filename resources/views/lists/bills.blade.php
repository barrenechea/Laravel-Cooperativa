@extends('layouts.app')

@section('htmlheader_title', 'Listado de Cobros')

@section('contentheader_title', 'Listado de Cobros')

@section('main-content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body table-responsive">
        <table class="table tableresp table-bordered table-striped">
          <thead>
            <tr>
              <th>Descripción</th>
              <th>Monto</th>
              <th>Cobro por atraso</th>
              @can('modify_bill')
              <th>Accion</th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @foreach($bills as $bill)
            <tr>
              <td>{{ $bill->description }}</td>
              <td>{{ $bill->is_uf ? ($bill->amount . ' UF') : '$'.(number_format($bill->amount, 0, ',', '.')) }}</td>
              <td>{{ $bill->overdue_amount ? ($bill->overdue_is_uf ? ($bill->overdue_amount . 'UF') : '$'.(number_format($bill->overdue_amount, 0, ',', '.'))) : 'No posee' }}</td>
              @can('modify_bill')
              <td><a href="{{ url('bill/update/'.$bill->id ) }}" class="btn btn-block btn-primary btn-xs">Modificar</a></td>
              @endcan
            </tr>
            @endforeach
          </table>
        </div>
        @if(Auth::user()->can('add_bill') || Auth::user()->can('nofify_bill'))
        <div class="box-footer">
          @can('nofify_bill')
          <input type="button" value="Notificación término de cobros" data-toggle="modal" data-target="#modal" class="btn btn-primary">
          @endcan
          @can('add_bill')
          <a href="{{ url('bill/create') }}" class="btn btn-primary pull-right">Agregar nuevo cobro</a>
          @endcan
        </div>
        @endif
      </div>
    </div>
  </div>
  @can('nofify_bill')
  <div class="modal fade modal-primary" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form role="form" class="form-horizontal" action="{{ url('/system/notifybill') }}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="myModalLabel">Notificación término de cobros</h4>
            </div>
            <div class="modal-body">
              <div class="box-body">
                <div class="form-group">
                  <label for="days" class="col-sm-3 control-label">Días</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" id="days" name="days" placeholder="Ingrese cantidad de días previo a la fecha de expiración" value="{{ $logic_days }}" required>
                  </div>
                </div>
                <div class="form-group">
                <label for="admins[]" class="col-sm-3 control-label">Administradores</label>
                <div class="col-sm-9">
                  <select class="form-control select2" style="width: 100%;" id="admins[]" name="admins[]" multiple="multiple" required>
                    @foreach($admins as $admin)
                    <option value="{{ $admin->id }}" {{ $mailing->where('user_id', $admin->id)->count() ? 'selected' : '' }}>{{ $admin->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-outline">Agregar sector</button>
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
