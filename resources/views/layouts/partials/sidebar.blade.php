<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">MENÚ</li>
      <li><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>{{ trans('adminlte_lang::message.home') }}</span></a></li>

      @if(Auth::user()->is_admin)
      <!-- Admin options -->
      @if(Auth::user()->roles->where('name', 'can_manage_sector_type_location')->count() > 0)
      <li class="treeview">
        <a href="#">
          <i class="fa fa-exclamation-triangle"></i>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i><span>Administrar sistema</span>
          </span>
        </a>
        <ul class="treeview-menu" style="display: none;">
          @if(Auth::user()->roles->where('name', 'can_handle_admins')->count() > 0)
          <li>
            <a href="#"><i class="fa fa-circle-o"></i> Administradores
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="display: none;">
              <li><a href="{{ url('register/admin') }}"><i class="fa fa-circle-o"></i> Agregar</a></li>
              <li><a href="{{ url('list/admin') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
            </ul>
          </li>
          @endif
          @if(Auth::user()->roles->where('name', 'can_sync_users')->count() > 0)
          <li>
            <a href="#"><i class="fa fa-circle-o"></i> Socios
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="display: none;">
              <li><a href="{{ url('register/partner') }}"><i class="fa fa-circle-o"></i> Agregar</a></li>
              <li><a href="{{ url('list/partner') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
            </ul>
          </li>
          @endif
          @if(Auth::user()->roles->where('name', 'can_manage_sector_type_location')->count() > 0)
          <li><a href="{{ url('system/base') }}"><i class="fa fa-circle-o"></i> Sector, tipo, ubicación</a></li>
          @endif
          @if(Auth::user()->roles->where('name', 'can_manage_groups')->count() > 0)
          <li><a href="{{ url('system/group') }}"><i class="fa fa-circle-o"></i> Agregar grupos</a></li>
          @endif
          <li><a href="{{ url('bill/create') }}"><i class="fa fa-circle-o"></i> Agregar cobros</a></li>
          <li><a href="{{ url('expenses') }}"><i class="fa fa-circle-o"></i> Gastos</a></li>
        </ul>
        <li><a href="{{ url('system/overduedates') }}"><i class="fa fa-calendar"></i> <span>Días de morosidad</span></a></li>
      </li>
      @endif
      @if(Auth::user()->roles->where('name', 'can_send_messages')->count() > 0)
      <!-- Message option -->
      <li><a href="{{ url('messages/add') }}"><i class="fa fa-envelope"></i> <span>Nuevo mensaje</span></a></li>
      @endif
      @if(Auth::user()->roles->where('name', 'can_upload')->count() > 0)
      <!-- Message option -->
      <li><a href="{{ url('fileentry') }}"><i class="fa fa-upload"></i> <span>Subir archivo</span></a></li>
      @endif
      @if(Auth::user()->roles->where('name', 'can_external_accounting')->count() > 0)
      <!-- Message option -->
      <li><a href="#"><i class="fa fa-money"></i> <span>Contabilidad externa</span></a></li>
      @endif
      @endif
      <!-- View options -->
      <li class="treeview">
        <a href="#">
          <i class="fa fa-eye"></i>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i><span>Ver</span>
          </span>
        </a>
        <ul class="treeview-menu" style="display: none;">
          @if(Auth::user()->roles->where('name', 'can_view_overdue')->count() > 0)
          <li><a href="#"><i class="fa fa-circle-o"></i> Reporte de morosos</a></li>
          @endif
          <li><a href="{{ url('view/messages') }}"><i class="fa fa-circle-o"></i> Mensajes</a></li>
          <li><a href="{{ url('view/files') }}"><i class="fa fa-circle-o"></i> Archivos</a></li>
        </ul>
      </li>
      <li><a href="{{ url('systemstatus') }}"><i class="fa fa-info"></i> <span>Información</span></a></li>
    </ul><!-- /.sidebar-menu -->

  </section>
  <!-- /.sidebar -->
</aside>
