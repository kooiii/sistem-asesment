@extends('layouts.app')

@section('content')

<div class="row">

<div class="col-md-3">

<div class="card border-primary">

<div class="card-body text-center">

<h2>

{{ $totalSiswa }}

</h2>

<p>

Siswa

</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card border-success">

<div class="card-body text-center">

<h2>

{{ $totalTP }}

</h2>

<p>

TP

</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card border-warning">

<div class="card-body text-center">

<h2>

{{ $totalFormatif }}

</h2>

<p>

Nilai Formatif

</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card border-danger">

<div class="card-body text-center">

<h2>

{{ $totalSumatif }}

</h2>

<p>

Nilai Sumatif

</p>

</div>

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

        <div class="card shadow mb-4">

    <div class="card-header bg-primary text-white">

        <h5 class="mb-0">

            Context Mengajar

        </h5>

    </div>

    <div class="card-body">

        <form
            action="{{ route('ganti.context') }}"
            method="POST">

            @csrf

            <div class="row">
                <div class="col-md-5">
                    <label>
                        Kelas Aktif
                    </label>

                    <select
                        name="kelas_id"
                        class="form-control">

                        @foreach($guru->kelas as $kelas)

                        <option
                            value="{{ $kelas->id }}"
                            {{ session('kelas_aktif')==$kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-5">
                    <label>
                        Mata Pelajaran Aktif
                    </label>

                    <select
                        name="mapel_id"
                        class="form-control">

                        @foreach($guru->mapel as $mapel)

                        <option
                            value="{{ $mapel->id }}"
                            {{ session('mapel_aktif')==$mapel->id ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>

                        @endforeach

                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button
                        class="btn btn-success w-100">
                        Terapkan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="alert alert-info">

<b>Kelas Aktif :</b>

{{ optional($guru->kelas->where('id',session('kelas_aktif'))->first())->nama_kelas }}

<br>

<b>Mapel Aktif :</b>

{{ optional($guru->mapel->where('id',session('mapel_aktif'))->first())->nama_mapel }}

</div>

@endsection