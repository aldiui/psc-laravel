@extends('layouts.admin')

@section('title', 'Beranda')

@push('style')
@endpush

@section('main')
    @php
        $bulans = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    @endphp
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Unit</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUnit }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kategori</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalKategori }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fas fa-box"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Barang</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalBarang }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Karyawan</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalKaryawan }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Stok</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="bulan_filter" class="form-label">Bulan</label>
                                        <select name="bulan_filter" id="bulan_filter" class="form-control">
                                            @foreach ($bulans as $key => $value)
                                                <option value="{{ $key + 1 }}"
                                                    {{ $key + 1 == date('m') ? 'selected' : '' }}>{{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tahun_filter" class="form-label">Tahun</label>
                                        <select name="tahun_filter" id="tahun_filter" class="form-control">
                                            @for ($i = now()->year; $i >= now()->year - 4; $i--)
                                                <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <canvas id="myChart" height="182"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            renderData();

            $("#bulan_filter, #tahun_filter").on("change", function() {
                renderData();
            });
        });

        const renderData = () => {
            const successCallback = function(response) {
                createChart(response.data.labels, response.data.stokMasuk, response.data.stokKeluar);
            };

            const errorCallback = function(error) {
                console.error(error);
            };

            const url = `/admin?bulan=${$("#bulan_filter").val()}&tahun=${$("#tahun_filter").val()}`;

            ajaxCall(url, "GET", null, successCallback, errorCallback);
        };
    </script>
@endpush
