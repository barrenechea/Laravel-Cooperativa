@extends('layouts.auth')

@section('htmlheader_title', 'Servicio no disponible')

@section('content')
<body class="hold-transition login-page">
    <div class="row">
        <div class="login-box">
            <div class="error-content">
                <br/>
                <h3><i class="fa fa-warning text-red"></i> Oops! {{ trans('adminlte_lang::message.serviceunavailable') }}</h3>
                <p>
                    {{ trans('adminlte_lang::message.wewillwork') }}
                </p>
            </div>
        </div>
    </div>
</body>
@endsection