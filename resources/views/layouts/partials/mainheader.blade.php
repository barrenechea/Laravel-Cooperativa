<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">Coop</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{ Auth::user()->is_admin ? 'Panel de Admin.' : 'Panel de Socio' }}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @if (Auth::guest())
                    <li>
                        <a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a>
                    </li>
                @else
                    <li>
                        <a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Salir</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>
