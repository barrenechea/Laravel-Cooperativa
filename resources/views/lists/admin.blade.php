@extends('layouts.app')

@section('htmlheader_title', 'Listado de Administradores')

@section('contentheader_title', 'Listado de Administadores')

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
              <th>Usuario</th>
              <th>Email</th>
              <th>Estado</th>
              <th>Accion</th>
            </tr>
          </thead>
          <tbody>
            @foreach($admins as $admin)
            <tr>
              <td hidden>{{ $admin->id }}</td>
              <td>{{ $admin->name }}</td>
              <td>{{ $admin->username }}</td>
              <td>{{ $admin->email }}</td>
              @if($admin->roles()->count() > 0)
              <td><span class="label label-success">Activado</span></td>
              @else
              <td><span class="label label-danger">Desactivado</span></td>
              @endif
              <td>
                <input type="button" id="{{ $admin->id }}" value="Modificar" data-toggle="modal" data-target="#modal" class="btn btn-block btn-primary btn-xs">
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
      $("#newPassword").attr("href", "/update/admin/password/" + $(this).attr('id'));
      $("#updateData").attr("href", "/update/admin/data/" + $(this).attr('id'));
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
