@extends('layouts.app')

@section('htmlheader_title', 'Modificar cobro')

@section('contentheader_title', 'Modificar cobro')

@section('main-content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <form role="form" class="form-horizontal" action="{{ url('/bill/update') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ $bill->id }}">
        <div class="box-body">
          <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Descripción</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="description" name="description" placeholder="Ingrese descripción del cobro" value="{{ $bill->description }}" required>
            </div>
          </div>
          <div class="form-group">
            <label for="payment_day" class="col-sm-2 control-label">Día de cobro</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="payment_day" name="payment_day" placeholder="Ingrese el día de cada mes en que se debe generar el cobro" min="1" max="31" value="{{ $bill->payment_day }}" required>
            </div>
          </div>
          <div class="form-group">
            <label for="amount" class="col-sm-2 control-label">Monto</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="amount" name="amount" placeholder="Ingrese el monto a cobrar" min="0.01" step="0.01" value="{{ $bill->is_uf ? $bill->amount : intval($bill->amount) }}" required>
            </div>
          </div>
          <div class="form-group">
            <label for="is_uf" class="col-sm-2 control-label">UF</label>
            <div class="col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox" id="is_uf" name="is_uf" value="1" {{ $bill->is_uf ? 'checked' : '' }}>
                  El monto a cobrar está dado en UF
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="vfpcode_destination" class="col-sm-2 control-label">C. Contable destino</label>
            <div class="col-sm-10">
              <select class="form-control select2" id="vfpcode_destination" name="vfpcode_destination" required>
                @foreach($accounts as $account)
                <option value="{{ $account->codigo }}" {{ $bill->vfpcode_destination == $account->codigo ? 'selected' : '' }}>{{ $account->codigo }} - {{ $account->nombre }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="vfpcode" class="col-sm-2 control-label">C. Contable actividad</label>
            <div class="col-sm-10">
              <select class="form-control select2" id="vfpcode" name="vfpcode" required>
                @foreach($accounts as $account)
                <option value="{{ $account->codigo }}" {{ $bill->vfpcode == $account->codigo ? 'selected' : '' }}>{{ $account->codigo }} - {{ $account->nombre }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox" class="checkfinish" id="finish" name="finish" {{ isset($bill->end_bill) ? 'checked' : '' }} >
                  El cobro tendrá una fecha de término
                </label>
              </div>
            </div>
          </div>
          <div class="form-group finish" hidden>
            <label for="end_bill" class="col-sm-offset-2 col-sm-2 control-label">Fecha de Término</label>
            <div class="col-sm-8">
              <input type="date" class="form-control" id="end_bill" name="end_bill" value="{{ isset($bill->end_bill) ? $bill->end_bill->toDateString() : '' }}">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox" class="checkoverdue" id="overdue" name="overdue" {{ isset($bill->overdue_day) ? 'checked' : '' }}>
                  El cobro tendrá un costo asociado a atrasos en pagos
                </label>
              </div>
            </div>
          </div>
          <div class="form-group overdue">
            <label for="overdue_day" class="col-sm-offset-2 col-sm-2 control-label">Día de expiración</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="overdue_day" name="overdue_day" placeholder="Ingrese el día del siguiente mes a considerar como vencimiento" min="1" max="31" value="{{ $bill->overdue_day ?? '' }}">
            </div>
          </div>
          <div class="form-group overdue">
            <label for="overdue_amount" class="col-sm-offset-2 col-sm-2 control-label">Monto de atraso</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="overdue_amount" name="overdue_amount" placeholder="Ingrese el monto a cobrar por atraso" min="0.01" step="0.01" value="{{ isset($bill->overdue_amount) ? ($bill->overdue_is_uf ? $bill->overdue_amount : intval($bill->overdue_amount)) : '' }}">
            </div>
          </div>
          <div class="form-group overdue">
            <label for="overdue_is_uf" class="col-sm-offset-2 col-sm-2 control-label">UF</label>
            <div class="col-sm-8">
              <div class="checkbox">
                <label>
                  <input type="checkbox" id="overdue_is_uf" name="overdue_is_uf" value="1" {{ (isset($bill->overdue_is_uf) && $bill->overdue_is_uf) ? 'checked' : '' }}>
                  El monto a cobrar por atraso está dado en UF
                </label>
              </div>
            </div>
          </div>
          <div class="form-group overdue">
            <label for="overdue_is_uf" class="col-sm-offset-2 col-sm-2 control-label">Cobro diario</label>
            <div class="col-sm-8">
              <div class="checkbox">
                <label>
                  <input type="checkbox" id="overdue_is_daily" name="overdue_is_daily" value="1" {{ (isset($bill->overdue_is_daily) && $bill->overdue_is_daily) ? 'checked' : '' }}>
                  El monto incrementará por cada día de atraso
                </label>
              </div>
            </div>
          </div>
          <div class="form-group overdue">
            <label for="overdue_vfpcode" class="col-sm-offset-2 col-sm-2 control-label">C. Contable actividad</label>
            <div class="col-sm-8">
              <select class="form-control select2" id="overdue_vfpcode" name="overdue_vfpcode" required>
                @foreach($accounts as $account)
                <option value="{{ $account->codigo }}" {{ (isset($bill->overdue_vfpcode)) ? (($bill->overdue_vfpcode == $account->codigo) ? 'selected' : '') : $account->codigo == '52-01-005' ? 'selected' : ''}}>{{ $account->codigo }} - {{ $account->nombre }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="assign" class="col-sm-2 control-label">Asignación</label>
            <div class="col-sm-10">
              <div class="radio">
                <label>
                  <input type="radio" name="assign" id="assign" value="sector" required {{ !$bill->sectors()->count() ?: 'checked' }}>
                  Asignar este cobro a un Sector
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" name="assign" id="assign" value="group" {{ !$bill->groups()->count() ?: 'checked' }}>
                  Asignar este cobro a un Grupo
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" name="assign" id="assign" value="location" {{ !$bill->locations()->count() ?: 'checked' }}>
                  Asignar este cobro a una Ubicación
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="vfpcode" class="col-sm-2 control-label">Activación</label>
            <div class="col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox" id="active" name="active" value="1" {{ $bill->active ? 'checked' : '' }}>
                  El cobro estará activo
                </label>
              </div>
            </div>
          </div>
          <p class="col-sm-12 help-block">Si los montos son definidos en UF, éstos serán calculados el mismo día del cobro, tomando el valor de la UF desde SII.</p>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ url('/list/bills') }}" class="btn btn-primary">Volver al listado</a>
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
    if($(".checkfinish").is(":checked")){
      $(".finish").show();
      $("#end_bill").prop('required',true);
    } else {
      $(".finish").hide();
      $("#end_bill").prop('required',false);
    }
    if($(".checkoverdue").is(":checked")){
      $(".overdue").show();
      $("#overdue_day").prop('required',true);
      $("#overdue_amount").prop('required',true);
      $("#overdue_vfpcode").prop('required',true);
    } else {
      $(".overdue").hide();
      $("#overdue_day").prop('required',false);
      $("#overdue_amount").prop('required',false);
      $("#overdue_vfpcode").prop('required',false);
    }
  });
  $(".checkfinish").click(function() {
    if($(this).is(":checked")) {
      $(".finish").show();
      $("#end_bill").prop('required',true);
    } else {
      $(".finish").hide();
      $("#end_bill").prop('required',false);
    }
  });
  $(".checkoverdue").click(function() {
    if($(this).is(":checked")) {
      $(".overdue").show();
      $("#overdue_day").prop('required',true);
      $("#overdue_amount").prop('required',true);
      $("#overdue_vfpcode").prop('required',true);
    } else {
      $(".overdue").hide();
      $("#overdue_day").prop('required',false);
      $("#overdue_amount").prop('required',false);
      $("#overdue_vfpcode").prop('required',false);
    }
  });
</script>
@endsection
