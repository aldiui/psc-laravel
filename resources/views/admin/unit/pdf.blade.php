@extends('layouts.pdf')

@section('title', 'Unit')

@push('style')
    <div>
        <table width="100%" border="1" cellpadding="2.5" cellspacing="0">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th style="">Nama</th>
                </tr>
            </thead>    
            <tbody valign="top">
                @foreach($units as $unit)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $unit->nama }}</td>
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