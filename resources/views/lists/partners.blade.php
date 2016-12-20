@extends('layouts.app')

@section('htmlheader_title', 'Listado de Socios')

@section('contentheader_title', 'Listado de Socios')

@section('main-content')
<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-body table-responsive">
        <table class="table tableresp table-bordered table-striped">
          <thead>
            <tr>
              <th hidden>ID</th>
              <th>RUN</th>
              <th>Nombre</th>
              <th>Email</th>
              <th>Dirección</th>
              <th>Teléfono</th>
              <th>Locales asociados</th>
              @if(Auth::user()->can('modify_partner_account') || Auth::user()->can('restore_password_partner_account'))
              <th>Accion</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($partners as $partner)
            <tr>
              <td hidden>{{ $partner->id }}</td>
              <td>{{ $partner->user->username }}</td>
              <td>{{ $partner->user->name }}</td>
              <td>{{ $partner->user->email }}</td>
              <td>{{ $partner->address === ' ' ? 'No llenado' : $partner->address }}</td>
              <td>{{ $partner->phone === ' ' ? 'No llenado' : $partner->phone }}</td>
              <td>{{ $partner->locations()->count() }}</td>
              @if(Auth::user()->can('modify_partner_account') || Auth::user()->can('restore_password_partner_account'))
              <td>
                <input type="button" id="{{ $partner->id }}" value="Modificar" data-toggle="modal" data-target="#modal" class="btn btn-block btn-primary btn-xs">
              </td>
              @endif
            </tr>
            @endforeach
          </table>
        </div>
        @can('create_partner_account')
        <div class="box-footer">
          <a href="{{ url('register/partner') }}" class="btn btn-primary pull-right">Agregar nuevo socio</a>
        </div>
        @endcan
      </div>
    </div>
  </div>
  @if(Auth::user()->can('modify_partner_account') || Auth::user()->can('restore_password_partner_account'))
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
            @can('restore_password_partner_account')
            <a href="#" id="newPassword" class="btn btn-outline">Generar nueva contraseña</a>
            @endcan
            @can('modify_partner_account')
            <a href="#" id="updateData" class="btn btn-outline">Modificar perfil</a>
            @endcan
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(':input[type=button]').click(function(){
        @can('restore_password_partner_account')
        $("#newPassword").attr("href", "/update/partner/password/" + $(this).attr('id'));
        @endcan
        @can('modify_partner_account')
        $("#updateData").attr("href", "/update/partner/data/" + $(this).attr('id'));
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
