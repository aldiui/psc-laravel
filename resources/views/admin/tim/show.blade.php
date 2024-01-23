@extends('layouts.admin')

@section('title', 'Tim')

@push('style')
    <!-- CSS Libraries -->
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
                    <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.tim.index') }}"> @yield('title')</a></div>
                    <div class="breadcrumb-item">Detail @yield('title')</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-dark">Data Detail  @yield('title')</h4>
                                <div class="ml-auto">
                                    <a href="{{ route('admin.tim.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
                                    <button class="btn btn-success" id="createBtn" onclick="getModal('createModal')"><i class="fas fa-plus mr-2"></i>Tambah</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-5 col-lg-2 mb-2">Nama Tim</div>
                                        <div class="col-5 col-lg-10 mb-2">: {{ $tim->nama }}</div>
                                        <div class="col-5 col-lg-2 mb-2">Deskripsi</div>
                                        <div class="col-5 col-lg-10 mb-2">: {{ $tim->deskripsi }}</div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                <table class="table" id="detailTimTable" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="5%">#</th>
                                                <th scope="col" width="10%">Foto</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Posisi</th>
                                                <th scope="col" width="20%">Aksi</th>
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
@include('admin.detail-tim.create')
@include('admin.detail-tim.edit')
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            datatableCall('detailTimTable', '/admin/tim/{{ $tim->id }}', [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'img', name: 'img' },
                { data: 'nama', name: 'nama' },
                { data: 'posisi', name: 'posisi' },
                { data: 'aksi', name: 'aksi' },
            ]);

            $("#createBtn").click(function () {
                select2ToJson("#user_id", "{{ route('admin.karyawan.index') }}", "Pilih Karyawan", "#createModal");
            });

            $("#saveData").submit(function (e) {
                setButtonLoadingState("#saveData .btn.btn-success", true);
                e.preventDefault();
                const url = "{{ route('admin.detail-tim.store') }}";
                const data = new FormData(this);

                const successCallback = function (response) {
                    setButtonLoadingState("#saveData .btn.btn-success", false);
                    handleSuccess(response, "detailTimTable", "createModal");
                };

                const errorCallback = function (error) {
                    setButtonLoadingState("#saveData .btn.btn-success", false);
                    handleValidationErrors(error, "saveData", ["tim_id", "user_id", "posisi"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });

            $("#updateData").submit(function (e) {
                setButtonLoadingState("#updateData .btn.btn-success", true);
                e.preventDefault();
                const kode = $("#updateData #id").val();
                const url = `/admin/detail-tim/${kode}`;
                const data = new FormData(this);

                const successCallback = function (response) {
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleSuccess(response, "detailTimTable", "editModal");
                };

                const errorCallback = function (error) {
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleValidationErrors(error, "updateData", ["user_id", "posisi"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        }); o

        function getSelectEdit(){
            select2ToJson(".editUser", "{{ route('admin.karyawan.index') }}", "Pilih Karyawan", "#editModal");
        }
    </script>
@endpush
