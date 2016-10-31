@extends('layouts.auth')

@section('htmlheader_title')
Error 500
@endsection

@section('content')
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="error-page">
            <h2 class="headline text-red"> 500</h2>
            <div class="error-content">
                <br/>
                <h3><i class="fa fa-warning text-red"></i> Oops! {{ trans('adminlte_lang::message.somethingwrong') }}</h3>
                <p>
                    {{ trans('adminlte_lang::message.wewillwork') }}
                </p>
            </div><!-- /.error-content -->
        </div><!-- /.error-page -->
    </div>
</body>
@endsection