<table>
    <thead>
        <tr>
            <th width="5" style="border: 1px solid black; text-align: center; font-weight: bold;">No</th>
            <th width="15" style="border: 1px solid black; text-align: center; font-weight: bold;">Nama</th>
        </tr>
    </thead>    
    <tbody>
        @foreach($units as $unit)
        <tr>
            <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
            <td style="border: 1px solid black;">{{ $unit->nama }}</td>
        </tr>
        @endforeach
    </tbody>
</table>