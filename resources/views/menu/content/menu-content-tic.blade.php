<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{asset('/tic')}}">
    <div class="sidebar-brand-icon">
        <i class="fas fa-hospital"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Unidad TIC <sup>CAPLC </sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="{{asset('/tic')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    MENU
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-computer"></i>
        <span>Inventario</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Inventario:</h6>
            <a class="collapse-item" href="{{asset('/inventario/pc')}}" >PC</a>
            <a class="collapse-item" href="{{asset('/inventario/impresoras')}}" >Impresoras</a>
            <a class="collapse-item" href="{{asset('/inventario/anexos')}}" >Anexos</a>
            <a class="collapse-item" href="{{asset('/inventario/huelleros')}}" >Huelleros</a>
            <a class="collapse-item" href="{{asset('/inventario/monitores')}}" >Monitores</a>
        </div>
    </div>

    <hr class="sidebar-divider">
    
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTres"
        aria-expanded="true" aria-controls="collapseTres">
        <i class="fas fa-cog"></i>
        <span>Mantenedores</span>
    </a>
    <div id="collapseTres" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Mantenedores:</h6>
            <a class="collapse-item" href="{{asset('/inventario/mantenedor')}}" >Ubicaciones</a>
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider">