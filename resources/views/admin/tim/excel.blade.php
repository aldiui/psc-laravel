<table>
    <thead>
        <tr>
            <th height="20" colspan="3" style="border: 1px solid black; text-align: center; font-weight: bold;">LAPORAN DATA TIM</th>
        </tr>
        <tr>
            <th width="5" style="border: 1px solid black; text-align: center; font-weight: bold;">No</th>
            <th width="20" style="border: 1px solid black; text-align: center; font-weight: bold;">Nama</th>
            <th width="50" style="border: 1px solid black; text-align: center; font-weight: bold;">Deskripsi</th>
        </tr>
    </thead>    
    <tbody>
        @foreach($tims as $tim)
        <tr>
            <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
            <td style="border: 1px solid black;">{{ $tim->nama }}</td>
            <td style="border: 1px solid black;">{{ $tim->deskripsi}}</td>
        </tr>
        @endforeach
    </tbody>
</table