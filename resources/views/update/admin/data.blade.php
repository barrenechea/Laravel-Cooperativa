@extends('layouts.app')

@section('htmlheader_title', 'Administrador - Modificar perfil')

@section('contentheader_title', 'Administrador - Modificar perfil')

@section('contentheader_description', 'Actualiza el perfil de un administrador')

@section('main-content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <form role="form" class="form-horizontal" action="{{ url('/update/admin/data') . '/' . $user->id }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="box-body">
          <div class="form-group">
            <label for="username" class="col-sm-2 control-label">Nombre de usuario</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese nombre de usuario" value="{{ $user->username }}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nombre y apellido</label>
            <div class="col-sm-10">
             <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese nombre y apellido" required value="{{ old('name') ? old('name') : $user->name }}">
           </div>
         </div>
         <div class="form-group">
          <label for="username" class="col-sm-2 control-label">Correo electrónico</label>
          <div class="col-sm-10">
           <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese correo electrónico" required value="{{ old('email') ? old('email') : $user->email }}">
         </div>
       </div>
       <div class="form-group">
        <label for="permissions" class="col-sm-2 control-label">Permisos</label>
        <div class="col-sm-10">
          @foreach($roles as $role)
          <div class="checkbox">
            <label>
              <input type="checkbox" id="roles[]" name="roles[]" value="{{ $role->id }}"
              {{ (old('roles') && in_array($role->id, old('roles'))) ? 'checked' : ($user->roles()->where('id', $role->id)->count() > 0) ? 'checked' : '' }}>
              {{ $role->description }}
            </label>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button type="submit" class="btn btn-primary pull-right">Modificar perfil</button>
    </div>
  </form>
</div>
</div>
</div>
@endsection