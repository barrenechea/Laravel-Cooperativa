@extends('layouts.app')

@section('htmlheader_title', 'Modificar monto')

@section('contentheader_title')
Modificar monto - {{ $billdetail->location->code }}, {{ $billdetail->location->sector->name }} [{{ $billdetail->bill->description }}, fecha de emisión {{ $billdetail->created_at->toDateString() }}]
@endsection

@section('main-content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <form role="form" class="form-horizontal" action="{{ url('/payment/modifydetail') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="billdetail_id" value="{{ $billdetail->id }}">
        <div class="box-body">
          <div class="form-group">
            <label for="amount" class="col-sm-2 control-label">Monto a pagar</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="amount" name="amount" placeholder="Ingrese cantidad total a pagar" value="{{ $billdetail->amount }}" required>
            </div>
          </div>
          <div class="form-group">
            <label for="reason" class="col-sm-2 control-label">Motivo</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="reason" name="reason" placeholder="Ingrese motivo del cambio de monto" required>
            </div>
          </div>
          <p class="col-sm-12 help-block">No ingresar puntos ni comas en el campo "Monto a pagar".</p>
        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-primary pull-right">Modificar monto</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection