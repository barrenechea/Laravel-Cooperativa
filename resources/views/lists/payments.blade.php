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
              @if(Auth::user()->can('view_list_billdetail_payment') || Auth::user()->can('add_payment') || Auth::user()->can('delete_billdetail'))
              <th>Accion</th>
              @endif
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
              @elseif(!isset($billdetail->overdue_date) || $billdetail->overdue_date->gte(Carbon\Carbon::today()))
              <td><span class="label label-warning">Pendiente</span></td>
              @else
              <td><span class="label label-danger">Atrasado</span></td>
              @endif
              @if(Auth::user()->can('view_list_billdetail_payment') || Auth::user()->can('add_payment') || Auth::user()->can('delete_billdetail'))
              <td>
                <input type="button" id="{{ $billdetail->id }}" value="Ver acciones" data-toggle="modal" data-target="#modal" class="btn btn-block btn-primary btn-xs">
              </td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@if(Auth::user()->can('view_list_billdetail_payment') || Auth::user()->can('add_payment') || Auth::user()->can('delete_billdetail'))
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
          @can('delete_billdetail')
          <a href="#" id="deleteDetail" class="btn btn-danger pull-left">Eliminar cobro</a>
          @endcan
          @can('add_payment')
          <a href="#" id="addPayment" class="btn btn-outline">Agregar pago</a>
          @endcan
          @can('view_list_billdetail_payment')
          <a href="#" id="viewDetail" class="btn btn-outline">Ver detalle</a>
          @endcan
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(':input[type=button]').click(function(){
      @can('delete_billdetail')
      $("#deleteDetail").attr("href", "/payment/deletedetail/" + $(this).attr('id'));
      @endcan
      @can('add_payment')
      $("#addPayment").attr("href", "/payment/new/" + $(this).attr('id'));
      @endcan
      @can('view_list_billdetail_payment')
      $("#viewDetail").attr("href", "/payment/view/" + $(this).attr('id'));
      @endcan
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
  @endif
  @endsection
