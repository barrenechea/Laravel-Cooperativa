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
                  <div class="checkbox">
                    <label>
                      <input type="checkbox">
                      Agregar, modificar y deshabilitar cuentas de Administrador
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox">
                      Sincronizar socios y asociarlos a locales
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox">
                      Ver datos de locales y socios
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox">
                      Ver reportes de socios morosos
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox">
                      Enviar mensajes globales
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox">
                      Subir documentos
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox">
                      Contabilidad Externa
                    </label>
                  </div>
                </div>
                La contraseña será generada automáticamente y enviada al correo electrónico del nuevo administrador.
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
