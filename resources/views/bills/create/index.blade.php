@extends('layouts.app')

@section('htmlheader_title', 'Agregar cobro')

@section('contentheader_title', 'Agregar cobro')

@section('main-content')
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <!-- form start -->
      <form role="form" class="form-horizontal" action="{{ url('/bill/create') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="box-body">
          <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Descripción</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="description" name="description" placeholder="Ingrese descripción del cobro" value="{{ old('description') }}" required>
            </div>
          </div>
          <div class="form-group">
            <label for="payment_day" class="col-sm-2 control-label">Día de cobro</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="payment_day" name="payment_day" placeholder="Ingrese el día en que se debe generar el cobro" min="1" max="31" value="{{ old('payment_day') }}" required>
            </div>
          </div>
          <div class="form-group">
            <label for="amount" class="col-sm-2 control-label">Monto</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="amount" name="amount" placeholder="Ingrese el monto a cobrar" min="0.01" step="0.01" value="{{ old('amount') }}" required>
            </div>
          </div>
          <div class="form-group">
            <label for="is_uf" class="col-sm-2 control-label">UF</label>
            <div class="col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox" id="is_uf" name="is_uf" value="1" {{ old('is_uf') ? 'checked' : '' }}>
                  El monto a cobrar está dado en UF
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="vfpcode" class="col-sm-2 control-label">Cuenta contable</label>
            <div class="col-sm-10">
              <select class="form-control select2" id="vfpcode" name="vfpcode" required>
                @foreach($accounts as $account)
                <option value="{{ $account->codigo }}">{{ $account->codigo }} - {{ $account->nombre }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox" class="checkfinish" id="finish" name="finish">
                  El cobro tendrá una fecha de término
                </label>
              </div>
            </div>
          </div>
          <div class="form-group finish" hidden>
            <label for="end_bill" class="col-sm-2 control-label">Fecha de Término</label>
            <div class="col-sm-10">
              <input type="date" class="form-control" id="end_bill" name="end_bill" value="{{ old('end_bill') }}">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox" class="checkoverdue" id="overdue" name="overdue">
                  El cobro tendrá un costo asociado a atrasos en pagos
                </label>
              </div>
            </div>
          </div>
          <div class="form-group overdue">
            <label for="overdue_day" class="col-sm-2 control-label">Día de atraso</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="overdue_day" name="overdue_day" placeholder="Ingrese el día a partir que se considera como atraso" min="1" max="31" value="{{ old('overdue_day') }}">
            </div>
          </div>
          <div class="form-group overdue">
            <label for="overdue_amount" class="col-sm-2 control-label">Monto de atraso</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="overdue_amount" name="overdue_amount" placeholder="Ingrese el monto a cobrar por atraso" min="0.01" step="0.01" value="{{ old('overdue_amount') }}">
            </div>
          </div>
          <div class="form-group overdue">
            <label for="overdue_is_uf" class="col-sm-2 control-label">UF</label>
            <div class="col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox" id="overdue_is_uf" name="overdue_is_uf" value="1" {{ old('overdue_is_uf') ? 'checked' : '' }}>
                  El monto a cobrar por atraso está dado en UF
                </label>
              </div>
            </div>
          </div>
          <div class="form-group overdue">
            <label for="overdue_vfpcode" class="col-sm-2 control-label">Cuenta contable</label>
            <div class="col-sm-10">
              <select class="form-control select2" id="overdue_vfpcode" name="overdue_vfpcode" required>
                @foreach($accounts as $account)
                <option value="{{ $account->codigo }}" {{ $account->codigo == "52-01-005" ? 'selected' : ''}}>{{ $account->codigo }} - {{ $account->nombre }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="assign" class="col-sm-2 control-label">Asignación</label>
            <div class="col-sm-10">
              <div class="radio">
                <label>
                  <input type="radio" name="assign" id="assign" value="sector" checked>
                  Asignar este cobro a un Sector
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" name="assign" id="assign" value="group">
                  Asignar este cobro a un Grupo
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" name="assign" id="assign" value="location">
                  Asignar este cobro a una Ubicación
                </label>
              </div>
            </div>
          </div>
          <p class="col-sm-12 help-block">Si los montos son definidos en UF, éstos serán calculados el día de cobro mes a mes, tomando el valor de la UF desde el Banco Central de Chile.</p>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary pull-right">Continuar</button>
        </div>
      </form>
    </div>
    <!-- /.box -->
  </div>
</div>
<script type="text/javascript">
  $( document ).ready(function() {
    $(".overdue").hide();
  });
  $(".checkfinish").click(function() {
    if($(this).is(":checked")) {
      $(".finish").show();
    } else {
      $(".finish").hide();
    }
  });
  $(".checkoverdue").click(function() {
    if($(this).is(":checked")) {
      $(".overdue").show();
    } else {
      $(".overdue").hide();
    }
  });
</script>
@endsection
