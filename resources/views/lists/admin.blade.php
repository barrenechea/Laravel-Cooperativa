@extends('layouts.app')

@section('htmlheader_title', 'Listado de Administradores')

@section('contentheader_title', 'Listado de Administadores')

@section('main-content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre y apellido</th>
                  <th>Usuario</th>
                  <th>Email</th>
                  <th>Estado</th>
                  <th>Accion</th>
                </tr>
                </thead>
                <tbody>
                @foreach($admins as $admin)
                <tr>
                  <td>{{ $admin->name }}</td>
                  <td>{{ $admin->username }}</td>
                  <td>{{ $admin->email }}</td>
                  @if($admin->roles()->count() > 0)
                  <td><span class="label label-success">Activada</span></td>
                  @else
                  <td><span class="label label-danger">Desactivada</span></td>
                  @endif
                  <td><a href="#" class="btn btn-block btn-primary btn-xs">Modificar roles</a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
@endsection
