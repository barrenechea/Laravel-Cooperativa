@extends('layouts.app')

@section('htmlheader_title', 'Actualizar perfil')

@section('contentheader_title', 'Actualizar perfil')

@section('main-content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <form role="form" class="form-horizontal" action="{{ url('/update/profile') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="box-body">
          <div class="form-group">
            <label for="username" class="col-sm-2 control-label">Nombre de usuario</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese nombre de usuario" value="{{ Auth::user()->username }}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nombre y apellido</label>
            <div class="col-sm-10">
             <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese nombre y apellido" required value="{{ old('name') ? old('name') : Auth::user()->name }}">
           </div>
         </div>
         <div class="form-group">
          <label for="email" class="col-sm-2 control-label">Correo electrónico</label>
          <div class="col-sm-10">
           <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese correo electrónico" required value="{{ old('email') ? old('email') : Auth::user()->email }}">
         </div>
       </div>
       @if(!Auth::user()->is_admin)
       <div class="form-group">
        <label for="address" class="col-sm-2 control-label">Dirección</label>
        <div class="col-sm-10">
         <input type="text" class="form-control" id="address" name="address" placeholder="Ingrese dirección" required value="{{ old('address') ? old('address') : Auth::user()->partner->address }}">
       </div>
     </div>
     <div class="form-group">
      <label for="phone" class="col-sm-2 control-label">Teléfono</label>
      <div class="col-sm-10">
       <input type="text" class="form-control" id="phone" name="phone" placeholder="Ingrese teléfono" required value="{{ old('phone') ? old('phone') : Auth::user()->partner->phone }}">
     </div>
   </div>
   @endif
   <div class="form-group">
    <label for="name" class="col-sm-2 control-label">Nueva contraseña</label>
    <div class="col-sm-10">
     <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="Ingrese nueva contraseña">
   </div>
 </div>
 <div class="form-group">
  <label for="name" class="col-sm-2 control-label">Confirme contraseña</label>
  <div class="col-sm-10">
   <input type="password" class="form-control" id="newpassword_confirmation" name="newpassword_confirmation" placeholder="Repita la nueva contraseña">
 </div>
</div>
<p class="col-sm-12 help-block">El ingreso de una nueva contraseña y su respectiva confirmación es opcional.</p>
</div>
<div class="box-footer">
  <button type="submit" class="btn btn-primary pull-right">Actualizar perfil</button>
</div>
</form>
</div>
</div>
</div>
@endsection