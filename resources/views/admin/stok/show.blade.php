@extends('layouts.admin')

@section('title', 'Stok')

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
                    <div class="breadcrumb-item active"><a href="/admin">Beranda</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.stok.index') }}"> @yield('title')</a></div>
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
                                    <a href="{{ route('admin.stok.index') }}" class="btn btn-secondary"><i
                                            class="fas fa-arrow-left mr-2"></i>Kembali</a>
                                    @if ($stok->status != 1)
                                        <button class="btn btn-success" id="createBtn" onclick="getModal('createModal')"><i
                                                class="fas fa-plus mr-2"></i>Tambah</button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-4 col-lg-2 mb-2">Tanggal</div>
                                        <div class="col-8 col-lg-10 mb-2">: {{ formatTanggal($stok->tanggal) }}</div>
                                        <div class="col-4 col-lg-2 mb-2">Nama</div>
                                        <div class="col-8 col-lg-10 mb-2">: {{ $stok->user->nama }}</div>
                                        <div class="col-4 col-lg-2 mb-2">Jenis</div>
                                        <div class="col-8 col-lg-10 mb-2">: {{ $stok->jenis }}</div>
                                        <div class="col-4 col-lg-2 mb-2">Status</div>
                                        <div class="col-8 col-lg-10 mb-2">
                                            : {!! statusBadge($stok->status) !!}
                                        </div>
                                        <div class="col-4 col-lg-2 mb-2">Persetujuan</div>
                                        <div class="col-8 col-lg-10 mb-2">
                                            :
                                            @if ($stok->status != 1)
                                                <button class="btn btn-primary btn-sm" type="button"
                                                    onclick="confirmStok('{{ $stok->id }}')"><i
                                                        class="fas fa-question-circle mr-1"></i>Konfirmasi</button>
                                            @else
                                                @if ($stok->approval_id != null)
                                                    {{ $stok->approval->nama }}
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="detailStokTable" width="100%">
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
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            datatableCall('detailStokTable', '/admin/stok/{{ $stok->id }}', [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'deskripsi',
                    name: 'deskripsi'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                },
            ]);

            select2ToJson("#barang_id",
                "{{ $stok->jenis == 'Masuk Unit' ? route('admin.barang-bawah.index') : route('admin.barang.index') }}",
                "#createModal", "{{ $stok->jenis == 'Masuk Unit' ? 'barang-bawah' : 'null' }}");


            $("#saveData").submit(function(e) {
                setButtonLoadingState("#saveData .btn.btn-success", true);
                e.preventDefault();
                const kode = $("#saveData #id").val();
                let url = "{{ route('admin.detail-stok.store') }}";
                const data = new FormData(this);

                if (kode !== "") {
                    data.append("_method", "PUT");
                    url = `/admin/detail-stok/${kode}`;
                }

                const successCallback = function(response) {
                    setButtonLoadingState("#saveData .btn.btn-success", false);
                    handleSuccess(response, "detailStokTable", "createModal");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#saveData .btn.btn-success", false);
                    handleValidationErrors(error, "saveData", ["stok_id", "barang_id", "qty",
                        "deskripsi"
                    ]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });

            $("#updateData").submit(function(e) {
                setButtonLoadingState("#updateData .btn.btn-success", true);
                e.preventDefault();
                const kode = $("#updateData #id").val();
                const url = `/admin/detail-stok/${kode}`;
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleSuccess(response, "detailStokTable", "editModal");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleValidationErrors(error, "updateData", ["stok_id", "barang_id", "qty",
                        "deskripsi"
                    ]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush
