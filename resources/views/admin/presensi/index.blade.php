@extends('layouts.admin')

@section('title', 'Presensi')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/admin">Beranda</a></div>
                    <div class="breadcrumb-item">@yield('title')</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-dark">Data @yield('title')</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tanggal_filter" class="form-label">Tanggal</label>
                                            <input type="date" name="tanggal_filter" id="tanggal_filter"
                                                value="{{ date('Y-m-d') }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="presensiTable" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="5%">#</th>
                                                <th scope="col" width="10%">Foto</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Presensi Masuk</th>
                                                <th scope="col">Presensi Keluar</th>
                                                <th scope="col" width="25%">Tugas</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
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

    <script>
        $(document).ready(function() {
            datatableCall('presensiTable', '{{ route('admin.presensi.index') }}', [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'img',
                    name: 'img'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'presensi_masuk',
                    name: 'presensi_masuk'
                },
                {
                    data: 'presensi_keluar',
                    name: 'presensi_keluar'
                },
                {
                    data: 'tugas_catatan',
                    name: 'tugas_catatan'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                },
            ]);

            $("#tanggal_filter").on("change", function() {
                $("#presensiTable").DataTable().ajax.reload();
            });
        });
    </script>
@endpush
