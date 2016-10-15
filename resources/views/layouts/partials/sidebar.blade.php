<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <li><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>{{ trans('adminlte_lang::message.home') }}</span></a></li>

            @if(Auth::user()->is_admin)
            <!-- Admin options -->
            @if(Auth::user()->role->can_handle_admins || Auth::user()->role->can_sync_users)
            <!-- New Users -->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-plus"></i>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i><span>Registro</span>
                </span>
              </a>
              <ul class="treeview-menu" style="display: none;">
                @if(Auth::user()->role->can_handle_admins)
                <li><a href="{{ url('register/admin') }}"><i class="fa fa-circle-o"></i> Administrador</a></li>
                @endif
                @if(Auth::user()->role->can_sync_users)
                <li><a href="{{ url('register/socio') }}"><i class="fa fa-circle-o"></i> Socio</a></li>
                @endif
              </ul>
            </li>
            @endif
            @if(Auth::user()->role->can_view_data)
            <!-- View options -->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-search"></i>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i><span>Ver datos</span>
                </span>
              </a>
              <ul class="treeview-menu" style="display: none;">
                @if(Auth::user()->role->can_view_overdue)
                <li><a href="#"><i class="fa fa-circle-o"></i> Reporte de morosos</a></li>
                @endif
                <li><a href="#"><i class="fa fa-circle-o"></i> Por local</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Por socio</a></li>
              </ul>
            </li>
            @endif
            @if(Auth::user()->role->can_send_messages)
            <!-- Message option -->
            <li><a href="#"><i class="fa fa-envelope"></i> <span>Nuevo mensaje</span></a></li>
            @endif
            @if(Auth::user()->role->can_upload)
            <!-- Message option -->
            <li><a href="#"><i class="fa fa-upload"></i> <span>Subir archivo</span></a></li>
            @endif
            @if(Auth::user()->role->can_external_accounting)
            <!-- Message option -->
            <li><a href="#"><i class="fa fa-money"></i> <span>Contabilidad externa</span></a></li>
            @endif
            @endif
        </ul><!-- /.sidebar-menu -->

    </section>
    <!-- /.sidebar -->
</aside>
