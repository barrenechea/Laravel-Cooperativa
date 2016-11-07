<header class="main-header">
    <a href="{{ url('/home') }}" class="logo">
        <span class="logo-mini"><img src="{{ asset('/img/logo_small.png') }}" alt="Baby logo" style="max-width: 40px" /></span>
        
        <span class="logo-lg"><img src="{{ asset('/img/logo_medium_white.png') }}" alt="Logo blanco" style="max-height: 30px" /></span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/update/profile') }}"><i class="fa fa-user"></i> Actualizar mi perfil</a></li>
                <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Salir</a></li>
            </ul>
        </div>
    </nav>
</header>
