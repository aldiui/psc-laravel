@extends('layouts.pdf')

@section('title', 'Rekap Stok')

@push('style')
@endpush

@section('main')
    <div>
        <center>
            <u>
                <h3>Data @yield('title') {{ $bulanTahun }}</h3>
            </u>
        </center>
        <br>
        <table width="100%" border="1" cellpadding="2.5" cellspacing="0">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Total Barang</th>
                    <th>Jenis</th>
                    <th>Persetujuan</th>
                </tr>
            </thead>
            <tbody valign="top">
                @if ($stoks->isEmpty())
                    <tr>
                        <td colspan="5" align="center">Data @yield('title') kosong</td>
                    </tr>
                @else
                    @foreach ($stoks as $stok)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>{{ formatTanggal($stok->tanggal) }}</td>
                            <td>{{ $stok->user->nama }}</td>
                            <td>{{ $stok->detail_stoks_count }}</td>
                            <td>{{ $stok->jenis }}</td>
                            <td>{{ $stok->approval->nama }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
@endpush
