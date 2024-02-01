@extends('layouts.pdf')

@section('title', 'Izin')

@push('style')
@endpush

@section('main')
    <div>
        <table width="100%" border="0" cellpadding="2.5" cellspacing="0">
            <tbody>
                <tr>
                    <td>Nama</td>
                    <td style="align: cemter;">:</td>
                    <td>{{ $izin->user->nama }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td style="align: cemter;">:</td>
                    <td>{{ $izin->user->jabatan }} </td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td style="align: cemter;">:</td>
                    <td>{{ ($izin->tanggal_selesai == null) ? formatTanggal($izin->tanggal_mulai) : formatTanggal($izin->tanggal_mulai) . ' - ' . formatTanggal($izin->tanggal_selesai) }}</td>
                </tr>
                <tr>
                    <td>Tipe</td>
                    <td style="align: cemter;">:</td>
                    <td>{{ $izin->tipe }}</td>
                </tr>
                <tr>
                    <td>Alasan</td>
                    <td style="align: cemter;">:</td>
                    <td>{{ $izin->alasan }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
@endpush