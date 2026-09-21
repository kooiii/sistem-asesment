<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Laporan Nilai Siswa</title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        h2,
        h4 {
            margin: 0;
            text-align: center;
        }

        p {
            margin-top: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th {
            background: #e9ecef;
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        table td {
            border: 1px solid #000;
            padding: 5px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

    </style>

</head>

<body>

<h2>
    SMK NEGERI 1 SUNGAI TEBELIAN
</h2>

<h4>
    LAPORAN REKAP NILAI SISWA
</h4>

<p>
    Tahun Ajaran
    {{ $tahun->tahun_ajaran }}
    -
    Semester
    {{ $tahun->semester }}
</p>

<table>

    <thead>

        <tr>

            <th width="30">No</th>

            <th>Nama Siswa</th>

            <th>Kelas</th>

            <th>Mapel</th>

            <th>Formatif</th>

            <th>STS</th>

            <th>SAS</th>

            <th>Sikap</th>

            <th>Presensi</th>

            <th>Sikap & Presensi</th>

            <th>Nilai Akhir</th>

            <th>Predikat</th>

        </tr>

    </thead>

    <tbody>

        @forelse($laporan as $row)

            <tr>

                <td class="center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $row['nama'] }}
                </td>

                <td class="center">
                    {{ $row['kelas'] }}
                </td>

                <td>
                    {{ $row['mapel'] }}
                </td>

                <td class="center">
                    {{ number_format($row['formatif'], 2) }}
                </td>

                <td class="center">
                    {{ number_format($row['sts'], 2) }}
                </td>

                <td class="center">
                    {{ number_format($row['sas'], 2) }}
                </td>

                <td class="center">
                    {{ number_format($row['sikap'], 2) }}
                </td>

                <td class="center">
                    {{ number_format($row['presensi'], 2) }}
                </td>

                <td class="center">
                    {{ number_format($row['nilai_sikap_presensi'], 2) }}
                </td>

                <td class="center">

                    <strong>
                        {{ number_format($row['akhir'], 2) }}
                    </strong>

                </td>

                <td class="center">
                    {{ $row['predikat'] }}
                </td>

            </tr>

        @empty

            <tr>

                <td colspan="12" class="center">

                    Belum ada data nilai.

                </td>

            </tr>

        @endforelse

    </tbody>

</table>

<br>
<br>

<table style="width:100%;border:none;">

    <tr style="border:none;">

        <td style="border:none;"></td>

        <td style="border:none;text-align:center;width:250px;">

            Sintang,

            {{ date('d-m-Y') }}

            <br>
            <br>

            Guru Mata Pelajaran

            <br>
            <br>
            <br>
            <br>

            _________________________

        </td>

    </tr>

</table>

</body>

</html>