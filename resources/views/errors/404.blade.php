@extends('layouts.auth')

@section('htmlheader_title', 'Página no encontrada')

@section('content')
<body class="hold-transition login-page">
    <div class="row">
        <div class="login-box">
            <div class="error-content">
                <br/>
                <h3><i class="fa fa-warning text-yellow"></i> Oops! Página no encontrada</h3>
                <p>
                    No hemos podido encontrar la página que estabas buscando.
                </p>
            </div>
        </div>
    </div>
</body>
@endsection