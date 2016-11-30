@extends('layouts.app')

@section('htmlheader_title', 'Agregar Pago')

@section('contentheader_title')
Agregar Pago - {{ $billdetail->location->code }}, {{ $billdetail->location->sector->name }} [{{ $billdetail->bill->description }}, fecha de emisión {{ $billdetail->created_at->toDateString() }}]
@endsection

@section('main-content')
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <form role="form" class="form-horizontal" action="{{ url('/payment/new') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="billdetail_id" value="{{ $billdetail->id }}">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <div class="box-body">
          <div class="form-group">
            <label for="amount" class="col-sm-2 control-label">Monto a pagar</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="amount" name="amount" placeholder="Ingrese cantidad a pagar, máximo: ${{ number_format(($billdetail->amount - $billdetail->payments()->sum('amount')), 0, ',', '.') }}" value="{{ old('username') }}" max="{{ $billdetail->amount - $billdetail->payments()->sum('amount') }}" required>
            </div>
          </div>
          <div class="form-group">
            <label for="document_id" class="col-sm-2 control-label">N° Documento</label>
            <div class="col-sm-10">
              <input type="string" class="form-control" id="document_id" name="document_id" placeholder="Ingrese ID del documento vinculado al pago" value="{{ old('document_id') }}" required>
            </div>
          </div>
          <div class="form-group">
            <label for="date" class="col-sm-2 control-label">Fecha</label>
            <div class="col-sm-10">
              <input type="string" class="form-control" id="date" name="date" placeholder="Ingrese fecha, formato DD-MM-AAAA" value="{{ old('date') }}" required>
            </div>
          </div>
          <p class="col-sm-12 help-block">No ingresar puntos ni comas en el campo "Monto a pagar".</p>
        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-primary pull-right">Agregar Pago</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection