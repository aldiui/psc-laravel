@extends('layouts.pdf')

@section('title', 'Barang Gudang Bawah')

@push('style')
@endpush

@section('main')
    <div>
        <center>
            <u>
                <h3>Data @yield('title')</h3>
            </u>
        </center>
        <br>
        <table width="100%" border="1" cellpadding="2.5" cellspacing="0">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Nama</th>
                    <th width="5%">Qty</th>
                    <th width="10%">Unit</th>
                    <th width="15%">Kategori</th>
                    <th style="">Deskripsi</th>
                </tr>
            </thead>
            <tbody valign="top">
                @if ($barangBawahs->isEmpty())
                    <tr>
                        <td colspan="6" align="center">Data @yield('title') kosong</td>
                    </tr>
                @else
                    @foreach ($barangBawahs as $barangBawah)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>{{ $barangBawah->barang->nama }}</td>
                            <td style="text-align: center;">{{ $barangBawah->qty }}</td>
                            <td>{{ $barangBawah->barang->unit->nama == 'Kosong' ? '' : $barangBawah->barang->unit->nama }}
                            </td>
                            <td>{{ $barangBawah->barang->kategori->nama }}</td>
                            <td>{{ $barangBawah->deskripsi ? null : '-' }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
@endpush
