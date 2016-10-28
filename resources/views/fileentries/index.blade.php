@extends('layouts.app')

@section('htmlheader_title')
	Subir archivo
@endsection

@section('contentheader_title')
  Subir archivo
@endsection

@section('main-content')
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
            <form id="form" role="form" class="form-horizontal" action="{{ url('/fileentry/add') }}" method="post" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                <p class="col-sm-12 help-block">Recuerde: Al subir un archivo, este quedará a su nombre y estará disponible para ser descargado por todos los socios y administradores del sistema.</p>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="button" value="Subir archivo" data-toggle="modal" data-target="#modal" class="btn btn-primary pull-right" />
              </div>
              <!-- /.box-footer -->
            </form>
            <div class="modal fade modal-warning" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Confirmación</h4>
                  </div>
                  <div class="modal-body">
                    <p>¿Está seguro que desea subir el archivo?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
                    <button type="button" id="submit" class="btn btn-outline">Si, subir archivo</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
		</div>
  </div>
@endsection