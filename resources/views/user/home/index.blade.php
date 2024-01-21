@extends('layouts.app')

@section('title', 'Home')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content mb-5 pb-5">
        <section class="section">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="text-dark mb-1">Selamat Datang, </div>
                    <div class="text-dark mb-1">{{ Auth::user()->nama }} ( {{ Auth::user()->jabatan }} )</div>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-6">
                    <div class="card bg-success mr-1">
                        <div class="card-body text-center">
                            <div class="mb-2">Presensi Masuk</div>
                            <div class="mb-2">{{ $presensi ? $presensi->clock_in : "00:00:00" }}</div>
                            <div class="">{{ $presensi ? ($presensi->alasan_in ? "Diluar Radius" : "Dalam Radius") : "Belum Ada" }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card bg-danger ml-1">
                        <div class="card-body text-center">
                            <div class="mb-2">Presensi Keluar</div>
                            <div class="mb-2">{{ $presensi ? ($presensi->clock_out ?? "00:00:00"): "00:00:00" }}</div>
                            <div class="">{{ $presensi ? ($presensi->alasan_out ? "Diluar Radius" : "Belum Ada") : "Belum Ada" }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush