@extends('layouts.app')

@section('htmlheader_title')
	Registrar socio
@endsection

@section('contentheader_title')
  Registrar socio
@endsection

@section('contentheader_description')
  Agregar un nuevo socio al sistema online
@endsection

@section('main-content')
		<div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- form start -->
            <form role="form">
              <div class="box-body">
                <div class="form-group">
                    <label>Identidad</label>
                    <select class="form-control select2" id="run">
                    @foreach($data as $user)
                      <option value="{{$user['kod']}}">{{ $user['desc'] }}, RUN {{$user['kod']}}</option>
                    @endforeach
                    </select>
                  </div>
                <div class="form-group">
                  <label for="email">Correo electrónico</label>
                  <input type="email" class="form-control" id="name" placeholder="Ingrese correo electrónico">
                </div>
                El nombre de usuario del socio será su RUN (ej: 12345678-9).<br/>
                La contraseña será generada y enviada automáticamente por correo electrónico.
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Registrar</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>
</script>
@endsection
