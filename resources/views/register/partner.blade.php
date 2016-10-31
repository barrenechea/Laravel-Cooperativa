@extends('layouts.app')

@section('htmlheader_title', 'Agregar Socio')

@section('contentheader_title', 'Agregar Socio')

@section('contentheader_description', 'Incorpora un socio a partir de la información de Drysoft')

@section('main-content')
		<div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <form role="form" class="form-horizontal" action="{{ url('/register/partner') }}" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="box-body">
                <div class="form-group">
                    <label for="run" class="col-sm-2 control-label">Identidad</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" id="run" name="run" required>
                      @foreach($data as $user)
                        <option {{ old('run') == $user->kod ? 'selected' : '' }} value="{{ $user->kod }}">{{ $user->desc }}, RUN {{ $user->kod }}</option>
                      @endforeach
                      </select>
                    </div>
                  </div>
                <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Correo electrónico</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese correo electrónico" required value="{{ old('email') }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="locations[]" class="col-sm-2 control-label">Asociar locales</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" id="locations[]" name="locations[]" multiple="multiple" required>
                    @foreach($locations as $location)
                      <option {{ old('locations') && in_array($location->id, old('locations')) ? 'selected' : '' }} value="{{$location->id}}">{{ $location->sector->name .' - '. $location->code }}</option>
                    @endforeach
                    </select>
                  </div>
                </div>
                <p class="col-sm-12 help-block">El nombre de usuario del socio será su RUN (ej: 12345678-9).</p>
                <p class="col-sm-12 help-block">La contraseña será generada y enviada automáticamente por correo electrónico.</p>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Agregar socio</button>
              </div>
            </form>
          </div>
        </div>
      </div>
</script>
@endsection
