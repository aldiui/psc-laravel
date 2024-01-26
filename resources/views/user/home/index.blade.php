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
            <div class="card mb-3 p-1 rounded-pill">
                <div class="card-body d-flex justify-content-between align-content-center py-2">
                    <div>
                        <div class="small mb-1">Selamat Datang, </div>
                        <div class="mb-1 font-weight-bold">{{ Auth::user()->nama }}</div>
                        <div class="small">{{ Auth::user()->jabatan }}</div>
                    </div>
                    <div style="background-image: url('{{ asset('/storage/img/karyawan/' . (Auth::user()->image ?? 'default.png')) }}');"
                        class="img-big d-block "></div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="small">{{ formatTanggal() }}</div>
                        <div class="small" id="jam"></div>
                    </div>
                    <div class="row no-gutters mb-0">
                        <div class="col-6 d-flex align-items-center">
                            <div class="mr-2">
                                <div class="p-2 {{ $presensi ? 'bg-success' : 'bg-secondary' }} rounded">
                                    <i class="far {{ $presensi ? 'fa-check-circle' : 'fa-times-circle' }}  text-lg text-white"></i>
                                </div>
                            </div>
                            <div class="{{ $presensi ? 'text-dark' : 'text-secondary' }}">
                                <div class="small">Masuk</div>
                                <div class="text-lg">{{ $presensi && $presensi->clock_in ? $presensi->clock_in : '00:00:00' }}</div>
                            </div>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            <div class="mr-2">
                                <div class="p-2 {{ $presensi && $presensi->clock_out ? 'bg-success' : 'bg-secondary' }} rounded">
                                    <i class="far {{ $presensi && $presensi->clock_out ? 'fa-check-circle' : 'fa-times-circle' }}  text-lg text-white"></i>
                                </div>
                            </div>
                            <div class="{{ $presensi && $presensi->clock_out ? 'text-dark' : 'text-secondary' }}">
                                <div class="small">Keluar</div>
                                <div class="text-lg">{{ $presensi && $presensi->clock_out ? $presensi->clock_out : '00:00:00' }}</div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-around">
                        <div>
                            <a class="text-decoration-none text-center text-info"
                                href="{{ url('izin') }}"><i class="d-block mb-2 text-lg fas fa-calendar"></i> <div class="text-mini text-center text-dark">Izin</div></a>
                        </div>
                        <div>
                            <a class="text-decoration-none text-center text-success"
                                href="{{ url('presensi') }}"><i class="d-block mb-2 text-lg fas fa-camera"></i> <div class="text-mini text-center text-dark">Presensi</div></a>
                        </div>
                        <div>
                            <a class="text-decoration-none text-center text-warning"
                                href="{{ url('stok') }}"><i class="d-block mb-2 text-lg fas fa-clipboard-list"></i> <div class="text-mini text-center text-dark">Stok</div></a>
                        </div>
                        <div>
                            <a class="text-decoration-none text-center text-primary"
                                href="{{ url('profil') }}"><i class="d-block mb-2 text-lg fas fa-user"></i> <div class="text-mini text-center text-dark">Profil</div></a>
                        </div>
                    </div>
                </div>
            </div>
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
            <div class="table-responsive d-none d-lg-block">
                <table class="table" id="presensiTable" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Presensi Masuk</th>
                            <th scope="col">Presensi Keluar</th>
                            <th scope="col">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>                                
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
            setInterval(updateJam, 1000);

            datatableCall('presensiTable', '{{ route('presensi') }}', [
                { data: 'tgl', name: 'tgl' },
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