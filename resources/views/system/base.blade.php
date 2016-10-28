@extends('layouts.app')

@section('htmlheader_title')
	Administrar Sectores, Tipos y Ubicaciones
@endsection

@section('contentheader_title')
  Administrar Sectores, Tipos y Ubicaciones
@endsection

@section('main-content')
	<div class="row">
		<div class="col-md-6">
			<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar sector</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" class="form-horizontal" action="{{ url('/system/addsector') }}" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="box-body">
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Descripción</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese descripción (Ejemplo: Alameda Santiago)" required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right">Agregar sector</button>
              </div>
              <!-- /.box-footer -->
            </form>
      </div>
		</div>
    <div class="col-md-6">
      <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar tipo</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" class="form-horizontal" action="{{ url('/system/addtype') }}" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="box-body">
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Descripción</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese descripción (Ejemplo: Estacionamiento)" required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-danger pull-right">Agregar tipo</button>
              </div>
              <!-- /.box-footer -->
            </form>
      </div>
    </div>
  </div>

    <div class="row">
		<div class="col-md-12">
			<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar ubicación</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" class="form-horizontal" action="{{ url('/system/addlocation') }}" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="box-body">
                <div class="form-group">
                  <label for="sector_id" class="col-sm-2 control-label">Sector</label>
                  <div class="col-sm-10">
                  	<select class="form-control select2" id="sector_id" name="sector_id" required>
                      <option value="" disabled selected hidden>{{ $sectors->count() > 0 ? 'Seleccione un sector' : 'No hay sectores ingresados en el sistema' }}</option>
                    @foreach($sectors->toArray() as $sector)
                      <option value="{{$sector['id']}}">{{ $sector['name'] }}</option>
                    @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="sector_id" class="col-sm-2 control-label">Tipo</label>
                  <div class="col-sm-10">
                  	<select class="form-control select2" id="type_id" name="type_id" required>
                      <option value="" disabled selected hidden>{{ $types->count() > 0 ? 'Seleccione un tipo' : 'No hay tipos ingresados en el sistema' }}</option>
                    @foreach($types->toArray() as $type)
                      <option value="{{$type['id']}}">{{ $type['name'] }}</option>
                    @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="code" class="col-sm-2 control-label">Código</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="code" name="code" placeholder="Ingrese código (Ej: L.62)" required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Agregar ubicación</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
		</div>
    </div>

@endsection
