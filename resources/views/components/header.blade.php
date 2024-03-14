<div class="navbar-bg bg-danger"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a class="nav-link d-lg-none font-weight-bold" href="/">PSC 119</a></li>
            <li><a href="#" data-toggle="sidebar" class=" nav-link nav-link-lg d-none d-lg-block"><i
                        class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle">
            <a href="#" onclick="setViewNotifikasi()" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifikasi

                </div>
                <div class="dropdown-list-content dropdown-list-icons" id="list-notifikasi">

                </div>
                <div class="dropdown-footer text-center text-capitalize small text-muted">
                    Notifikasi {{ formatTanggal(date('Y-m-d'), 'F Y') }}
                </div>
            </div>
        </li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user d-flex justify-content-center align-items-center">
                <div style="background-image: url('{{ asset(Auth::user()->image != 'default.png' ? '/storage/img/karyawan/' . Auth::user()->image : '/images/default.png') }}');"
                    class="img-navbar d-block mr-3"></div>
                <div class="d-sm-none d-lg-inline-block">{{ Auth::user()->nama }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('profil') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profil
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </li>
    </ul>
</nav>
