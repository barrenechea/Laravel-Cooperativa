@extends('layouts.app')

@section('htmlheader_title', 'Reporte de morosos')

@section('contentheader_title', 'Reporte de morosos')

@section('main-content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Socio</th>
              <th>Ubicación</th>
              <th>Cobro</th>
              <th>Fecha emisión</th>
              <th>Días transcurridos</th>
              <th>Monto a pagar</th>
              <th>Monto pagado</th>
              <th>Teléfono</th>
              <th>Dirección</th>
            </tr>
          </thead>
          <tbody>
            @foreach($billdetails as $billdetail)
            <tr>
              <td>{{ $billdetail->partner->user->name }}</td>
              <td>{{ $billdetail->location->code }}</td>
              <td>{{ $billdetail->bill->description }}</td>
              <td>{{ $billdetail->created_at->toDateString() }}</td>
              <td>{{ $billdetail->created_at->diffInDays(Carbon\Carbon::now()) }}</td>
              <td>${{ (number_format($billdetail->amount, 0, ',', '.')) }}</td>
              <td>${{ (number_format($billdetail->payments()->sum('amount'), 0, ',', '.')) }}</td>
              <td>{{ $billdetail->partner->phone === ' ' ? 'No llenado' : $billdetail->partner->phone }}</td>
              <td>{{ $billdetail->partner->address === ' ' ? 'No llenado' : $billdetail->partner->address }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @can('new_message')
      <div class="box-footer">
        <input type="button" value="Nuevo mensaje" data-toggle="modal" data-target="#modal" class="btn btn-primary pull-right">
      </div>
      @endcan
    </div>
  </div>
</div>
@can('new_message')
<div class="modal fade modal-primary" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form role="form" class="form-horizontal" action="{{ url('/messages/add') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Nuevo mensaje</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="message" class="col-sm-2 control-label">Mensaje</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="message" name="message" placeholder="Ingrese mensaje a enviar (máx. 255 caracteres)" required>
                </div>
              </div>
              <ul>
                <li>Al enviar un mensaje, este quedará a su nombre y estará disponible para ser visualizado por todos los socios y administradores del sistema.</li>
                <li>Tendrá un plazo máximo de 10 minutos para eliminar el mensaje, para casos de ingresos por equivocación o información errónea.</li>
              </ul>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-outline">Enviar mensaje</button>
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