@extends('layouts.app')

@section('htmlheader_title')
  Registro
@endsection

@section('contentheader_title')
  Registro
@endsection

@section('contentheader_description')
  Agregar un nuevo administrador al sistema online
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
                  <label for="username">Nombre de Usuario</label>
                   <input type="text" class="form-control" id="username" placeholder="Ingrese Nombre de usuario">
                </div>
                <div class="form-group">
                  <label for="username">Nombre y apellido</label>
                   <input type="text" class="form-control" id="name" placeholder="Ingrese Nombre y apellido">
                </div>
                <div class="form-group">
                  <label for="username">Correo electrónico</label>
                   <input type="email" class="form-control" id="email" placeholder="Ingrese Correo electrónico">
                </div>
                <div class="form-group">
                  <label for="permissions">Roles</label>
                  @foreach($roles as $role)
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="{{ $role->name }}" value="{{ $role->id }}">
                          {{ $role->description }}
                      </label>
                    </div>
                  @endforeach
                </div>
                La contraseña será el mismo nombre de usuario de la cuenta, la cual podrá ser cambiada posteriormente.
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
@endsection
