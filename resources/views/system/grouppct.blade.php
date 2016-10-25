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
            <div class="box-header with-border">
              <h3 class="box-title">Asignar porcentajes - {{ Session::get('group')->description }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" class="form-horizontal" action="{{ url('/system/addgrouppct') }}" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="box-body">
                @foreach($locations as $location)
                <div class="form-group">
                  <label for="pct{{$location->id}}" class="col-sm-2 control-label">{{ $location->sector->name .' - '. $location->code }}</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <input type="number" class="form-control" id="pct{{$location->id}}" name="pct{{$location->id}}" placeholder="Ingrese porcentaje para {{ $location->sector->name .' - '. $location->code }}" min="1" max="100" value="{{ old('pct'.$location->id) }}" required>
                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right">Agregar</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
		</div>
    </div>

@endsection