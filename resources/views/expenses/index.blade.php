@extends('layouts.app')

@section('htmlheader_title', 'Administrar Gastos')

@section('contentheader_title', 'Administrar Gastos')

@section('contentheader_description', 'Las cuentas contables que se mostrarán en el Consolidado')

@section('main-content')
    <div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Cuentas contables de Egresos</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" class="form-horizontal" action="{{ url('/expenses') }}" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="box-body">
                <div class="form-group">
                  <label for="vfpcode[]" class="col-sm-2 control-label">Cuentas contables</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" id="vfpcode[]" name="vfpcode[]" multiple="multiple" required>
                    @foreach($cuentas as $cuenta)
                      <option {{ in_array($cuenta->codigo, $activas) ? 'selected' : '' }} value="{{$cuenta->codigo}}">{{ $cuenta->codigo .' - '. $cuenta->nombre }}</option>
                    @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Actualizar</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
		</div>
    </div>

@endsection
