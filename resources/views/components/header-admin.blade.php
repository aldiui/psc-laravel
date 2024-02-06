<div class="navbar-bg bg-danger"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user d-flex justify-content-center align-items-center">
                <div style="background-image: url('{{ asset(Auth::user()->image != 'default.png' ? '/storage/img/karyawan/' . Auth::user()->image : '/images/default.png') }}');"
                    class="img-navbar d-block mr-3"></div>
                <div class="d-sm-none d-lg-inline-block">{{ Auth::user()->nama }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profil') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profil
                </a>
                <a href="{{ route('admin.pengaturan') }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Pengaturan
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </li>
    </ul>
</nav>
