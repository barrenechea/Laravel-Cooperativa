@extends('layouts.app')

@section('htmlheader_title', 'Modificar grupo')

@section('contentheader_title', 'Modificar grupo')

@section('main-content')
<div class="row">
  <div class="col-md-12">
   <div class="box box-primary">
    <form role="form" class="form-horizontal" action="{{ url('/update/group') }}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="id" value="{{ $group->id }}">
      <div class="box-body">
        <div class="form-group">
          <label for="description" class="col-sm-2 control-label">Descripción del grupo</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="description" name="description" placeholder="Ingrese descripción del grupo" required value="{{ $group->description }}">
          </div>
        </div>
        <div class="form-group">
          <label for="location_id[]" class="col-sm-2 control-label">Ubicaciones a agrupar</label>
          <div class="col-sm-10">
            <select class="form-control select2" id="location_id[]" name="location_id[]" multiple="multiple" required>
              @foreach($locations as $location)
              <option value="{{$location->id}}" {{ $group->locations()->where('id', $location->id)->count() ? 'selected' : '' }} >{{ $location->sector->name .' - '. $location->code }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
              <label>
                <input type="checkbox" id="has_percentage" name="has_percentage" value="1" {{ $group->percentages()->count() ? 'checked' : '' }}> Los pagos estarán basados en porcentajes para los integrantes del grupo
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <a href="{{ url('/list/group') }}" class="btn btn-primary">Volver al listado</a>
        <button type="submit" class="btn btn-primary pull-right">Continuar</button>
      </div>
    </form>
  </div>
</div>
</div>
@endsection
