@extends('layouts.admin')

@section('title', 'Barang')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/dropify/css/dropify.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
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
                                    <button class="btn btn-success" id="createBtn" onclick="getModal('createModal')"><i class="fas fa-plus mr-2"></i>Tambah</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <a href="{{ route('admin.barang.show', 'pdf') }}" class="btn btn-sm px-3 btn-danger mr-1"><i class="fas fa-file-pdf mr-2"></i>Pdf</a>
                                    <a href="{{ route('admin.barang.show', 'excel') }}" class="btn btn-sm px-3 btn-info"><i class="fas fa-file-excel mr-2"></i>Excel</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table" id="barangTable" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="5%">#</th>
                                                <th scope="col" width="10%">Foto</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Kategori</th>
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
@include('admin.barang.create')
@include('admin.barang.edit')
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('library/dropify/js/dropify.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify();

            datatableCall('barangTable', '{{ route('admin.barang.index') }}', [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'img', name: 'img' },
                { data: 'nama', name: 'nama' },
                { data: 'qty_unit', name: 'qty_unit' },
                { data: 'kategori', name: 'kategori' },
                { data: 'aksi', name: 'aksi' },
            ]);
            
            
            $("#createBtn").click(function () {
                select2ToJson("#unit_id", "{{ route('admin.unit.index') }}", "#createModal");
                select2ToJson("#kategori_id", "{{ route('admin.kategori.index') }}", "#createModal");
            });

            $("#saveData").submit(function (e) {
                setButtonLoadingState("#saveData .btn.btn-success", true);
                e.preventDefault();
                const url = "{{ route('admin.barang.store') }}";
                const data = new FormData(this);

                const successCallback = function (response) {
                    $('#saveData #image').parent().find(".dropify-clear").trigger('click');
                    setButtonLoadingState("#saveData .btn.btn-success", false);
                    handleSuccess(response, "barangTable", "createModal");
                };

                const errorCallback = function (error) {
                    setButtonLoadingState("#saveData .btn.btn-success", false);
                    handleValidationErrors(error, "saveData", ["nama", "kategori_id", "unit_id", "qty", "deskripsi", "image"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });

            $("#updateData").submit(function (e) {
                setButtonLoadingState("#updateData .btn.btn-success", true);
                e.preventDefault();
                const kode = $("#updateData #id").val();
                const url = `/admin/barang/${kode}`;
                const data = new FormData(this);

                const successCallback = function (response) {
                    $('#updateData #image').parent().find(".dropify-clear").trigger('click');
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleSuccess(response, "barangTable", "editModal");
                };

                const errorCallback = function (error) {
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleValidationErrors(error, "updateData", ["nama", "kategori_id", "unit_id", "qty", "deskripsi", "image"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });

        function getSelectEdit(){
            select2ToJson(".editUnit", "{{ route('admin.unit.index') }}", "#editModal");
            select2ToJson(".editKategori", "{{ route('admin.kategori.index') }}", "#editModal");
        }
    </script>
@endpush