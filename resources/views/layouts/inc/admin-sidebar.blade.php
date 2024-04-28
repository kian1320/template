<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}"
                    href="{{ url('admin/dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>


                <a class="nav-link {{ Request::is('admin/add-items') ? 'active' : '' }}"
                    href="{{ url('admin/add-items') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
                    Add
                </a>


                <a class="nav-link {{ Request::is('admin/items') ? 'active' : '' }}" href="{{ url('admin/items') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
                    View
                </a>


            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:{{ strtoupper(Auth::user()->name) }}</div>

        </div>
    </nav>
</div>
