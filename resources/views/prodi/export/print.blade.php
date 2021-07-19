<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Prodi</th>
            <th>Jumlah Mahasiswa</th>
        </tr>
    </thead>
    <tbody>
        @php
        $no = 1
        @endphp
        @foreach($prodi as $data)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $data->nama_prodi }}</td>
            <td>{{ $data->jml_mhs }} Orang</td>
        </tr>
        @endforeach
    </tbody>
</table>