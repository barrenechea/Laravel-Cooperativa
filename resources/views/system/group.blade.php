@extends('layouts.app')

@section('htmlheader_title')
	Agregar grupos
@endsection

@section('contentheader_title')
  Agregar grupos
@endsection

@section('main-content')
	<div class="row">
		<div class="col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $groups }}</h3>

              <p>Grupos</p>
            </div>
            <div class="icon">
              <i class="fa fa-building"></i>
            </div>
            <a href="#" class="small-box-footer">
              Ver listado <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
	</div><!-- /.row -->

    <div class="row">
		<div class="col-md-12">
			<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar ubicación</h3>
            </div>
            <!-- /.box-header -->
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
