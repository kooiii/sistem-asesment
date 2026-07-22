@extends('layouts.app')

@section('content')

<div class="row">

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

    <div class="col-md-3">
        <div class="card card-custom p-3">
            <h5>Total Nilai</h5>
            <h2>{{ $totalNilai }}</h2>
        </div>
    </div>
</div>

<div class="card card-custom mt-4">

    <div class="card-body">

            <h5>Informasi</h5>
            <hr>
                Selamat datang di Sistem Penilaian Kurikulum Merdeka.

                Silahkan memilih menu di sebelah kiri untuk memulai menginput nilai.
            </div>
        </div>

@endsection