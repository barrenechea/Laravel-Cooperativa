@extends('layouts.app')

@section('htmlheader_title', 'Archivos')

@section('contentheader_title', 'Todos los archivos')

@section('main-content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table tableresp table-bordered table-striped">
          <thead>
            <tr>
              <th>Autor</th>
              <th>Fecha</th>
              <th>Descripción</th>
              <th>Descargar</th>
              @if($messages->where('user_id', Auth::user()->id)->count() || Auth::user()->can('delete_message_file'))
              <th>Acción</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($messages as $message)
            <tr>
              <td>{{ $message->user->name }}</td>
              <td>{{ $message->created_at->format('d-m-Y') }}</td>
              <td>{{ $message->message }}</td>
              <form role="form" action="{{ url('/fileentry/get/'.$message->fileentry->id) }}" method="get">
                <td><button type="submit" class="btn btn-block btn-primary btn-xs">Descargar</button></td>
              </form>
              @if($messages->where('user_id', Auth::user()->id)->count() || Auth::user()->can('delete_message_file'))
              <td>
                @if(($message->user_id === Auth::user()->id && $message->created_at->diffInMinutes(\Carbon\Carbon::now()) < 10) || Auth::user()->can('delete_message_file'))
                <a href="{{ url('/fileentry/delete/'.$message->id) }}" class="btn btn-block btn-primary btn-xs">Eliminar</a>
                @else
                <input type="button" value="No disponible" class="btn btn-block btn-danger btn-xs" disabled>
                @endif
              </td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @can('new_file')
      <div class="box-footer">
        <input type="button" value="Subir archivo" data-toggle="modal" data-target="#modal" class="btn btn-primary pull-right">
      </div>
      @endcan
    </div>
  </div>
</div>
@can('new_file')
<div class="modal fade modal-primary" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="form" role="form" class="form-horizontal" action="{{ url('/fileentry/add') }}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Subir archivo</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="message" class="col-sm-2 control-label">Descripción</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="message" name="message" placeholder="Ingrese descripción del archivo" required>
                </div>
              </div>
              <div class="form-group">
                <label for="filefield" class="col-sm-2 control-label">Archivo</label>
                <div class="col-sm-10">
                  <input type="file" id="filefield" name="filefield" required>
                </div>
              </div>
              <ul>
                <li>Al subir un archivo, este quedará a su nombre y estará disponible para ser visualizado por todos los socios y administradores del sistema.</li>
                <li>Tendrá un plazo máximo de 10 minutos para eliminar el archivo, para casos de ingresos por equivocación o información errónea.</li>
              </ul>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-outline">Subir archivo</button>
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