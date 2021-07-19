<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Prodi</th>
        </tr>
    </thead>
    <tbody>
        @php
        $no = 1
        @endphp
        @foreach($mahasiswa as $data)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $data->nim }}</td>
            <td>{{ $data->nama_mhs }}</td>
            <td>{{ $data->kelas_mhs }}</td>
            <td>{{ $data->prodi_mhs }}</td>
        </tr>
        @endforeach
    </tbody>
</table>