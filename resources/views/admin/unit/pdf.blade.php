@extends('layouts.pdf')

@section('title', 'Unit')

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
                    <th style="">Nama</th>
                </tr>
            </thead>
            <tbody valign="top">
                @if ($units->isEmpty())
                    <tr>
                        <td colspan="2" align="center">Data @yield('title') kosong</td>
                    </tr>
                @else
                    @foreach ($units as $unit)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>{{ $unit->nama }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
@endpush
