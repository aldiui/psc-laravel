@extends('layouts.admin')

@section('title', 'Stok')

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
                                    <a href="{{ route('admin.stok.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>    
                                    <button class="btn btn-success" id="createBtn" onclick="getModal('createModal')"><i class="fas fa-plus mr-2"></i>Tambah</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-5 col-lg-2 mb-2">Tanggal</div>
                                        <div class="col-5 col-lg-10 mb-2">: {{ $stok->tanggal }}</div>
                                        <div class="col-5 col-lg-2 mb-2">Nama</div>
                                        <div class="col-5 col-lg-10 mb-2">: {{ $stok->user->nama }}</div>
                                        <div class="col-5 col-lg-2 mb-2">Jenis</div>
                                        <div class="col-5 col-lg-10 mb-2">: {{ $stok->jenis }}</div>
                                        <div class="col-5 col-lg-2 mb-2">Status</div>
                                        <div class="col-5 col-lg-10 mb-2">
                                            : {!! statusBadge($stok->status) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table" id="detailStokTable" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="5%">#</th>
                                                <th scope="col">Nama Barang</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Deskripsi</th>
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
@include('admin.detail-stok.create')
@include('admin.detail-stok.edit')
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <!--  -->
    <script>
        $(document).ready(function() {
            datatableCall('detailStokTable', '/admin/stok/{{ $stok->id }}', [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nama', name: 'nama' },
                { data: 'qty', name: 'qty' },
                { data: 'deskripsi', name: 'deskripsi' },
                { data: 'aksi', name: 'aksi' },
            ]);

            $("#createBtn").click(function () {
                select2ToJson("#barang_id", "{{ route('admin.barang.index') }}", "Pilih Barang", "#createModal");
            });

            $("#saveData").submit(function (e) {
                setButtonLoadingState("#saveData .btn.btn-success", true);
                e.preventDefault();
                const url = "{{ route('admin.detail-stok.store') }}";
                const data = new FormData(this);

                const successCallback = function (response) {
                    setButtonLoadingState("#saveData .btn.btn-success", false);
                    handleSuccess(response, "detailStokTable", "createModal");
                };

                const errorCallback = function (error) {
                    setButtonLoadingState("#saveData .btn.btn-success", false);
                    handleValidationErrors(error, "saveData", ["stok_id", "barang_id", "qty", "deskripsi"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });

            $("#updateData").submit(function (e) {
                setButtonLoadingState("#updateData .btn.btn-success", true);
                e.preventDefault();
                const kode = $("#updateData #id").val();
                const url = `/admin/detail-stok/${kode}`;
                const data = new FormData(this);

                const successCallback = function (response) {
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleSuccess(response, "detailStokTable", "editModal");
                };

                const errorCallback = function (error) {
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleValidationErrors(error, "updateData", ["stok_id", "barang_id", "qty", "deskripsi"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        }); 

        function getSelectEdit(){
            select2ToJson(".editBarang", "{{ route('admin.barang.index') }}", "Pilih Barang", "#editModal");
        }
    </script>
@endpush
