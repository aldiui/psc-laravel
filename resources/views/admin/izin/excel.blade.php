<table>
    <thead>
        <tr>
            <th height="20" colspan="6" style="border: 1px solid black; text-align: center; font-weight: bold;">
                LAPORAN DATA IZIN {{ $bulanTahun }}</th>
        </tr>
        <tr>
            <th width="5" style="border: 1px solid black; text-align: center; font-weight: bold;">No</th>
            <th width="30" style="border: 1px solid black; text-align: center; font-weight: bold;">Nama</th>
            <th width="50" style="border: 1px solid black; text-align: center; font-weight: bold;">Tanggal</th>
            <th width="10" style="border: 1px solid black; text-align: center; font-weight: bold;">Tipe</th>
            <th width="30" style="border: 1px solid black; text-align: center; font-weight: bold;">Alasan</th>
            <th width="30" style="border: 1px solid black; text-align: center; font-weight: bold;">Persetujuan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($izins as $izin)
            <tr>
                <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid black;">{{ $izin->user->nama }}</td>
                <td style="border: 1px solid black;">
                    {{ $izin->tanggal_selesai == null ? formatTanggal($izin->tanggal_mulai) : formatTanggal($izin->tanggal_mulai) . ' - ' . formatTanggal($izin->tanggal_selesai) }}
                </td>
                <td style="border: 1px solid black; text-align: center;">{{ $izin->tipe }}</td>
                <td style="border: 1px solid black;">{{ $izin->alasan }}</td>
                <td style="border: 1px solid black;">{{ $izin->approval->nama }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" align="center">Data @yield('title') kosong</td>
            </tr>
        @endforelse
    </tbody>
</table>
