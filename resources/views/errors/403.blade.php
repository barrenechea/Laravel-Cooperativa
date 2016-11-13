@extends('layouts.auth')

@section('htmlheader_title')
Error 403
@endsection

@section('content')
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="error-page">
            <h2 class="headline text-red"> 403</h2>
            <div class="error-content">
                <br/>
                <h3><i class="fa fa-warning text-red"></i> Oops! Permisos no otorgados.</h3>
                <p>
                    Usted no posee permisos suficientes para ver esta página.
                </p>
            </div>
        </div>
    </div>
</body>
@endsection