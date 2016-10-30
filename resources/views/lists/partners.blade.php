@extends('layouts.app')

@section('htmlheader_title', 'Listado de Socios')

@section('contentheader_title', 'Listado de Socios')

@section('main-content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre y apellido</th>
                  <th>Email</th>
                  <th>Locales asociados</th>
                  <th>Accion</th>
                </tr>
                </thead>
                <tbody>
                @foreach($partners as $partner)
                <tr>
                  <td>{{ $partner->user->name }}</td>
                  <td>{{ $partner->user->email }}</td>
                  <td>{{ $partner->locations()->count() }}</td>
                  <td><a href="#" class="btn btn-block btn-primary btn-xs">Modificar</a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
@endsection
