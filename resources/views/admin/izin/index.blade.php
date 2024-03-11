@extends('layouts.admin')

@section('title', 'Izin')

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
                                <div class="mb-3">
                                    <a id="downloadPdf" class="btn btn-sm px-3 btn-danger mr-1" target="_blank"><i
                                            class="fas fa-file-pdf mr-2"></i>Pdf</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table" id="izinTable" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="5%">#</th>
                                                <th scope="col" width="10%">Foto</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Tipe</th>
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
    @include('admin.izin.confirm')
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('library/dropify/js/dropify.js') }}"></script>

    <script>
        $(document).ready(function() {
            datatableCall('izinTable', '{{ route('admin.izin.index') }}', [{
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
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'tipe',
                    name: 'tipe'
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

            renderData();

            $("#bulan_filter, #tahun_filter").on("change", function() {
                $("#izinTable").DataTable().ajax.reload();
                renderData();
            });

            $("#confirmData").submit(function(e) {
                setButtonLoadingState("#confirmData .btn.btn-success", true);
                e.preventDefault();
                const kode = $("#confirmData #id").val();
                const url = `/admin/izin/${kode}`;
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#confirmData .btn.btn-success", false);
                    handleSuccess(response, "izinTable", "confirmModal");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#confirmData .btn.btn-success", false);
                    handleValidationErrors(error, "confirmData", ["tanggal_mulai", "tanggal_selesai",
                        "tipe", "alasan", "file"
                    ]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });

        const renderData = () => {
            const downloadPdf =
                `/admin/izin?mode=pdf&bulan=${$("#bulan_filter").val()}&tahun=${$("#tahun_filter").val()}`;
            $("#downloadPdf").attr("href", downloadPdf);
        }
    </script>
@endpush
