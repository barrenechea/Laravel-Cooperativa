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
            <form role="form" class="form-horizontal" action="{{ url('/fileentry/add') }}" method="post" enctype="multipart/form-data">
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
                <button type="submit" class="btn btn-primary pull-right">Agregar sector</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
		</div>
  </div>
@endsection
