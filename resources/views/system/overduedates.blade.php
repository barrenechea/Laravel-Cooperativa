@extends('layouts.app')

@section('htmlheader_title', 'Días de morosidad')

@section('contentheader_title', 'Días de morosidad')

@section('contentheader_description', 'Actualizar cantidad de días para reporte de morosos')

@section('main-content')
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
            <form role="form" class="form-horizontal" action="{{ url('/system/overduedates') }}" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="box-body">
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Pérdida de derechos</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="firstoverdue" name="firstoverdue" placeholder="Ingrese cantidad de días para la pérdida de derechos" value="{{ $logic->firstoverdue }}" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="code" class="col-sm-2 control-label">Proceso de exclusión</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="secondoverdue" name="secondoverdue" placeholder="Ingrese cantidad de días para el proceso de exclusión" value="{{ $logic->secondoverdue }}" required>
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
