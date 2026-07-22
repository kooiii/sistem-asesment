@extends('layouts.app')

@section('content')

<h3>Dashboard Admin</h3>

<div class="row">

<div class="col-md-3">
<div class="card card-custom p-3">
<h5>Total Guru</h5>
<h2>{{ $totalGuru }}</h2>
</div>
</div>

<div class="col-md-3">
<div class="card card-custom p-3">
<h5>Total Siswa</h5>
<h2>{{ $totalSiswa }}</h2>
</div>
</div>

<div class="col-md-3">
<div class="card card-custom p-3">
<h5>Total Kelas</h5>
<h2>{{ $totalKelas }}</h2>
</div>
</div>

<div class="col-md-3">
<div class="card card-custom p-3">
<h5>Total Mapel</h5>
<h2>{{ $totalMapel }}</h2>
</div>
</div>

</div>

<div class="card mt-4">

<div class="card-body">

<h5>Informasi</h5>

<hr>

Administrator bertugas mengelola data guru, siswa, kelas, mata pelajaran serta laporan sistem.

</div>

</div>

@endsection