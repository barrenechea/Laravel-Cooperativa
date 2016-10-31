@extends('layouts.app')

@section('htmlheader_title', 'Socio - Modificar perfil')

@section('contentheader_title', 'Socio - Modificar perfil')

@section('contentheader_description', 'Actualiza el perfil de un socio')

@section('main-content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <form role="form" class="form-horizontal" action="{{ url('/update/partner/data') . '/' . $partner->id }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="box-body">
          <div class="form-group">
            <label for="username" class="col-sm-2 control-label">Nombre de usuario</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese nombre de usuario" value="{{ $partner->user->username }}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nombre y apellido</label>
            <div class="col-sm-10">
             <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese nombre y apellido" required value="{{ old('name') ? old('name') : $partner->user->name }}">
           </div>
         </div>
         <div class="form-group">
          <label for="username" class="col-sm-2 control-label">Correo electrónico</label>
          <div class="col-sm-10">
           <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese correo electrónico" required value="{{ old('email') ? old('email') : $partner->user->email }}">
         </div>
       </div>
       <div class="form-group">
        <label for="locations[]" class="col-sm-2 control-label">Locales asociados</label>
        <div class="col-sm-10">
          <select class="form-control select2" id="locations[]" name="locations[]" multiple="multiple">
            @foreach($locations as $location)
            <option {{ old('locations') && in_array($location->id, old('locations')) ? 'selected' : $partner->locations()->find($location->id) ? 'selected' : '' }} value="{{$location->id}}">{{ $location->sector->name .' - '. $location->code }}</option>
            @endforeach
          </select>
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