@extends('layouts.pdf')

@section('title', 'Barang')

@push('style')
@endpush

@section('main')
    <div>
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
                @foreach($barangs as $barang)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $barang->nama }}</td>
                    <td style="text-align: center;">{{ $barang->qty }}</td>
                    <td>{{ $barang->unit->nama == "Kosong" ? "" : $barang->unit->nama }}</td>
                    <td>{{ $barang->kategori->nama }}</td>
                    <td>{{ $barang->deskripsi ? null : "-" }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
@endpush