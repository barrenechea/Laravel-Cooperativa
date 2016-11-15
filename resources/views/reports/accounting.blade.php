@extends('layouts.app')

@section('htmlheader_title', 'Reporte de contabilidad')

@section('contentheader_title', 'Reporte de contabilidad')

@section('main-content')
<div class="row">
  <div class="col-md-12">
   <div class="box box-primary">
    <form role="form" class="form-horizontal" action="{{ url('/report/accounting') }}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="box-body">
        <div class="form-group">
          <label for="range" class="col-sm-2 control-label">Rango de fechas</label>
          <div class="col-sm-10">
            <select class="form-control select2" style="width: 100%" id="range" name="range" required>
              <option value="" disabled selected hidden>Seleccione un rango</option>
              @if(false)
              @foreach($types as $type)
              <option value="{{ $type->id }}">{{ $type->name }}</option>
              @endforeach
              @endif
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
              <label>
                <input type="checkbox" id="has_percentage" name="has_percentage" value="1"> Los pagos estarán basados en porcentajes para los integrantes del grupo
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right">Continuar</button>
      </div>
    </form>
  </div>
</div>
</div>
@endsection
