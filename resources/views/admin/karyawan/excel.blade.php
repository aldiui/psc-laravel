<table>
    <thead>
        <tr>
            <th height="20" colspan="5" style="border: 1px solid black; text-align: center; font-weight: bold;">
                LAPORAN DATA KARYAWAN</th>
        </tr>
        <tr>
            <th width="5" style="border: 1px solid black; text-align: center; font-weight: bold;">No</th>
            <th width="45" style="border: 1px solid black; text-align: center; font-weight: bold;">Nama</th>
            <th width="30" style="border: 1px solid black; text-align: center; font-weight: bold;">Email</th>
            <th width="15" style="border: 1px solid black; text-align: center; font-weight: bold;">Jabatan</th>
            <th width="20" style="border: 1px solid black; text-align: center; font-weight: bold;">No Hp</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($karyawans as $karyawan)
            <tr>
                <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid black;">{{ $karyawan->nama }}</td>
                <td style="border: 1px solid black;">{{ $karyawan->email }}</td>
                <td style="border: 1px solid black;">{{ $karyawan->jabatan }}</td>
                <td style="border: 1px solid black;">{{ $karyawan->no_hp }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
