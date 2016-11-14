@extends('layouts.app')

@section('htmlheader_title', 'Modificar grupo')

@section('contentheader_title', 'Modificar grupo')

@section('main-content')
<div class="row">
  <div class="col-md-12">
   <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Asignar porcentajes - {{ Cache::get('group')->description }}</h3>
    </div>
    <form role="form" class="form-horizontal" action="{{ url('/update/grouppct') }}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="box-body">
        @foreach($locations as $location)
        <div class="form-group">
          <label for="pct{{$location->id}}" class="col-sm-2 control-label">{{ $location->sector->name .' - '. $location->code }}</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="number" class="form-control" id="pct{{$location->id}}" name="pct{{$location->id}}" placeholder="Ingrese porcentaje para {{ $location->sector->name .' - '. $location->code }}" min="1" max="100" value="{{ $group->percentages()->where('location_id', $location->id)->count() ? $group->percentages()->where('location_id', $location->id)->first()->pct : '' }}" required>
              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="box-footer">
        <a href="{{ url('/list/group') }}" class="btn btn-primary">Volver al listado</a>
        <button type="submit" class="btn btn-primary pull-right">Modificar</button>
      </div>
    </form>
  </div>
</div>
</div>
@endsection