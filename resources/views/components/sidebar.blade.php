<div class="main-sidebar sidebar-style-2 d-none d-lg-block">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="admin">PSC 119</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="admin">PSC</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('/') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('/') }}"><i class="fas fa-home"></i> <span>Home</span></a>
            </li>
            <li class="{{ Request::is('izin') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('izin') }}"><i class="fas fa-calendar"></i> <span>Izin</span></a>
            </li>
            <li class="{{ Request::is('presensi') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('presensi') }}"><i class="fas fa-camera"></i> <span>Presensi</span></a>
            </li>
            <li class="{{ Request::is('stok/*') ? 'active' : '' }}{{ Request::is('stok') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('stok') }}"><i class="fas fa-clipboard-list"></i> <span>Stok</span></a>
            </li>
            <li class="{{ Request::is('profil') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('profil') }}"><i class="fas fa-user"></i> <span>Profil</span></a>
            </li>
        </ul>
        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="{{ route('logout') }}"
                class="btn btn-danger  btn-block btn-icon-split">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>
</div>
