<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu">
      <li class="header">MENÚ</li>
      <li><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>{{ trans('adminlte_lang::message.home') }}</span></a></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-exclamation-triangle"></i>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i><span>Administrar sistema</span>
          </span>
        </a>
        <ul class="treeview-menu" style="display: none;">
          <li><a href="{{ url('list/admin') }}"><i class="fa fa-circle-o"></i> Administradores</a></li>
          <li><a href="{{ url('list/partner') }}"><i class="fa fa-circle-o"></i> Socios</a></li>
          <li><a href="{{ url('system/overduedates') }}"><i class="fa fa-circle-o"></i> Días de morosidad</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i> Reporte de morosos</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i> Registro de actividad</a></li>
          <li><a href="{{ url('systemstatus') }}"><i class="fa fa-circle-o"></i> Información</a></li>
        </ul>
      </li>
      <li><a href="#"><i class="fa fa-money"></i> <span>Contabilidad externa</span></a></li>

      <li><a href="{{ url('list/messages') }}"><i class="fa fa-comment-o"></i><span>Ver mensajes</span></a></li>
      <li><a href="{{ url('list/files') }}"><i class="fa fa-file-o"></i><span>Ver archivos</span></a></li>
    </ul>
  </section>
</aside>
