@extends('layouts.app')

@section('htmlheader_title')
	Agregar grupos
@endsection

@section('contentheader_title')
  Agregar grupos
@endsection

@section('main-content')
    <div class="row">
		<div class="col-md-12">
			<div class="box box-success">
            <!-- form start -->
            <form role="form" class="form-horizontal" action="{{ url('/system/addgroup') }}" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="box-body">
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Descripción del grupo</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="description" name="description" placeholder="Ingrese descripción del grupo" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="location_id[]" class="col-sm-2 control-label">Ubicaciones a agrupar</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" id="location_id[]" name="location_id[]" multiple="multiple" required>
                    @foreach($locations as $location)
                      <option value="{{$location->id}}">{{ $location->sector->name .' - '. $location->code }}</option>
                    @endforeach
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
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right">Continuar</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
		</div>
    </div>

@endsection
