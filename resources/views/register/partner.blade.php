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
            <form role="form" class="form-horizontal" action="{{ url('/register/partner') }}" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="box-body">
                <div class="form-group">
                    <label for="run" class="col-sm-2 control-label">Identidad</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" id="run" name="run" required>
                      @foreach($data as $user)
                        <option value="{{$user['kod']}}">{{ $user['desc'] }}, RUN {{$user['kod']}}</option>
                      @endforeach
                      </select>
                    </div>
                  </div>
                <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Correo electrónico</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese correo electrónico" required>
                  </div>
                </div>
                <p class="col-sm-12 help-block">El nombre de usuario del socio será su RUN (ej: 12345678-9).</p>
                <p class="col-sm-12 help-block">La contraseña será generada y enviada automáticamente por correo electrónico.</p>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Registrar socio</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>
</script>
@endsection
