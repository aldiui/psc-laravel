<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">PSC 119</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">PSC</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link"
                href="{{ url('blank-page') }}"><i class="material-icons">&#xe871;</i> <span>Dashboard</span></a>
            </li>
            <li class="menu-header">Manajemen Stok</li>
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('blank-page') }}"><i class="fas fa-balance-scale"></i> <span>Unit</span></a>
            </li>
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('blank-page') }}"><i class="fas fa-boxes"></i> <span>Kategori</span></a>
            </li>
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('blank-page') }}"><i class="fas fa-box"></i> <span>Barang</span></a>
            </li>
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('blank-page') }}"><i class="fas fa-clipboard-list"></i> <span>Stok</span></a>
            </li>
            <li class="menu-header">Manajemen Karyawan</li>
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('blank-page') }}"><i class="fas fa-user-tie"></i> <span>Karyawan</span></a>
            </li>
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('blank-page') }}"><i class="fas fa-users"></i> <span>Kelompok/Tim</span></a>
            </li>
            {{-- <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('blank-page') }}"><i class="fas fa-fire"></i> <span>Jadwal</span></a>
            </li>
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('blank-page') }}"><i class="fas fa-fire"></i> <span>Presensi</span></a>
            </li>
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('blank-page') }}"><i class="fas fa-fire"></i> <span>Izin</span></a>
            </li>
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('blank-page') }}"><i class="fas fa-fire"></i> <span>Cuti</span></a>
            </li> --}}
            <li class="menu-header">Manajemen Pengaturan</li>
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('blank-page') }}"><i class="fas fa-gear"></i> <span>Pengaturan</span></a>
            </li>
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('blank-page') }}"><i class="fas fa-user"></i> <span>Profil</span></a>
            </li>
        </ul>
        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://getstisla.com/docs"
                class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>
</div>
