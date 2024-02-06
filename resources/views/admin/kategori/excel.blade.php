<table>
    <thead>
        <tr>
            <th height="20" colspan="3" style="border: 1px solid black; text-align: center; font-weight: bold;">
                LAPORAN DATA KATEGORI</th>
        </tr>
        <tr>
            <th width="5" style="border: 1px solid black; text-align: center; font-weight: bold;">No</th>
            <th width="20" style="border: 1px solid black; text-align: center; font-weight: bold;">Nama</th>
            <th width="50" style="border: 1px solid black; text-align: center; font-weight: bold;">Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kategoris as $kategori)
            <tr>
                <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid black;">{{ $kategori->nama }}</td>
                <td style="border: 1px solid black;">{{ $kategori->deskripsi }}</td>
            </tr>
        @endforeach
    </tbody>
</table
