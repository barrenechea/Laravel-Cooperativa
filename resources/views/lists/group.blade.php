@extends('layouts.app')

@section('htmlheader_title', 'Listado de Grupos')

@section('contentheader_title', 'Listado de Grupos')

@section('main-content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Descripción</th>
              <th>Ubicaciones asociadas</th>
              <th>Basado en porcentajes</th>
              @can('modify_group')
              <th>Accion</th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @foreach($groups as $group)
            <tr>
              <td>{{ $group->description }}</td>
              <td>{{ $group->locations()->count() }}</td>
              <td>{{ $group->percentages()->count() > 0 ? 'Si' : 'No' }}</td>
              @can('modify_group')
              <td><a href="{{ url('update/group/'.$group->id ) }}" class="btn btn-block btn-primary btn-xs">Modificar</a></td>
              @endcan
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @can('add_group')
      <div class="box-footer">
        <a href="{{ url('system/group') }}" class="btn btn-primary pull-right">Agregar nuevo grupo</a>
      </div>
      @endcan
    </div>
  </div>
</div>
@endsection