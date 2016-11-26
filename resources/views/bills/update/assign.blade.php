@extends('layouts.app')

@section('htmlheader_title', 'Modificar cobro')

@section('contentheader_title')
Modificar cobro - {{ Cache::get('bill')->description }}
@endsection

@section('main-content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <form role="form" class="form-horizontal" action="{{ url('/bill/updateassign/'.$assign) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="box-body">
          @if(isset($sectors))
          <div class="form-group">
            <label for="sector_id[]" class="col-sm-2 control-label">Sectores</label>
            <div class="col-sm-10">
              <select class="form-control select2" id="sector_id[]" name="sector_id[]" multiple="multiple" required>
                <option value="" disabled hidden>{{ $sectors->count() > 0 ? 'Seleccione un sector' : 'No hay sectores ingresados en el sistema' }}</option>
                @foreach($sectors as $sector)
                <option value="{{ $sector->id }}" {{ $bill->sectors()->count() ? (($bill->sectors()->where('id', $sector->id)->count()) ? 'selected' : '') : '' }}>{{ $sector->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="type_id[]" class="col-sm-2 control-label">Tipos</label>
            <div class="col-sm-10">
              <select class="form-control select2" id="type_id[]" name="type_id[]" multiple="multiple" required>
                <option value="" disabled hidden>{{ $types->count() > 0 ? 'Seleccione los tipos a aplicar los cobros' : 'No hay tipos ingresados en el sistema' }}</option>
                @foreach($types as $type)
                <option value="{{ $type->id }}" {{ $bill->types()->count() ? (($bill->types()->where('id', $type->id)->count() ) ? 'selected' : '') : '' }}>{{ $type->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          @elseif(isset($groups))
          <div class="form-group">
            <label for="group_id" class="col-sm-2 control-label">Grupo</label>
            <div class="col-sm-10">
              <select class="form-control select2" id="group_id" name="group_id" required>
                <option value="" disabled selected hidden>{{ $groups->count() > 0 ? 'Seleccione un grupo' : 'No hay grupos ingresados en el sistema' }}</option>
                @foreach($groups as $group)
                <option value="{{ $group->id }}" {{ $bill->groups()->count() ? (($bill->groups()->first()->id == $group->id) ? 'selected' : '') : '' }}>{{ $group->description }}</option>
                @endforeach
              </select>
            </div>
          </div>
          @elseif(isset($locations))
          <div class="form-group">
            <label for="location_id" class="col-sm-2 control-label">Ubicación</label>
            <div class="col-sm-10">
              <select class="form-control select2" id="location_id" name="location_id" required>
                <option value="" disabled selected hidden>{{ $locations->count() > 0 ? 'Seleccione una ubicación' : 'No hay ubicaciones ingresadas en el sistema' }}</option>
                @foreach($locations as $location)
                <option value="{{ $location->id }}" {{ $bill->locations()->count() ? (($bill->locations()->first()->id == $location->id) ? 'selected' : '') : '' }}>{{ $location->sector->name }} - {{ $location->code }} [{{ $location->type->name }}]</option>
                @endforeach
              </select>
            </div>
          </div>
          @endif
          <div class="form-group">
            <label for="reason" class="col-sm-2 control-label">Motivo de modificación</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="reason" name="reason" placeholder="Ingrese el motivo por el cual está realizando la modificación a este cobro" required>
            </div>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary pull-right">Modificar cobro</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
