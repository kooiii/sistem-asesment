<!DOCTYPE html>
<html>
<head>

    <style>
        table{
            width:100%;
            border-collapse;
        }
        th,td{
            border:1px solid black;
            padding:8px;
        }

    </style>
</head>

<body>
    <h2 align="center">LAPORAN NILAI SISWA<br>SMK Negeri 1 Sungai Tebelian</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Formatif</th>
            <th>Sumatif</th>
            <th>Nilai Akhir</th>
        </tr>
        @foreach ($laporan as $l)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $l['nama'] }}</td>
            <td>{{ $l['kelas'] }}</td>
            <td>{{ $l['formatif'] }}</td>
            <td>{{ $l['sumatif'] }}</td>
            <td>{{ $l['akhir'] }}</td>
        </tr>
            
        @endforeach

    </table>

</body>
</html>