<table>
    <thead>
        <tr>
            <th height="20" colspan="{{3 + (count($labels)*2)}}"  style="border: 1px solid black; text-align: center; font-weight: bold;">
                LAPORAN DATA PRESENSI {{ $bulanTahun }}</th>
        </tr>
        <tr>
            <th width="5" style="border: 1px solid black; text-align: center; font-weight: bold;">No</th>
            <th width="40" style="border: 1px solid black; text-align: center; font-weight: bold;">Nama</th>
            @foreach ($labels as $label)
            <th width="6" colspan='2' style="border: 1px solid black; text-align: center; font-weight: bold;">{{$label}}</th>
            @endforeach
            <th width="8" style="border: 1px solid black; text-align: center; font-weight: bold;">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($presensiData as $presensi)
        @php
            $jumlah_masuk = 0;
        @endphp
        <tr>
            <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
            <td style="border: 1px solid black; ">{{ $presensi['nama'] }}</td>
            @foreach ($presensi['presensi'] as $p)
            <td width='3' style="border: 1px solid black; text-align: center">
                {{ $p['masuk'] == 0 ? '-' : 'v' }}
            </td>
            <td width='3' style="border: 1px solid black; text-align: center">
                {{ $p['keluar'] == 0 ? '-' : 'v' }}
            </td>
            @if ($p['masuk'] == 1)
                @php
                    $jumlah_masuk++;
                @endphp
            @endif
            @endforeach
            <td style="border: 1px solid black; text-align: center;">{{ $jumlah_masuk }}
</td>
        </tr>
        @endforeach

    </tbody>
</table>
