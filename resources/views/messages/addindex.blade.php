@extends('layouts.app')

@section('htmlheader_title', 'Nuevo mensaje')

@section('contentheader_title', 'Nuevo mensaje')

@section('main-content')
<div class="row">
  <div class="col-md-12">
   <div class="box box-primary">
    <form role="form" class="form-horizontal" action="{{ url('/messages/add') }}" method="post" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="box-body">
        <div class="form-group">
          <label for="message" class="col-sm-2 control-label">Mensaje</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="message" name="message" placeholder="Ingrese mensaje a enviar (máx. 255 caracteres)" required>
          </div>
        </div>
        <p class="col-sm-12 help-block">Recuerde: Al enviar un mensaje, este quedará a su nombre y estará disponible para ser visualizado por todos los socios y administradores del sistema.</p>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right">Enviar mensaje</button>
      </div>
    </form>
  </div>
</div>
</div>
@endsection
