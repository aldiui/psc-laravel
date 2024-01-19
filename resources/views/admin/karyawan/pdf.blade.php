@extends('layouts.pdf')

@section('title', 'Karyawan')

@push('style')
    <div>
        <table width="100%" border="1" cellpadding="2.5" cellspacing="0">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Nama</th>
                    <th width="35%">Email</th>
                    <th width="30%">Jabatan</th>
                    <th width="30%">No Hp</th>
                </tr>
            </thead>    
            <tbody valign="top">
                @foreach($karyawans as $karyawan)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $karyawan->nama }}</td>
                    <td>{{ $karyawan->email }}</td>
                    <td>{{ $karyawan->jabatan }}</td>
                    <td>{{ $karyawan->no_hp }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endpush

@section('main')
@endsection

@push('scripts')
@endpush