@extends('layouts.auth')

@section('htmlheader_title', 'Permisos no otorgados')

@section('content')
<body class="hold-transition login-page">
    <div class="row">
        <div class="login-box">
            <div class="error-content">
                <br/>
                <h3><i class="fa fa-warning text-red"></i> Oops! Permisos no otorgados</h3>
                <p>
                    Usted no posee permisos suficientes para ver esta página.
                </p>
            </div>
        </div>
    </div>
</body>
@endsection