<table>
    <thead>
        <tr>
            <th height="20" colspan="6" style="border: 1px solid black; text-align: center; font-weight: bold;">
                LAPORAN DATA BARANG GUDANG BAWAH</th>
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
        @foreach ($barangBawahs as $barangBawah)
            <tr>
                <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid black;">{{ $barangBawah->barang->nama }}</td>
                <td style="border: 1px solid black; text-align: center;">{{ $barangBawah->qty }}</td>
                <td style="border: 1px solid black;">
                    {{ $barangBawah->barang->unit->nama == 'Kosong' ? '' : $barangBawah->barang->unit->nama }}
                </td>
                <td style="border: 1px solid black;">{{ $barangBawah->barang->kategori->nama }}</td>
                <td style="border: 1px solid black;">{{ $barangBawah->deskripsi ? null : '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
