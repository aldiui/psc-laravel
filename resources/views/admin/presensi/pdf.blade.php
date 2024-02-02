@extends('layouts.pdf')

@section('title', 'Rekap Presensi')

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
                    <th width="3%">No</th>
                    <th width="15%">Nama</th>
                    @foreach ($labels as $label)
                        <th colspan="2">{{ $label }}</th>
                    @endforeach
                </tr>
            </thead> 
            <tbody valign="top">
                @foreach($presensi_data as $row)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $row['nama']}}</td>
                    @foreach ($row['presensi'] as $p)
                        <td style="text-align: center; background-color: {{ $p['masuk'] == 0 ? 'red' : 'green' }}; color:white">
                            {{ $p['masuk'] }}
                        </td>
                        <td style="text-align: center; background-color: {{ $p['keluar'] == 0 ? 'red' : 'green' }}; color:white">
                            {{ $p['keluar'] }}
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
@endpush