@extends('layouts.pdf')

@section('title', 'Rekap Stok')

@push('style')
@endpush

@section('main')
    <div>
        <center>
            <u><h3>Data @yield('title') {{ $bulanTahun }}</h3></u>
        </center>
        <br>
        <table width="100%" border="1" cellpadding="2.5" cellspacing="0">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Total Barang</th>
                    <th>Jensi</th>
                </tr>
            </thead>    
            <tbody valign="top">
                @foreach($stoks as $stok)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ formatTanggal($stok->tanggal) }}</td>
                    <td>{{ $stok->user->nama }}</td>
                    <td>{{ $stok->detail_stoks_count }}</td>
                    <td>{{ $stok->jenis }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
@endpush