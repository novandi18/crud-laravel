<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href={{ asset("css/bootstrap.min.css") }}> --}}
    <title>{{ $title }}</title>
</head>

<body>
    <div style="width: 100%; text-align: center; margin-bottom: 2em">
        <h1>Data Mahasiswa</h1>
        <span style="margin-top: -20px">{{ $date }}</span>
    </div>

    <table width="100%" border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Prodi</th>
            </tr>
        </thead>
        <tbody style="text-align: center">
            @php
            $no = 1
            @endphp
            @foreach ($mahasiswa as $data)
            <tr>
                <th>{{ $no++ }}</th>
                <td>{{ $data->nim }}</td>
                <td>{{ $data->nama_mhs }}</td>
                <td>{{ $data->kelas_mhs }}</td>
                <td>{{ $data->prodi_mhs }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>