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
              @if(Auth::user()->can('modify_admin_account') || Auth::user()->can('restore_password_admin_account'))
              <th>Accion</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($admins as $admin)
            @if($admin->can('super_admin'))
            @continue;
            @endif
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
              @if(Auth::user()->can('modify_admin_account') || Auth::user()->can('restore_password_admin_account'))
              <td>
                <input type="button" id="{{ $admin->id }}" value="Modificar" data-toggle="modal" data-target="#modal" class="btn btn-block btn-primary btn-xs">
              </td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @can('create_admin_account')
      <div class="box-footer">
        <a href="{{ url('register/admin') }}" class="btn btn-primary pull-right">Agregar nuevo administrador</a>
      </div>
      @endcan
    </div>
  </div>
</div>
@if(Auth::user()->can('modify_admin_account') || Auth::user()->can('restore_password_admin_account'))
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
          @can('restore_password_admin_account')
          <a href="#" id="newPassword" class="btn btn-outline">Generar nueva contraseña</a>
          @endcan
          @can('modify_admin_account')
          <a href="#" id="updateData" class="btn btn-outline">Modificar perfil</a>
          @endcan
        </div>
      </div>s
    </div>
  </div>
  <script type="text/javascript">
    $(':input[type=button]').click(function(){
      @can('restore_password_admin_account')
      $("#newPassword").attr("href", "/update/admin/password/" + $(this).attr('id'));
      @endcan
      @can('modify_admin_account')
      $("#updateData").attr("href", "/update/admin/data/" + $(this).attr('id'));
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
