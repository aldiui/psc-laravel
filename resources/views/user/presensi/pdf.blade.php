@extends('layouts.pdf')

@section('title', 'Rekap Absensi')

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
        <table cellpadding="3">
            <tr>
                <td width="120px">Nama</td>
                <td>:</td>
                <td>{{ Auth::user()->nama }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ Auth::user()->jabatan }}</td>
            </tr>
            <tr>
                <td>Total Kehadiran</td>
                <td>:</td>
                <td>{{ $presensis->count() }} Hari</td>
            </tr>
        </table>
        <br>
        <table width="100%" border="1" cellpadding="2.5" cellspacing="0">
            <thead>
                <tr>
                    <th width="3%">No</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th width="40%">Tugas</th>
                </tr>
            </thead>
            <tbody valign="top">
                @if ($presensis->isEmpty())
                    <tr>
                        <td colspan="5" align="center">Data @yield('title') kosong</td>
                    </tr>
                @else
                    @foreach ($presensis as $row)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td style="text-align: center;">{{ formatTanggal($row->tanggal, 'j F Y') }}</td>
                            <td style="text-align: center;">
                                <div>{{ $row->jam_masuk }}</div>
                                <div>
                                    {!! $row->alasan_masuk
                                        ? "<span style='color:red'>Diluar Radius </span>"
                                        : "<span style='color:green'> Dalam Radius </span>" !!}
                                </div>
                                <div>
                                    {!! $row->alasan_masuk ? 'Keterangan : ' . $row->alasan_masuk : '' !!}
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div>{{ $row->jam_keluar }}</div>
                                @if ($row->jam_keluar)
                                    <div>
                                        {!! $row->alasan_keluar
                                            ? "<span style='color:red'>Diluar Radius </span>"
                                            : "<span style='color:green'> Dalam Radius </span>" !!}
                                    </div>
                                    <div>
                                        {!! $row->alasan_keluar ? 'Keterangan : ' . $row->alasan_keluar : '' !!}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if ($row->tugas)
                                    <ul style="padding-left: 20px; margin:0%">
                                        @foreach (stringToArray($row->tugas) as $task)
                                            <li>{{ $task }}</li>
                                        @endforeach
                                        @if ($row->catatan)
                                            <li>{{ $row->catatan }}</li>
                                        @endif
                                    </ul>
                                @endif
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
