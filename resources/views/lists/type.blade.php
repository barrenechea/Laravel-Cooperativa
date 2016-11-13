@extends('layouts.app')

@section('htmlheader_title', 'Listado de Tipos')

@section('contentheader_title', 'Listado de Tipos')

@section('main-content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Ubicaciones asociadas</th>
              @can('view_list_sector_type_location')
              <th>Accion</th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @foreach($types as $type)
            <tr>
              <td>{{ $type->name }}</td>
              <td>{{ $type->locations()->count() }}</td>
              @can('view_list_sector_type_location')
              <td><a href="{{ url('/list/location?type='.$type->id) }}" class="btn btn-block btn-primary btn-xs">Ver ubicaciones</a></td>
              @endcan
            </tr>
            @endforeach
          </table>
        </div>
        @can('add_type')
        <div class="box-footer">
          <input type="button" value="Agregar tipo" data-toggle="modal" data-target="#modal" class="btn btn-primary pull-right">
        </div>
        @endcan
      </div>
    </div>
  </div>
  @can('add_sector')
  <div class="modal fade modal-primary" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form role="form" class="form-horizontal" action="{{ url('/system/addtype') }}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar tipo</h4>
            </div>
            <div class="modal-body">
              <div class="box-body">
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Nombre</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese nombre (Ejemplo: Estacionamiento)" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-outline">Agregar tipo</button>
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