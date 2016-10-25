@extends('layouts.app')

@section('htmlheader_title')
  Registrar administrador
@endsection

@section('contentheader_title')
  Registrar administrador
@endsection

@section('contentheader_description')
  Agregar un nuevo administrador al sistema
@endsection

@section('main-content')
		<div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <form role="form" class="form-horizontal" action="{{ url('/register/admin') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="box-body">
                <div class="form-group">
                  <label for="username" class="col-sm-2 control-label">Nombre de Usuario</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese nombre de usuario" value="{{ old('username') }}" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Nombre y apellido</label>
                  <div class="col-sm-10">
                   <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese nombre y apellido" required value="{{ old('name') }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="username" class="col-sm-2 control-label">Correo electrónico</label>
                  <div class="col-sm-10">
                   <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese correo electrónico" required value="{{ old('email') }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="permissions" class="col-sm-2 control-label">Roles</label>
                  <div class="col-sm-10">
                  @foreach($roles as $role)
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" id="roles[]" name="roles[]" value="{{ $role->id }}"
                        {{ (old('roles') && in_array($role->id, old('roles'))) ? 'checked' : '' }}>
                          {{ $role->description }}
                      </label>
                    </div>
                  @endforeach
                  </div>
                </div>
                <p class="col-sm-12 help-block">La contraseña será generada y enviada automáticamente por correo electrónico.</p>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Registrar administrador</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection
