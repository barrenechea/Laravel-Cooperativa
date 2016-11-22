<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu">
      <li class="header">MENÚ</li>
      <li><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>{{ trans('adminlte_lang::message.home') }}</span></a></li>
      @can('adminsystem')
      <li class="treeview">
        <a href="#">
          <i class="fa fa-exclamation-triangle"></i>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i><span>Administrar sistema</span>
          </span>
        </a>
        <ul class="treeview-menu" style="display: none;">
          @can('view_list_admin')
          <li><a href="{{ url('list/admin') }}"><i class="fa fa-circle-o"></i> Administradores</a></li>
          @endcan
          @can('view_list_partner')
          <li><a href="{{ url('list/partner') }}"><i class="fa fa-circle-o"></i> Socios</a></li>
          @endcan
          @can('view_report_overdue')
          <li><a href="{{ url('report/overdue') }}"><i class="fa fa-circle-o"></i> Reporte de morosos</a></li>
          @endcan
          @can('view_log')
          <li><a href="{{ url('report/log') }}"><i class="fa fa-circle-o"></i> Registro de actividad</a></li>
          @endcan
          @can('view_systeminfo')
          <li><a href="{{ url('systemstatus') }}"><i class="fa fa-circle-o"></i> Información</a></li>
          @endcan
        </ul>
      </li>
      @endcan
      @can('view_report_external_accounting')
      <li><a href="{{ url('report/accounting') }}"><i class="fa fa-money"></i> <span>Contabilidad</span></a></li>
      @endcan
      @if(!Auth::user()->is_admin)
      <li><a href="{{ url('partner/mybills') }}"><i class="fa fa-money"></i> <span>Mis cobros</span></a></li>
      @endif
      <li><a href="{{ url('list/messages') }}"><i class="fa fa-comment-o"></i><span>Ver mensajes</span></a></li>
      <li><a href="{{ url('list/files') }}"><i class="fa fa-file-o"></i><span>Ver archivos</span></a></li>
    </ul>
  </section>
</aside>
