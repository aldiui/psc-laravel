<table>
    <thead>
        <tr>
            <th height="20" colspan="6" style="border: 1px solid black; text-align: center; font-weight: bold;">
                LAPORAN DATA BARANG GUDANG ATAS</th>
        </tr>
        <tr>
            <th width="5" style="border: 1px solid black; text-align: center; font-weight: bold;">No</th>
            <th width="45" style="border: 1px solid black; text-align: center; font-weight: bold;">Nama</th>
            <th width="9" style="border: 1px solid black; text-align: center; font-weight: bold;">Qty</th>
            <th width="10" style="border: 1px solid black; text-align: center; font-weight: bold;">Unit</th>
            <th width="15" style="border: 1px solid black; text-align: center; font-weight: bold;">Kategori</th>
            <th width="50" style="border: 1px solid black; text-align: center; font-weight: bold;">Deskripsi</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($barangs as $barang)
            <tr>
                <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid black;">{{ $barang->nama }}</td>
                <td style="border: 1px solid black; text-align: center;">{{ $barang->qty }}</td>
                <td style="border: 1px solid black;">{{ $barang->unit->nama == 'Kosong' ? '' : $barang->unit->nama }}
                </td>
                <td style="border: 1px solid black;">{{ $barang->kategori->nama }}</td>
                <td style="border: 1px solid black;">{{ $barang->deskripsi ? null : '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
