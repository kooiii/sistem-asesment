@extends('layouts.app')

@section('content')

<div class="container">

<h3>Input Presensi & Sikap</h3>

<form action="{{ route('presensi.store') }}" method="POST">

@csrf

<div class="mb-3">
    <label>Kelas</label>
    <select name="kelas" class="form-control"
            onchange="location='?kelas='+this.value">
        <option value="">-- Pilih Kelas --</option>
        @foreach($kelasGuru as $kelas)
        <option value="{{ $kelas->id }}"
            {{ $kelasDipilih==$kelas->id ? 'selected' : '' }}>
            {{ $kelas->nama_kelas }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Siswa</label>
    <select name="siswa_id" class="form-control">
        <option value="">-- Pilih Siswa --</option>
        @foreach($siswas as $siswa)
        <option value="{{ $siswa->id }}">
            {{ $siswa->nama }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Nilai Presensi</label>

    <input type="number"
            name="presensi"
            class="form-control">
</div>

<div class="mb-3">
    <label>Nilai Sikap</label>

    <input type="number"
            name="sikap"
            class="form-control">
</div>

<button class="btn btn-success">
    Simpan
</button>

<a href="{{ route('presensi.index') }}"
   class="btn btn-secondary">
   Kembali
</a>

</form>

</div>

@endsection