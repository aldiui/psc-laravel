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
        <table width="100%" cellpadding="2.5" cellspacing="0">
            <tbody valign="top">
                @if ($stoks->isEmpty())
                    <tr>
                        <td colspan="6" align="center">Data @yield('title') kosong</td>
                    </tr>
                @else
                    @foreach ($stoks as $stok)
                        <tr>
                            <td colspan="3" style="text-align: center;">
                                <b>
                                    Data ke - {{ $loop->iteration }}
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">Tanggal</td>
                            <td width="3%">:</td>
                            <td>{{ formatTanggal($stok->tanggal) }}</td>
                        </tr>
                        <tr>
                            <td width="20%">Nama </td>
                            <td width="3%">:</td>
                            <td>{{ $stok->user->nama }}</td>
                        </tr>
                        <tr>
                            <td width="20%">Total Barang </td>
                            <td width="3%">:</td>
                            <td>{{ $stok->detail_stoks_count }}</td>
                        </tr>
                        <tr>
                            <td width="20%">Jenis </td>
                            <td width="3%">:</td>
                            <td>{{ $stok->jenis }}</td>
                        </tr>
                        <tr>
                            <td width="20%">Persetujuan</td>
                            <td width="3%">:</td>
                            <td>{{ $stok->approval->nama }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <br>
                                <table border="1" width="100%" cellpadding="2.5" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="35%">Barang</th>
                                            <th width="10%">Qty</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stok->detailStoks as $detail_stok)
                                            <tr>
                                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                <td>{{ $detail_stok->barang->nama }}</td>
                                                <td style="text-align: center;">{{ $detail_stok->qty.' '.$detail_stok->barang->unit->nama }}</td>
                                                <td>{{ $detail_stok->deskripsi }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <br>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
@endpush
