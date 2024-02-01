@extends('layouts.admin')

@section('title', 'Rekap Presensi')

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
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="bulan_filter" class="form-label">Bulan</label>
                                            <select name="bulan_filter" id="bulan_filter" class="form-control">
                                                @foreach ($bulans as $key => $value)
                                                    <option value="{{ $key + 1 }}" {{ (($key + 1) == date('m')) ? 'selected' : ''}}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tahun_filter" class="form-label">Tahun</label>
                                            <select name="tahun_filter" id="tahun_filter" class="form-control">
                                                @for ($i = now()->year; $i >= now()->year - 4; $i--)
                                                    <option value="{{ $i }}" {{ ($i == date('Y')) ? 'selected' : ''}}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="presensiTable" class="table table-bordered table-striped" width="100%">
                                        
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
    <script>
        $(document).ready(function() {
            renderData();
            $("#bulan_filter, #tahun_filter").on("change", function () {
                renderData();
            });     
        });

        const renderData = () => {
            const successCallback = function (response) {
                updateTable(response.data);
                console.log(response.data)
            };

            const errorCallback = function (error) {
                console.error(error);
            };

            const url = `/admin/rekap-presensi?bulan=${$("#bulan_filter").val()}&tahun=${$("#tahun_filter").val()}`;

            ajaxCall(url, "GET", null, successCallback, errorCallback);
        };



    </script>
@endpush