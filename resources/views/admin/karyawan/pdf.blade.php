@extends('layouts.pdf')

@section('title', 'Karyawan')

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
                    <th width="35%">Email</th>
                    <th width="20%">Password</th>
                    <th width="30%">Jabatan</th>
                    <th width="30%">No Hp</th>
                </tr>
            </thead>
            <tbody valign="top">
                @if ($karyawans->isEmpty())
                    <tr>
                        <td colspan="5" align="center">Data @yield('title') kosong</td>
                    </tr>
                @else
                    @foreach ($karyawans as $karyawan)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>{{ $karyawan->nama }}</td>
                            <td>{{ $karyawan->email }}</td>
                            <td>tasikmalaya</td>
                            <td>{{ $karyawan->jabatan }}</td>
                            <td>{{ $karyawan->no_hp }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
@endpush
