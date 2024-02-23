@extends('layouts.pdf')

@section('title', 'Rekap Presensi')

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
                    <th width="3%">No</th>
                    <th width="15%">Nama</th>
                    @foreach ($labels as $label)
                        <th colspan="2">{{ $label }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>
            <tbody valign="top">
                @foreach ($presensi_data as $row)
                    @php
                        $jumlah_masuk = 0;
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td>{{ $row['nama'] }}</td>
                        @foreach ($row['presensi'] as $p)
                            <td style="text-align: center">
                                {{ $p['masuk'] == 0 ? '-' : 'v' }}
                            </td>
                            <td style="text-align: center">
                                {{ $p['keluar'] == 0 ? '-' : 'v' }}
                            </td>
                            @if ($p['masuk'] == 1)
                                @php
                                    $jumlah_masuk++;
                                @endphp
                            @endif
                        @endforeach
                        <td style="text-align: center">
                            {{ $jumlah_masuk }}
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
@endsection

@push('scripts')
@endpush
