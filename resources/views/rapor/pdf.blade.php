<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<title>Rapor</title>

<style>

body{

    font-family: DejaVu Sans;

    font-size:12px;

}

table{

    width:100%;

    border-collapse:collapse;

    margin-top:10px;

}

th,td{

    border:1px solid #000;

    padding:6px;

}

.text-center{

    text-align:center;

}

.text-right{

    text-align:right;

}

.no-border{

    border:none;

}

.judul{

    text-align:center;

    font-size:18px;

    font-weight:bold;

    margin-bottom:5px;

}

.subjudul{

    text-align:center;

    margin-bottom:20px;

}

</style>

</head>

<body>

<div class="judul">

LAPORAN HASIL BELAJAR PESERTA DIDIK

</div>

<div class="subjudul">

SMK NEGERI 1 SUNGAI TEBELIAN

</div>

<table>

<tr>

<td width="25%">Nama Peserta Didik</td>

<td width="2%">:</td>

<td>{{ $siswa->nama }}</td>

</tr>

<tr>

<td>Kelas</td>

<td>:</td>

<td>{{ $siswa->kelas->nama_kelas }}</td>

</tr>

<tr>

<td>Mata Pelajaran</td>

<td>:</td>

<td>{{ $mapel->nama_mapel }}</td>

</tr>

<tr>

<td>Guru Pengampu</td>

<td>:</td>

<td>{{ $guru->nama }}</td>

</tr>

<tr>

<td>Tahun Ajaran</td>

<td>:</td>

<td>{{ $tahun->tahun }}</td>

</tr>

</table>

<br>

<table>

<tr>

<th width="8%">No</th>

<th>Komponen Penilaian</th>

<th width="20%">Nilai</th>

</tr>

<tr>

<td class="text-center">1</td>

<td>Rata-rata Formatif</td>

<td class="text-center">{{ number_format($formatif,2) }}</td>

</tr>

<tr>

<td class="text-center">2</td>

<td>PH Pengetahuan</td>

<td class="text-center">{{ number_format($phPengetahuan,2) }}</td>

</tr>

<tr>

<td class="text-center">3</td>

<td>STS</td>

<td class="text-center">{{ number_format($sts,2) }}</td>

</tr>

<tr>

<td class="text-center">4</td>

<td>SAS</td>

<td class="text-center">{{ number_format($sas,2) }}</td>

</tr>

<tr>

<th colspan="2">

Nilai Pengetahuan

</th>

<th class="text-center">

{{ number_format($nilaiPengetahuan,2) }}

</th>

</tr>

<tr>

<td class="text-center">5</td>

<td>PH Keterampilan</td>

<td class="text-center">{{ number_format($phKeterampilan,2) }}</td>

</tr>

<tr>

<th colspan="2">

Nilai Keterampilan

</th>

<th class="text-center">

{{ number_format($nilaiKeterampilan,2) }}

</th>

</tr>

<tr>

<th colspan="2">

Nilai Akhir

</th>

<th class="text-center">

{{ number_format($nilaiAkhir,2) }}

</th>

</tr>

</table>

<br>

<table>

<tr>

<th width="30%">

Sikap

</th>

<td>

{{ $sikap->sikap ?? '-' }}

</td>

</tr>

<tr>

<th>

Presensi

</th>

<td>

{{ $sikap->presensi ?? '-' }}

</td>

</tr>

<tr>

<th>

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

<br><br><br>

<table class="no-border">

<tr class="no-border">

<td class="no-border" width="55%"></td>

<td class="no-border" align="center">

Sintang, {{ date('d F Y') }}

<br><br>

Guru Mata Pelajaran

<br><br><br><br><br>

<b>

{{ strtoupper($guru->nama) }}

</b>

</td>

</tr>

</table>

</body>
</html>