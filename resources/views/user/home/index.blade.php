@extends('layouts.app')

@section('title', 'Home')
@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endpush

@section('main')
@php
    $bulans = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
@endphp
    <div class="main-content mb-5 pb-5">
        <section class="section">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="text-dark mb-1">Selamat Datang, </div>
                    <div class="text-dark mb-1">{{ Auth::user()->nama }} ( {{ Auth::user()->jabatan }} )</div>
                </div>
            </div>
            <div class="row no-gutters mb-0">
                <div class="col-6">
                    <div class="card bg-success mr-1">
                        <div class="card-body text-center">
                            <div class="mb-2">Presensi Masuk</div>
                            <div class="mb-2">{{ $presensi ? $presensi->clock_in : "00:00:00" }}</div>
                            <div>{{ $presensi ? ($presensi->alasan_in ? "Diluar Radius" : "Dalam Radius") : "Belum Ada" }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card bg-danger ml-1">
                        <div class="card-body text-center">
                            <div class="mb-2">Presensi Keluar</div>
                            <div class="mb-2">{{ $presensi ? ($presensi->clock_out ?? "00:00:00"): "00:00:00" }}</div>
                            <div>{{ $presensi ? ($presensi->alasan_out ? "Diluar Radius" : "Belum Ada") : "Belum Ada" }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-0">
                <div class="card-header">
                    <h4 class="text-dark">Data Riwayat Presensi</h4>
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
                        <table class="table" id="presensiTable">
                            <thead>
                                <tr>
                                    <th scope="col">Presensi Masuk</th>
                                    <th scope="col">Presensi Keluar</th>
                                    <th scope="col">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>                                
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            datatableCall('presensiTable', '{{ route('presensi') }}', [
                { data: 'presensi_masuk', name: 'presensi_masuk' },
                { data: 'presensi_keluar', name: 'presensi_keluar' },
                { data: 'catatan', name: 'catatan' },  
            ]);

            $("#bulan_filter, #tahun_filter").on("change", function () {
                $("#presensiTable").DataTable().ajax.reload();
            });
        });
    </script>
@endpush