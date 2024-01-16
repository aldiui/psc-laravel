@extends('layouts.admin')

@section('title', 'Karyawan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/dropify/css/dropify.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>@yield('title')</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                <div class="breadcrumb-item">@yield('title')</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-dark">Data @yield('title')</h4>
                            <div class="ml-auto">
                                <button class="btn btn-success" onclick="getModal('createModal')"><i class="fas fa-plus mr-2"></i>Tambah</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="karyawanTable">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="5%">#</th>
                                            <th scope="col" width="10%">Foto</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Jabatan</th>
                                            <th scope="col">Role</th>
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
@include('admin.karyawan.create')
@include('admin.karyawan.edit')
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('library/dropify/js/dropify.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify();

            datatableCall('karyawanTable', '{{ route('admin.karyawan.index') }}', [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'img', name: 'img' },
                { data: 'nama', name: 'nama' },
                { data: 'jabatan', name: 'jabatan' },
                { data: 'role', name: 'role' },
                { data: 'aksi', name: 'aksi' },
            ]);

            $("#saveData").submit(function (e) {
                setButtonLoadingState("#saveData .btn.btn-success", true);
                e.preventDefault();
                const url = "{{ route('admin.karyawan.store') }}";
                const data = new FormData(this);

                const successCallback = function (response) {
                    $('#saveData #image').parent().find(".dropify-clear").trigger('click');
                    setButtonLoadingState("#saveData .btn.btn-success", false);
                    handleSuccess(response, "karyawanTable", "createModal");
                };

                const errorCallback = function (error) {
                    setButtonLoadingState("#saveData .btn.btn-success", false);
                    handleValidationErrors(error, "saveData", ["nama", "email", "password", "konfirmasi_password", "jabatan", "no_hp", "role", "image"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });

            $("#updateData").submit(function (e) {
                setButtonLoadingState("#updateData .btn.btn-success", true);
                e.preventDefault();
                const kode = $("#updateData #id").val();
                const url = `/admin/karyawan/${kode}`;
                const data = new FormData(this);

                const successCallback = function (response) {
                    $('#updateData #image').parent().find(".dropify-clear").trigger('click');
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleSuccess(response, "karyawanTable", "editModal");
                };

                const errorCallback = function (error) {
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleValidationErrors(error, "updateData", ["nama", "email", "password", "konfirmasi_password", "jabatan", "no_hp", "role", "image"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush