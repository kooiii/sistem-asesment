<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Rapor Siswa</title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
            color:#000;
        }

        h2,h3{
            text-align:center;
            margin:0;
        }

        p{
            margin:3px 0;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }

        table,th,td{
            border:1px solid #000;
        }

        th,td{
            padding:8px;
        }

        th{
            background:#f2f2f2;
        }

        .text-center{
            text-align:center;
        }

        .text-right{
            text-align:right;
        }

        .identitas{
            border:none;
            margin-top:20px;
        }

        .identitas td{
            border:none;
            padding:4px;
        }

        .footer{
            margin-top:50px;
            width:100%;
        }

        .footer td{
            border:none;
            text-align:center;
        }

    </style>

</head>

<body>

    <div style="text-align:right; margin-bottom:15px;">
    <a href="{{ route('rapor.pdf', $siswa->id) }}"
       style="
           display:inline-block;
           padding:8px 15px;
           background:#dc3545;
           color:#fff;
           text-decoration:none;
           border-radius:5px;
       ">
        Cetak PDF
    </a>

    <a href="{{ route('rapor.index') }}"
       style="
           display:inline-block;
           padding:8px 15px;
           background:#6c757d;
           color:#fff;
           text-decoration:none;
           border-radius:5px;
           margin-left:5px;
       ">
        Kembali
    </a>
</div>

    <h2>RAPOR HASIL BELAJAR</h2>

    <h3>SMK NEGERI 1 SUNGAI TEBELIAN</h3>

    <table class="identitas">

        <tr>

            <td width="180">

                Nama Siswa

            </td>

            <td width="10">:</td>

            <td>

                {{ $siswa->nama }}

            </td>

        </tr>

        <tr>

            <td>

                Kelas

            </td>

            <td>:</td>

            <td>

                {{ $siswa->kelas->nama_kelas }}

            </td>

        </tr>

        <tr>

            <td>

                Mata Pelajaran

            </td>

            <td>:</td>

            <td>

                {{ $mapel->nama_mapel }}

            </td>

        </tr>

        <tr>

            <td>

                Tahun Ajaran

            </td>

            <td>:</td>

            <td>

                {{ $tahun->tahun_ajaran }} - Semester {{ $tahun->semester }}

            </td>

        </tr>

    </table>

    <table>

        <thead>

            <tr>

                <th width="60">

                    No

                </th>

                <th>

                    Komponen Penilaian

                </th>

                <th width="100">

                    Bobot

                </th>

                <th width="100">

                    Nilai

                </th>

            </tr>

        </thead>

        <tbody>

            <tr>

                <td class="text-center">

                    1

                </td>

                <td>

                    Nilai Formatif

                </td>

                <td class="text-center">

                    50%

                </td>

                <td class="text-center">

                    {{ number_format($formatif,2) }}

                </td>

            </tr>

            <tr>

                <td class="text-center">

                    2

                </td>

                <td>

                    Sumatif Tengah Semester (STS)

                </td>

                <td class="text-center">

                    15%

                </td>

                <td class="text-center">

                    {{ number_format($sts,2) }}

                </td>

            </tr>

            <tr>

                <td class="text-center">

                    3

                </td>

                <td>

                    Sumatif Akhir Semester (SAS)

                </td>

                <td class="text-center">

                    20%

                </td>

                <td class="text-center">

                    {{ number_format($sas,2) }}

                </td>

            </tr>

            <tr>

                <td class="text-center">

                    4

                </td>

                <td>

                    Sikap & Presensi

                </td>

                <td class="text-center">

                    15%

                </td>

                <td class="text-center">

                    {{ number_format($nilaiSikapPresensi,2) }}

                </td>

            </tr>

        </tbody>

        <tfoot>

            <tr>

                <th colspan="3">

                    Nilai Akhir

                </th>

                <th class="text-center">

                    {{ number_format($nilaiAkhir,2) }}

                </th>

            </tr>

        </tfoot>

    </table>

    <br>

    <table>

        <tr>

            <th width="180">

                Predikat

            </th>

            <td>

                {{ $predikat }}

            </td>

        </tr>

        <tr>

            <th>

                Deskripsi

            </th>

            <td>

                {{ $deskripsi }}

            </td>

        </tr>

    </table>

    <table class="footer">

        <tr>

            <td></td>

            <td>

                Sintang,

                {{ now()->translatedFormat('d F Y') }}

                <br><br><br><br>

                <strong>

                    {{ $guru->nama }}

                </strong>

                <br>

                NIP.

                {{ $guru->nip }}

            </td>

        </tr>

    </table>

</body>

</html>