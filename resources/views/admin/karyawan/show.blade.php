@extends('layouts.admin')

@section('title', 'Karyawan')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/admin/">Beranda</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.karyawan.index') }}"> @yield('title')</a></div>
                    <div class="breadcrumb-item">Detail @yield('title')</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-dark">Data Detail @yield('title')</h4>
                                <div class="ml-auto">
                                    <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary"><i
                                            class="fas fa-arrow-left mr-2"></i>Kembali</a>
                                    
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-4 col-lg-2 mb-2">Nama</div>
                                        <div class="col-8 col-lg-10 mb-2">: {{ $karyawan->nama }}</div>
                                        <div class="col-4 col-lg-2 mb-2">Email</div>
                                        <div class="col-8 col-lg-10 mb-2">: {{ $karyawan->email }}</div>
                                        <div class="col-4 col-lg-2 mb-2">Jabatan</div>
                                        <div class="col-8 col-lg-10 mb-2">: {{ $karyawan->jabatan }}</div>
                                        <div class="col-4 col-lg-2 mb-2">No Hp</div>
                                        <div class="col-8 col-lg-10 mb-2">: {{ $karyawan->no_hp }}</div>
                                        <div class="col-4 col-lg-2 mb-2">Role</div>
                                        <div class="col-8 col-lg-10 mb-2">: {{ $karyawan->role }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

@endpush
