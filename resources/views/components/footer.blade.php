<footer class="main-footer d-none d-lg-block">
    <div class="text-center">
        Copyright &copy; {{ date("Y")}} <div class="bullet"></div> Created By <span>UBSI Tasikmalaya</span>
    </div>
</footer>
<footer class="main-footer d-block d-lg-none fixed-bottom bg-white">
    <div class="d-flex justify-content-between">
        <div>
            <a class="text-decoration-none {{ Request::is('/') ? 'text-danger' : 'text-secondary' }} text-center" href="{{ url('/') }}"><i class="d-block mb-2 fas fa-home"></i> <div class="text-mini text-center">Beranda</div></a>
        </div>
        <div>
            <a class="text-decoration-none {{ Request::is('izin') ? 'text-danger' : 'text-secondary' }} text-center"
                href="{{ url('izin') }}"><i class="d-block mb-2 fas fa-calendar"></i> <div class="text-mini text-center">Izin</div></a>
        </div>
        <div>
            <a class="text-decoration-none {{ Request::is('presensi') ? 'text-danger' : 'text-secondary' }} text-center"
                href="{{ url('presensi') }}"><i class="d-block mb-2 fas fa-camera"></i> <div class="text-mini text-center">Presensi</div></a>
        </div>
        <div>
            <a class="text-decoration-none {{ Request::is('stok/*') || Request::is('stok') ? 'text-danger' : 'text-secondary' }} text-center"
                href="{{ url('stok') }}"><i class="d-block mb-2 fas fa-clipboard-list"></i> <div class="text-mini text-center">Stok</div></a>
        </div>
        <div>
            <a class="text-decoration-none {{ Request::is('profil') ? 'text-danger' : 'text-secondary' }} text-center"
                href="{{ url('profil') }}"><i class="d-block mb-2 fas fa-user"></i> <div class="text-mini text-center">Profil</div></a>
        </div>
    </div>
</footer>
