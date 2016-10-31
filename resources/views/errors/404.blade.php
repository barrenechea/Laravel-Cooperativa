@extends('layouts.auth')

@section('htmlheader_title')
Error 404
@endsection

@section('content')
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>
            <div class="error-content">
                <br/>
                <h3><i class="fa fa-warning text-yellow"></i> Oops! {{ trans('adminlte_lang::message.pagenotfound') }}.</h3>
                <p>
                    {{ trans('adminlte_lang::message.notfindpage') }}
                </p>
            </div><!-- /.error-content -->
        </div><!-- /.error-page -->
    </div>
</body>
@endsection