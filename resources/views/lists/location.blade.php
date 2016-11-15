@extends('layouts.app')

@section('htmlheader_title', 'Listado de Ubicaciones')

@section('contentheader_title', 'Listado de Ubicaciones')

@section('main-content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Sector</th>
              <th>Tipo</th>
              <th>Código</th>
              <th>Socio vinculado</th>
              @can('view_list_billdetail_payment')
              <th>Acción</th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @foreach($locations as $location)
            <tr>
              <td>{{ $location->sector->name }}</td>
              <td>{{ $location->type->name }}</td>
              <td>{{ $location->code }}</td>
              <td>{{ $location->partner ? $location->partner->user->name : 'No posee' }}</td>
              @can('view_list_billdetail_payment')
              <td><a href="{{ url('/list/payments/'.$location->id) }}" class="btn btn-block btn-primary btn-xs">Ver cobros</a></td>
              @endcan
            </tr>
            @endforeach
          </table>
        </div>
        @can('add_location')
        <div class="box-footer">
          <input type="button" value="Agregar ubicación" data-toggle="modal" data-target="#modal" class="btn btn-primary pull-right">
        </div>
        @endcan
      </div>
    </div>
  </div>
  @can('add_location')
  <div class="modal fade modal-primary" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form role="form" class="form-horizontal" action="{{ url('/system/addlocation') }}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar ubicación</h4>
            </div>
            <div class="modal-body">
              <div class="box-body">
                <div class="form-group">
                  <label for="sector_id" class="col-sm-2 control-label">Sector</label>
                  <div class="col-sm-10">
                   <select class="form-control select2" style="width: 100%" id="sector_id" name="sector_id" required>
                    <option value="" disabled selected hidden>{{ $sectors->count() > 0 ? 'Seleccione un sector' : 'No hay sectores ingresados en el sistema' }}</option>
                    @foreach($sectors as $sector)
                    <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="sector_id" class="col-sm-2 control-label">Tipo</label>
                <div class="col-sm-10">
                 <select class="form-control select2" style="width: 100%" id="type_id" name="type_id" required>
                  <option value="" disabled selected hidden>{{ $types->count() > 0 ? 'Seleccione un tipo' : 'No hay tipos ingresados en el sistema' }}</option>
                  @foreach($types as $type)
                  <option value="{{ $type->id }}">{{ $type->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="code" class="col-sm-2 control-label">Código</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="code" name="code" placeholder="Ingrese código (Ej: L.62)" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline">Agregar ubicación</button>
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
