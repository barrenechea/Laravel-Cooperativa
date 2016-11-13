@extends('layouts.app')

@section('htmlheader_title', 'Listado de Pagos')

@section('contentheader_title')
Listado de Pagos - {{ $payments->first()->billdetail->location->code }}, {{ $payments->first()->billdetail->location->sector->name }} [{{ $payments->first()->billdetail->bill->description }}, fecha de emisión {{ $payments->first()->billdetail->created_at->toDateString() }}]
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
              <th>Fecha pago</th>
              <th>Monto pago</th>
              <th>Generado por</th>
              @if(Auth::user()->can('delete_payment') || Auth::user()->can('modify_payment'))
              <th>Acción</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $payment)
            <tr>
              <td hidden>{{ $payment->id }}</td>
              <td>{{ $payment->created_at }}</td>
              <td>${{ (number_format($payment->amount, 0, ',', '.')) }}</td>
              <td>{{ $payment->user->name ?? 'Sistema Contable Drysoft' }}</td>
              <td>
                @if($payment->user && (Auth::user()->can('delete_payment') || Auth::user()->can('modify_payment')))
                <input type="button" id="{{ $payment->id }}" value="Ver acciones" data-toggle="modal" data-target="#modal" class="btn btn-block btn-primary btn-xs">
                @else
                <input type="button" value="No disponible" class="btn btn-block btn-danger btn-xs" disabled>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@if(Auth::user()->can('delete_payment') || Auth::user()->can('modify_payment'))
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
          @can('delete_payment')
          <a href="#" id="deletePayment" class="btn btn-danger pull-left">Eliminar pago</a>
          @endcan
          @can('modify_payment')
          <a href="#" id="modifyPayment" class="btn btn-outline">Modificar pago</a>
          @endcan
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(':input[type=button]').click(function(){
      @can('delete_payment')
      $("#deletePayment").attr("href", "/payment/deletepayment/" + $(this).attr('id'));
      @endcan
      @can('modify_payment')
      $("#modifyPayment").attr("href", "/payment/modify/" + $(this).attr('id'));
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
