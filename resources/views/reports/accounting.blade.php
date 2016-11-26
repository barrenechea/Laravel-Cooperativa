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
              @if(isset($dates))
              @foreach($dates as $date)
              <option value="{{ $date->toDateString() }}">{{ ucfirst($date->formatLocalized('%B %Y')) }}</option>
              @endforeach
              @endif
            </select>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right">Obtener Excel</button>
      </div>
    </form>
  </div>
</div>
</div>
@endsection
