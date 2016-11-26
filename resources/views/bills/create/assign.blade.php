@extends('layouts.app')

@section('htmlheader_title', 'Agregar cobro')

@section('contentheader_title')
Agregar cobro - {{ Cache::get('bill')->description }}
@endsection

@section('main-content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <form role="form" class="form-horizontal" action="{{ url('/bill/create/'.$assign) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="box-body">
          @if(isset($sectors))
          <div class="form-group">
            <label for="sector_id[]" class="col-sm-2 control-label">Sectores</label>
            <div class="col-sm-10">
              <select class="form-control select2" id="sector_id[]" name="sector_id[]" multiple="multiple" required>
                <option value="" disabled hidden>{{ $sectors->count() > 0 ? 'Seleccione un sector' : 'No hay sectores ingresados en el sistema' }}</option>
                @foreach($sectors as $sector)
                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
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
                <option value="{{ $type->id }}">{{ $type->name }}</option>
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
                <option value="{{ $group->id }}">{{ $group->description }}</option>
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
                <option value="{{ $location->id }}">{{ $location->sector->name }} - {{ $location->code }} [{{ $location->type->name }}]</option>
                @endforeach
              </select>
            </div>
          </div>
          @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary pull-right">Agregar cobro</button>
        </div>
      </form>
    </div>
    <!-- /.box -->
  </div>
</div>
@endsection
