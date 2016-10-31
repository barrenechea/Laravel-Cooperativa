@extends('layouts.app')

@section('htmlheader_title', 'Listado de Socios')

@section('contentheader_title', 'Listado de Socios')

@section('main-content')
<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th hidden>ID</th>
              <th>Nombre y apellido</th>
              <th>Email</th>
              <th>Dirección</th>
              <th>Teléfono</th>
              <th>Locales asociados</th>
              <th>Accion</th>
            </tr>
          </thead>
          <tbody>
            @foreach($partners as $partner)
            <tr>
              <td hidden>{{ $partner->id }}</td>
              <td>{{ $partner->user->name }}</td>
              <td>{{ $partner->user->email }}</td>
              <td>{{ $partner->user->address ?? 'No llenado' }}</td>
              <td>{{ $partner->user->phone ?? 'No llenado' }}</td>
              <td>{{ $partner->locations()->count() }}</td>
              <td>
                <input type="button" id="{{ $partner->id }}" value="Modificar" data-toggle="modal" data-target="#modal" class="btn btn-block btn-primary btn-xs">
              </td>
            </tr>
            @endforeach
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
                  <a href="#" id="newPassword" class="btn btn-outline">Generar nueva contraseña</a>
                  <a href="#" id="updateData" class="btn btn-outline">Modificar perfil</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(':input[type=button]').click(function(){
        $("#newPassword").attr("href", "/update/partner/password/" + $(this).attr('id'));
        $("#updateData").attr("href", "/update/partner/data/" + $(this).attr('id'));
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
