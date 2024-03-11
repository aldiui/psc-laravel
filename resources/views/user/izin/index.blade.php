@extends('layouts.app')

@section('title', 'Izin')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/dropify/css/dropify.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-none d-lg-block">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/">Beranda</a></div>
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
                                    <button class="btn btn-success" onclick="getModal('createModal')"><i
                                            class="fas fa-plus mr-2"></i>Tambah</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="bulan_filter" class="form-label">Bulan</label>
                                            <select name="bulan_filter" id="bulan_filter" class="form-control">
                                                @foreach (bulan() as $key => $value)
                                                    <option value="{{ $key + 1 }}"
                                                        {{ $key + 1 == date('m') ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tahun_filter" class="form-label">Tahun</label>
                                            <select name="tahun_filter" id="tahun_filter" class="form-control">
                                                @for ($i = now()->year; $i >= now()->year - 4; $i--)
                                                    <option value="{{ $i }}"
                                                        {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="izinTable" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="5%">#</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Tipe</th>
                                                <th scope="col">Alasan</th>
                                                <th scope="col">Status</th>
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
    @include('user.izin.create')
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('library/dropify/js/dropify.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify();

            datatableCall('izinTable', '{{ route('izin.index') }}', [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'tipe',
                    name: 'tipe'
                },
                {
                    data: 'alasan',
                    name: 'alasan'
                },
                {
                    data: 'status_badge',
                    name: 'status_badge'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                },
            ]);

            $("#bulan_filter, #tahun_filter").on("change", function() {
                $("#izinTable").DataTable().ajax.reload();
            });

            $("#saveData").submit(function(e) {
                setButtonLoadingState("#saveData .btn.btn-success", true);
                e.preventDefault();
                const kode = $("#saveData #id").val();
                let url = "{{ route('izin.store') }}";
                const data = new FormData(this);

                if (kode !== "") {
                    data.append("_method", "PUT");
                    url = `/izin/${kode}`;
                }

                const successCallback = function(response) {
                    $('#saveData #image').parent().find(".dropify-clear").trigger('click');
                    setButtonLoadingState("#saveData .btn.btn-success", false);
                    handleSuccess(response, "izinTable", "createModal");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#saveData .btn.btn-success", false);
                    handleValidationErrors(error, "saveData", ["tanggal_mulai", "tanggal_selesai",
                        "tipe", "alasan", "file"
                    ]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush
