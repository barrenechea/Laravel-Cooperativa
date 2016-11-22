@extends('layouts.auth')

@section('htmlheader_title', 'Servicio no disponible')

@section('content')
<body class="hold-transition login-page">
    <div class="row">
        <div class="login-box">
            <div class="error-content">
                <br/>
                <h3><i class="fa fa-warning text-red"></i> Oops! Servicio no disponible</h3>
                <p>La plataforma se encuenta en mantención. Intente nuevamente más tarde.</p>
            </div>
        </div>
    </div>
</body>
@endsection