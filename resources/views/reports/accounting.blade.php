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
          <label for="month" class="col-sm-2 control-label">Período</label>
          <div class="col-sm-10">
            <select class="form-control select2" style="width: 100%" id="month" name="month" required>
              <option value="" disabled selected hidden>Seleccione un período</option>
              @foreach($dates as $date)
              <option value="{{ $date->toDateString() }}">{{ $date->formatLocalized('%B %Y') }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="display_mode" class="col-sm-2 control-label">Despliegue</label>
          <div class="col-sm-10">
            <div class="radio">
              <label>
                <input type="radio" id="display_mode" name="display_mode" value="1" required>
                Desplegar reporte en pantalla
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" id="display_mode" name="display_mode" value="2" checked>
                Descargar reporte en planilla Excel
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right">Obtener reporte</button>
      </div>
    </form>
  </div>
</div>
</div>
@endsection
