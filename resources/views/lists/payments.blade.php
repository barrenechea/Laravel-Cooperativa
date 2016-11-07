@extends('layouts.app')

@section('htmlheader_title', 'Listado de Cobros')

@section('contentheader_title')
Listado de Cobros - {{ $location->code }}, {{ $location->sector->name }}
@endsection

@section('main-content')
<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th hidden>ID</th>
              <th>Descripción</th>
              <th>Socio</th>
              <th>Fecha emisión</th>
              <th>Fecha vencimiento</th>
              <th>Monto a pagar</th>
              <th>Monto pagado</th>
              <th>Estado</th>
              <th>Accion</th>
            </tr>
          </thead>
          <tbody>
            @foreach($location->billdetails()->get() as $billdetail)
            <tr>
              <td hidden>{{ $billdetail->id }}</td>
              <td>{{ $billdetail->bill->description }}{{ $billdetail->vfpcode !== $billdetail->bill->vfpcode ? ' [Multa por atraso]' : '' }}</td>
              <td>{{ $billdetail->partner->user->name }}</td>
              <td>{{ $billdetail->created_at->toDateString() }}</td>
              <td>{{ $billdetail->overdue_date ? $billdetail->overdue_date->toDateString() : 'No posee' }}</td>
              <td>${{ (number_format($billdetail->amount, 0, ',', '.')) }}</td>
              <td>${{ (number_format($billdetail->payments()->sum('amount'), 0, ',', '.')) }}</td>
              @if($billdetail->amount <= $billdetail->payments()->sum('amount'))
              <td><span class="label label-success">Pagado</span></td>
              @elseif($billdetail->overdue_date->gte(Carbon\Carbon::today()))
              <td><span class="label label-warning">Pendiente</span></td>
              @else
              <td><span class="label label-danger">Atrasado</span></td>
              @endif
              <td>
                <input type="button" id="{{ $billdetail->id }}" value="Ver acciones" data-toggle="modal" data-target="#modal" class="btn btn-block btn-primary btn-xs">
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal fade modal-primary" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">¿Qué desea hacer?</h4>
              </div>
              <div class="modal-body">
                <p>Seleccione una de las siguientes opciones</p>
              </div>
              <div class="modal-footer">
                <a href="#" id="deleteDetail" class="btn btn-danger pull-left">Eliminar cobro</a>
                <a href="#" id="addPayment" class="btn btn-outline">Agregar pago</a>
                <a href="#" id="viewDetail" class="btn btn-outline">Ver detalle</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(':input[type=button]').click(function(){
      $("#deleteDetail").attr("href", "/payment/deletedetail/" + $(this).attr('id'));
      $("#addPayment").attr("href", "/payment/new/" + $(this).attr('id'));
      $("#viewDetail").attr("href", "/payment/view/" + $(this).attr('id'));
    });

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
  @endsection
