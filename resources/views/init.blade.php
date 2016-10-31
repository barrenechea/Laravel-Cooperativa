@extends('layouts.auth')

@section('htmlheader_title', 'Inicializar su cuenta')

@section('content')
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('/img/logobig.png') }}" alt="Logo" />
        </div>
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Ups!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="login-box-body">
            <p class="login-box-msg"> Llene los siguientes datos antes de poder acceder a su cuenta </p>
            <form action="{{ url('/init') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Nombre y apellido" name="name" value="{{ old('name') ? old('name') : Auth::user()->name }}" required />
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                @if(!Auth::user()->is_admin)
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Dirección de residencia" name="address" value="{{ old('address') }}" required />
                    <span class="glyphicon glyphicon-home form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Teléfono de contacto" name="phone" value="{{ old('phone') }}" required />
                    <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
                </div>
                @endif
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Nueva contraseña" name="password" required />
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('layouts.partials.scripts_auth')
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>
@endsection